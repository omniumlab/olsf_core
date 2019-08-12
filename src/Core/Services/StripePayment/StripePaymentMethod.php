<?php

namespace Core\Services\StripePayment;

use Core\Config\GlobalConfigInterface;
use Core\Output\HttpCodes;
use Core\Output\Responses\ErrorHandlerResponse;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Symfony\RootDirObtainerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Stripe\ApiResponse;
use Stripe\Charge;
use Stripe\Error\ApiConnection;
use Stripe\Error\Base;
use Stripe\Refund;

class StripePaymentMethod implements StripeInterface
{
    public function __construct(GlobalConfigInterface $config)
    {
        $stripe = ["secret_key" => $config->getStripeSecretKey(),
            "publishable_key" => $config->getStripePublishableKey(),];

        \Stripe\Stripe::setApiKey($stripe['secret_key']);
    }

    /*Current status of the payout (paid, pending, in_transit, canceled or failed).
    A payout will be pending until it is submitted to the bank, at which point it becomes in_transit.
    It will then change to paid if the transaction goes through.
    If it does not go through successfully, its status will change to failed or canceled.*/
    function charge(string $token, string $email, float $amount, ?string $currency = "EUR"): string
    {
        $customer = \Stripe\Customer::create([
            'email' => $email,
            'source' => $token,
        ]);
        $charge = Charge::create([
            'customer' => $customer->id,
            'amount' => $amount,
            'currency' => $currency,
        ]);
        if ($charge instanceof Charge)
            return $charge->id;

        return "";
    }

    /*Status of the refund. For credit card refunds, this can be succeeded or failed.
    For other types of refunds, it can be pending, succeeded, failed, or canceled.
    Refer to our refunds documentation for more details.*/
    function refund($id): string
    {
        $refund = Refund::create([
            "charge" => $id
        ]);


        return $refund->getLastResponse()->code;
    }
}

