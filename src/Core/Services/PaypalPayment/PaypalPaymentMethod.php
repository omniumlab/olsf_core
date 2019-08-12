<?php
/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 11/02/2019
 * Time: 15:20
 */

namespace Core\Services\PaypalPayment;


use Core\Config\GlobalConfigInterface;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;
use PayPalCheckoutSdk\Payments\CapturesRefundRequest;
use Sample\PayPalClient;
use Symfony\Component\HttpFoundation\Response;

class PaypalPaymentMethod implements PaypalInterface
{
    private $accessToken;
    private $paypalApi;
    private $client;

    public function __construct(GlobalConfigInterface $config)
    {
        $enviroment = isset($_SERVER["OLSF_ENVIROMENT"]) ? $_SERVER["OLSF_ENVIROMENT"] : "prod";
        $this->client = new PayPalHttpClient($enviroment=="prod"?new ProductionEnvironment($config->getPaypalClientID(), $config->getPaypalClientSecret()):
            new SandboxEnvironment($config->getPaypalClientID(), $config->getPaypalClientSecret()));
        $this->accessToken = $config->getPaypalToken();
        $this->paypalApi = $config->getPaypalApi();

    }


    /**
     * @param $amount
     * @param $currency
     * @return string
     */
    public function createOrder($amount, $currency): string
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = self::buildRequestBody($amount, $currency);
        $response = $this->client->execute($request);
        return $response->result->id;
    }

    private function buildRequestBody($amount, $currency)
    {
        return array(
            'intent' => 'CAPTURE',
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => $currency,
                                    'value' => $amount
                                )
                        )
                )
        );
    }


    public function getPaymentId($orderId): string
    {
        $response = $this->client->execute(new OrdersGetRequest($orderId));
        return $response->result->purchase_units["payments"]->captures["id"];

    }

    public function refundOrder($PaymentId): string
    {
        $response = $this->client->execute(new CapturesRefundRequest($PaymentId));
        return $response->result->status;

    }
}