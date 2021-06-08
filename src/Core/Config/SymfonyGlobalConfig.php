<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 19/07/2018
 * Time: 19:35
 */

namespace Core\Config;


use Core\Auth\Login\Config\LoginConfigInterface;
use Core\Commands\RequestCommandInterface;
use Knp\Snappy\Pdf;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SymfonyGlobalConfig implements GlobalConfigInterface, ReflectionConfigInterface, LoginConfigInterface
{
    /**
     * @var string
     */
    private $baseUrl;
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;


    /**
     * GlobalConfig constructor.
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(RequestStack $requestStack, ContainerInterface $container)
    {
        $urlHost = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();

        $this->baseUrl = $urlHost . $requestStack->getCurrentRequest()->getBaseUrl();
        $this->container = $container;
    }

    protected function getParameter(string $key)
    {
        return $this->container->getParameter($key);
    }

    public function getAbsolutePath(): string
    {
        return $this->baseUrl;
    }

    public function getMenu(): array
    {
        return $this->container->getParameter("menu");
    }

    public function getFallbackCommandBusClassName(): string
    {
        return $this->container->getParameter("fallback_command_bus_class");
    }

    public function getFallbackCommandClassName($originalCommanName): string
    {
        return RequestCommandInterface::class;
    }

    public function getApiUrlPrefix(): string
    {
        return $this->container->getParameter("api_prefix");
    }

    public function getBadLoginAttempts(): int {
        return $this->container->getParameter("bad_login_attemps");
    }

    public function getLoginBlockedMinutes(): int
    {
        return $this->container->getParameter("login_blocked_minutes");
    }

    public function getEnvironment(): string
    {
        return $this->container->getParameter("kernel.environment");
    }

    public function getApnsPass(): string
    {
        return $this->container->getParameter("apns_pass");
    }

    public function getFCMKey(): string
    {
        return $this->container->getParameter("fcm_key");
    }

    public function getMailerFromEmail(): string
    {
        return $this->container->getParameter("mailer_from_email");
    }

    public function getMailerFromName(): string
    {
        return $this->container->getParameter("mailer_from_name");
    }

    public function getPdf(): Pdf
    {
        /** @var Pdf $pdf */
        $pdf = $this->container->get('knp_snappy.pdf');
        return $pdf;
    }

    public function getPublicDir(): string
    {
        return $this->container->getParameter("public_dir");
    }

    public function isLinux(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'LIN';
    }

    public function getImagePublicPath(): string
    {
        return $this->container->getParameter("public_route");
    }

    public function getImagePrivatePath(): string
    {
        return $this->container->getParameter("private_route");
    }

    public function getAvailableLang(): array
    {
        return $this->container->getParameter("available_lang");
    }
    public function getStripeSecretKey(): string
    {
        return $this->container->getParameter("stripe_secret_key");

    }

    public function getStripePublishableKey(): string
    {
        return $this->container->getParameter("stripe_publishable_key");

    }
    public function getPaypalApi(): string
    {
        return $this->container->getParameter("paypal_api");

    }

    public function getPaypalClientID(): string
    {
        return $this->container->getParameter("paypal_client_id");

    }

    public function getPaypalClientSecret(): string
    {
        return $this->container->getParameter("paypal_client_secret");

    }

    public function getPaypalToken(): string
    {
        return $this->container->getParameter("paypal_token");

    }

    public function getRedsys_Ds_Merchant_MerchantSignature(): string
    {
        return $this->container->getParameter("Ds_Merchant_MerchantSignature");
    }

    public function getRedsys_ds_merchantcode(): string
    {
        return $this->container->getParameter("DS_MERCHANT_MERCHANTCODE");
    }

    public function getRedsys_ds_merchant_terminal(): string
    {
        return $this->container->getParameter("DS_MERCHANT_TERMINAL");
    }

    public function getTranslatePath(): string
    {
        return $this->container->getParameter("translate_path");

    }

    public function getDefaultLang(): string
    {
        return $this->container->getParameter("default_lang");

    }

    public function getDatabaseName(): string
    {
        return $this->container->getParameter("database_name");

    }
    public function getRedsysPaymentUrl(string $env): string
    {
        return $this->container->getParameter("REDSYS_PAYMENT_URL" . strtoupper($env));
    }

    public function getHttp(): string
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443 ? "https" : "http";
    }

    public function getOneSignalToken(): string
    {
        return $this->container->getParameter("one_signal_token");

    }

    public function getOneSignalAppId(): string
    {
        return $this->container->getParameter("one_signal_app_id");

    }
}
