<?php


namespace MoolrePayments\Services;

class GatewayService
{
    public function connect(): self
    {
        return $this;
    }

    public function processTransaction($data): string
    {
        $this->send($data);

        $results = [
            '100' => 'Successful',
            '200' => 'Failed'
        ];

        $key = array_rand($results);

        return $results[$key];
    }

    private function send($data)
    {
        //send transaction details to gateway
    }

    public function verifyTransaction(string $reference): string
    {
        $results = [
            '100' => 'Successful',
            '200' => 'Failed'
        ];

        $key = array_rand($results);

        return $results[$key];
    }
}