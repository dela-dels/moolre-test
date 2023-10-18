<?php

declare(strict_types=1);

namespace MoolrePayments\Core;

use PDO;
use PDOStatement;
use Throwable;

class Database
{
    private PDO|null $databaseConnection = null;

    private PDOStatement $statement;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $database = $_ENV['DB_DATABASE'];
        $user = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        try {
            $this->databaseConnection = $this->connect(host: $host, port: $port, database: $database, user: $user, password: $password);
        } catch (Throwable $th) {
            exit($th->getMessage());
            //throw $th;
        }
    }

    private function connect(string $host, string $port, string $database, string $user, string $password): PDO
    {
        return new PDO("mysql:host=$host;dbname=$database;port=$port;charset=utf8", $user, $password,
            [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

        //return new PDO('sqlite:database.sqlite:', null, null, array(PDO::ATTR_PERSISTENT => true));
    }

    public function connection(): PDO
    {
        return $this->databaseConnection;
    }

    public function query($query, array $params = []): static
    {
        $this->statement = $this->databaseConnection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function first()
    {
        return $this->statement->fetch();
    }

    public function all(): bool|array
    {
        return $this->statement->fetchAll();
    }
}
