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
    public function createOrder($amount,$currency): object ;

    public function getPaymentId($orderId): string;
    public function checkIfPaymentValid($orderId): bool ;
    public function refundOrder($PaymentId): string;
}