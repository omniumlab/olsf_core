<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 15/02/2019
 * Time: 9:43
 */

namespace Core\Services\RedsysPayment;

use Core\Config\GlobalConfigInterface;


class RedsysPaymentMethod implements RedsysInterface
{
    //https://pagosonline.redsys.es/tipos-operacion.html
    const PAGO_NORMAL = 0;
    const PREAUTORIZACION = 1;
    const CONFIRMACION = 2;
    const DEVOLUCION = 3;
    const PREAUTORIZACION_SEPARADA = 7;
    const CONFIRMACION_SEPARADA = 8;
    const ANULACION = 9;
    /** @var string */
    private $Ds_Merchant_MerchantSignature;
    /** @var string */
    private $DS_MERCHANT_MERCHANTCODE;
    /** @var integer */
    private $DS_MERCHANT_TERMINAL;
    private $Ds_SignatureVersion = "HMAC_SHA256_V1";
    /** @var string */
    private $action;

    public function __construct(GlobalConfigInterface $config)
    {
        $this->Ds_Merchant_MerchantSignature = $config->getRedsys_Ds_Merchant_MerchantSignature();
        $this->DS_MERCHANT_MERCHANTCODE = $config->getRedsys_ds_merchantcode();
        $this->DS_MERCHANT_TERMINAL = $config->getRedsys_ds_merchant_terminal();
        $this->action = $config->getRedsysPaymentUrl(isset($_SERVER["OLSF_ENVIROMENT"]) ? $_SERVER["OLSF_ENVIROMENT"] : "prod");
    }

    function createOrder(float $amount, int $orderCode, string $description, string $apiUrlOk,
                         ?string $apiUrlOkPostParams = null, ?string $clientUrlOk = null, ?string $clientUrlKo = null,int $authorization=RedsysPaymentMethod::PREAUTORIZACION): array
    {
        $redsyapi = new RedsysAPI();
        $redsyapi->setParameter("DS_MERCHANT_AMOUNT", $amount);
        $redsyapi->setParameter("DS_MERCHANT_ORDER", $this->generateCode($orderCode));
        $redsyapi->setParameter("DS_MERCHANT_MERCHANTCODE", $this->DS_MERCHANT_MERCHANTCODE);
        $redsyapi->setParameter("DS_MERCHANT_CURRENCY", 978);        //978 €, 840  $
        $redsyapi->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $authorization);
        $redsyapi->setParameter("DS_MERCHANT_TERMINAL", $this->DS_MERCHANT_TERMINAL);
        $redsyapi->setParameter("DS_MERCHANT_MERCHANTURL", $apiUrlOk);
        $redsyapi->setParameter("Ds_Merchant_MerchantData", $apiUrlOkPostParams);

        $redsyapi->setParameter("Ds_Merchant_UrlOK", $clientUrlOk);
        $redsyapi->setParameter("Ds_Merchant_UrlKO", $clientUrlKo);
        $redsyapi->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION", $description);
        $Ds_MerchantParameters = $redsyapi->createMerchantParameters();
        $Ds_Signature = $redsyapi->createMerchantSignature($this->Ds_Merchant_MerchantSignature);
        return [
            "mp" => $Ds_MerchantParameters,
            "s" => $Ds_Signature,
            "sv" => $this->Ds_SignatureVersion,
            "action" => $this->action
        ];
    }

    function checkOrder($version, $params, $signature): bool
    {
        $redsyapi = new RedsysAPI();
        $redsyapi->decodeMerchantParameters($params);
        if ($redsyapi->getParameter("Ds_Response") <= 99 || $redsyapi->getParameter("Ds_Response") === 900) {
            if ($signature === $redsyapi->createMerchantSignatureNotif($this->Ds_Merchant_MerchantSignature, $params))
                return true;
            else
                return false;
        } else
            return false;
    }

    function checkSignature($version, $params, $signature): bool
    {
        $redsyapi = new RedsysAPI();
        if ($signature === $redsyapi->createMerchantSignatureNotif($this->Ds_Merchant_MerchantSignature, $params))
            return true;
        else
            return false;
    }


    private function generateCode(int $orderCode): string
    {
        return str_pad($orderCode, 4, "0", STR_PAD_LEFT);
    }

    private function confirmPay($Ds_SignatureVersion, $Ds_MerchantParameters, $Ds_Signature): string
    {
        $fields = array(
            'Ds_SignatureVersion' => $Ds_SignatureVersion,
            'Ds_MerchantParameters' => $Ds_MerchantParameters,
            'Ds_Signature' => $Ds_Signature,
        );
        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->action);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    function confirmOrder($amount, $orderCode, $cartIdentifier, string $apiUrlOk,
                          ?string $apiUrlOkPostParams = null, ?string $clientUrlOk = null, ?string $clientUrlKo = null): array
    {
        $redsyapi = new RedsysAPI();
        $response = array();
        $redsyapi->setParameter("DS_MERCHANT_AMOUNT", $amount);
        $redsyapi->setParameter("DS_MERCHANT_MERCHANTCODE", $this->DS_MERCHANT_MERCHANTCODE);
        $redsyapi->setParameter("DS_MERCHANT_ORDER", $this->generateCode($orderCode));
        $redsyapi->setParameter("Ds_Merchant_MerchantData", $apiUrlOkPostParams);
        $redsyapi->setParameter("DS_MERCHANT_MERCHANTURL", $apiUrlOk);
        // $redsyapi->setParameter("Ds_Merchant_UrlOK", $clientUrlOk);
        //$redsyapi->setParameter("Ds_Merchant_UrlKO", $apiUrlOk);
        $redsyapi->setParameter("Ds_Merchant_Identifier", $cartIdentifier);
        $redsyapi->setParameter("DS_MERCHANT_CURRENCY", 978);        //978 €, 840  $
        $redsyapi->setParameter("DS_MERCHANT_TRANSACTIONTYPE", 8);
        $redsyapi->setParameter("DS_MERCHANT_TERMINAL", $this->DS_MERCHANT_TERMINAL);
        $Ds_MerchantParameters = $redsyapi->createMerchantParameters();
        $Ds_Signature = $redsyapi->createMerchantSignature($this->Ds_Merchant_MerchantSignature);
        $this->confirmPay($this->Ds_SignatureVersion, $Ds_MerchantParameters, $Ds_Signature);
        return $response;
    }

    function getParameters($parameters): array
    {
        $redsyapi = new RedsysAPI();
        return json_decode($redsyapi->decodeMerchantParameters($parameters), true);
    }
}
