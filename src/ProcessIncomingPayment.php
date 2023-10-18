<?php

namespace MoolrePayments;

use Exception;

class ProcessIncomingPayment
{
    public function __construct(protected string $publicKey, protected array $paymentData)
    {
    }


    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPaymentPayload(): array
    {
        return $this->paymentData;
    }

    public function getValidatedPaymentPayload(): array
    {
        return $this->validatePayload();
    }

    private function trim($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    private function validatePayload(): array
    {
        $validatedData = [];

        foreach ($this->paymentData as $key => $value) {
            $validatedData[$key] = $this->trim($value);
        }

        return $validatedData;
    }

    private function persistPaymentDetailsToStorage()
    {
        try {
            $connection = (new DatabaseConnection())->connect();

            /**
             * Ideally we will have to retrieve the merchant identifier from either the keys
             * or from a unique identifier/code attached to the merchant
             */
            $connection->prepare(
                'Insert into payments set merchant_id = :merchant_id, channel = :channel, amount = :amount, customer_email = :customer_email, customer_name = :customer_name, customer_mobile_number = :customer_mobile_number'
            );
        } catch (Exception $e) {
        }
    }
}