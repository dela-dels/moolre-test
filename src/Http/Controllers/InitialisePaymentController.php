<?php

namespace MoolrePayments\Http\Controllers;

use MoolrePayments\Services\GatewayService;

class InitialisePaymentController
{
    public function __invoke(): void
    {
        $errors = $this->validate(
            $data = json_decode(file_get_contents('php://input'))
        );

        if (!empty($errors)) {
            echo json_encode([
                'errors' => $errors
            ]);
        }

        $results = $this->processPaymentFromGateway($data);

        if ($results === 'Succesful') {
            echo json_encode([
                'status' => $results,
                'message' => 'Transaction Successful',
                'reference' => substr(hash('sha1', str_shuffle(microtime())), 0, 10)
            ]);
        }

        echo json_encode([
            'status' => $results,
            'message' => 'Transaction Successful',
            'reference' => substr(hash('sha1', str_shuffle(microtime())), 0, 10)
        ]);
    }

    protected function processPaymentFromGateway($data): string
    {
        $connection = (new GatewayService())->connect();

        return $connection->processTransaction($data);
    }

    protected function validate($data): array
    {
        $errors = [];

        if (!isset($data->transaction_reference) && strlen($data->transaction_reference) === 0) {
            $errors[] = [
                'transaction_reference' => [
                    'required' => 'The reference field is required',
                    'length' => 'The reference field should be 10 charaters long'
                ]
            ];
        }

        if (!isset($data->amount)) {
            $errors[] = [
                'amount' => [
                    'required' => 'The amount field is required',
                ]
            ];
        }

        if (!isset($data->customer_email) && strlen($data->customer_email) === 0 && filter_var($data->customer_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = [
                'customer_email' => [
                    'required' => 'The customer email field is required',
                    'email' => 'Email should be a valid email address'
                ]
            ];
        }

        //the api key should most likely be pass through the authorisation header
        if (!isset($data->key) && strlen($data->key) === 0) {
            $errors[] = [
                'customer_email' => [
                    'required' => 'The api key field is required'
                ]
            ];
        }

        return $errors;
    }
}
