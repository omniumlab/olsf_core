<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 18/07/2018
 * Time: 20:13
 */

namespace Core\Config;


use Knp\Snappy\Pdf;

interface GlobalConfigInterface
{
    public function getAbsolutePath(): string;

    public function getMenu(): array;

    public function getApiUrlPrefix(): string;

    public function getEnvironment(): string;

    public function getApnsPass(): string;

    public function getFCMKey(): string;

    public function getMailerFromEmail(): string;

    public function getMailerFromName(): string;

    public function getPdf(): Pdf;

    public function getPublicDir(): string;

    public function isLinux(): bool;

    public function getImagePublicPath(): string;

    public function getImagePrivatePath(): string;

    public function getAvailableLang(): array;

    public function getStripeSecretKey(): string;

    public function getStripePublishableKey(): string;

    public function getPaypalApi(): string;

    public function getPaypalClientID(): string;

    public function getPaypalClientSecret(): string;

    public function getPaypalToken(): string;

    public function getBBVA_Ds_Merchant_MerchantSignature(): string;

    public function getBBVA_ds_merchantcode(): string;

    public function getBBVA_ds_merchant_terminal(): string;

    public function getBBVAPaymentUrl(string $env): string;
    public function getDefaultLang(): string ;

    public function getTranslatePath(): string ;
    public function getDatabaseName():string;
}
