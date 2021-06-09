<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/02/2019
 * Time: 15:20
 */

namespace Core\Services\PaypalPayment;


interface PaypalInterface
{
    public function createOrder($amount,$currency): array ;

    public function getPaymentId($orderId): string;
    public function refundOrder($PaymentId): string;
}