<?php
/**
 * Created by PhpStorm.
 * User: Zirialk
 * Date: 22/10/2018
 * Time: 16:22
 */

namespace Core\Services\NotificationPush;


use Core\Config\GlobalConfigInterface;
use Core\Symfony\RootDirObtainerInterface;

class NativePushSender implements PushSenderInterface
{
    /** @var string */
    private $fcmKey;

    /** @var null|string */
    private $pemCertificate;

    /** @var null|string  */
    private $apnPass;

    function __construct(GlobalConfigInterface $config, RootDirObtainerInterface $rootDirObtainer)
    {
        $this->pemCertificate = $rootDirObtainer->getRootDir() . "/private/app/config/push/ck_" . $config->getEnvironment() . ".pem";
        $this->fcmKey = $config->getFCMKey();
        $this->apnPass = $config->getApnsPass();
    }

    function send(string $token, string $message, int $os, ?string $title = null, ?string $image = null)
    {
        switch ($os){
            case PushSenderInterface::OS_ANDROID:
                $this->sendAndroidNotification($token, $message, $title, $image);
                break;
            case PushSenderInterface::OS_IOS:
                $this->sendAppleNotification($token, $message, $title);
                break;
        }
    }

    private function sendAndroidNotification(string $token, string $message, ?string $title = null, ?string $image = null)
    {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

        $notification = ['body' => $message , 'sound'=>'Default'];
        if ($title !== null)
            $notification["title"] = $title;
        if ($image !== null)
            $notification["image"] = $image;

        $fields = array(
            'registration_ids' => [$token],
            'priority' => 10,
            'notification' => $notification
        );
        $headers = array(
            'Authorization:key=' . $this->fcmKey,
            'Content-Type:application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * @param string $token
     * @param string $message
     * @param null|string $title from IOS 8.2
     */
    private function sendAppleNotification(string $token, string $message, ?string $title = null)
    {
        $apnsHost = 'gateway.sandbox.push.apple.com';
        $apnsPort = 2195;
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $this->pemCertificate);
        stream_context_set_option($streamContext, 'ssl', 'passphrase', $this->apnPass);
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);

        $payload['aps'] = ['alert' => $message, 'sound' => 'default'];
        $output = json_encode($payload);
        $token = pack('H*', str_replace(' ', '', $token));
        $apnsMessage = chr(0) . chr(0) . chr(32) . $token . chr(0) . chr(strlen($output)) . $output;
        fwrite($apns, $apnsMessage);
        fclose($apns);
    }
}
