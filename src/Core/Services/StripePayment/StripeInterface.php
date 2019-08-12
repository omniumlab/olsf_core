<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/02/2019
 * Time: 10:55
 */

namespace Core\Services\StripePayment;


use Core\Output\Responses\HandlerResponseBase;
use Core\Output\Responses\HandlerResponseInterface;
use Stripe\ApiResponse;

interface StripeInterface
{

    function charge(string $token, string $email, float $amount, ?string $currency = "EUR"):string;
    function refund($id):string;
}