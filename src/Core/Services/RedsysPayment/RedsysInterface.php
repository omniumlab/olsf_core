<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 15/02/2019
 * Time: 12:04
 */

namespace Core\Services\RedsysPayment;


interface RedsysInterface
{
    function createOrder(float $amount, int $orderCode, string $orderDescription,
                         string $apiUrlOk, ?string $apiUrlOkPostParams = null,
                         ?string $clientUrlOk = null, ?string $clientUrlKo = null,int $authorization=RedsysPaymentMethod::PREAUTORIZACION): array;

    function checkOrder($version, $params, $signature): bool;
    function checkSignature($version, $params, $signature): bool;

    function confirmOrder($amount, $orderCode, $cartIdentifier,
                          string $apiUrlOk,
                          ?string $apiUrlOkPostParams = null,
                          ?string $clientUrlOk = null,
                          ?string $clientUrlKo = null): array;

    function getParameters($parameters): array;
}
