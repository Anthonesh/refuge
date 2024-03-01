<?php

class Secret
{
    private $stripeSecretKey;

    public function __construct(string $stripeSecretKey)
    {
        $this->stripeSecretKey = $stripeSecretKey;
    }

    public function getStripeSecretKey(): string
    {
        return $this->stripeSecretKey;
    }
}