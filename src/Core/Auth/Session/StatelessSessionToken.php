<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 10/07/2018
 * Time: 21:51
 */

namespace Core\Auth\Session;


use Core\Exceptions\SessionExpiredException;

class StatelessSessionToken implements SessionTokenInterface
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $token = "";

    /**
     * @var int|null
     */
    private $userId;

    /**
     * @var bool|null True si es correcta. False si no es correcta. Null si no se ha comprobado aún.
     */
    private $correct;
    /**
     * @var string
     */
    private $signature;
    /**
     * @var int
     */
    private $expiration = 999;
    /**
     * @var string
     */
    private $secretKey = "";

    /**
     * SessionToken constructor.
     *
     * @param string $token
     */
    public function __construct(string $token = '')
    {
        $this->date = new \DateTime();

        if ($token) {
            $this->setDataFromToken($token);
        }
    }

    private function setDataFromToken(string $token)
    {
        $data = json_decode(base64_decode($token, true), true);

        if (!is_array($data)) {
            $data = [];
        }

        $this->token = $token;
        $userId = $this->getValueFromToken("id", $data);
        $this->userId = $userId === '' ? null : intval($userId);
        $this->date = new \DateTime("@" . intval($this->getValueFromToken("date", $data)));
        $this->expiration = intval($this->getValueFromToken("expiration", $data));
        $this->correct = null;
        $this->signature = strval($this->getValueFromToken("signature", $data));
    }

    private function getValueFromToken($name, array $data)
    {
        if (!array_key_exists($name, $data)) {
            return '';
        }

        return $data[$name];

    }

    public function isCorrect(): bool
    {
        if ($this->correct === null) {
            throw new \LogicException("Session not checked. Call method check first");
        }

        return $this->correct;
    }

    /**
     * @param $key
     *
     * @throws \Core\Exceptions\SessionExpiredException
     */
    public function check($key)
    {
        $data = $this->createTokenData($key);

        $this->correct = hash_equals($data["signature"], $this->signature);

        if ($this->correct && $this->getExpirationDate() < new \DateTime()) {
            $this->correct = false;

            throw new SessionExpiredException();
        }
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        if (!($this->date instanceof \DateTime)) {
            $this->date = new \DateTime("@0");
        }

        return $this->date;
    }

    /**
     * @return int
     */
    public function getExpiration(): int
    {
        return $this->expiration;
    }

    public function createToken(?int $userId, string $secretKey, int $expiration)
    {
        $this->date = new \DateTime();
        $this->expiration = $expiration;
        $this->userId = $userId;
        $this->token = base64_encode(json_encode($this->createTokenData($secretKey)));
        $this->correct = true;
    }

    private function createTokenData($secretKey)
    {
        $this->secretKey = $secretKey;

        $data = [
            "id"         => $this->getUserId(),
            "date"       => intval($this->getDate()->format("U")),
            "expiration" => $this->getExpiration(),
        ];

        $data["signature"] = $this->createSignature($data, $secretKey);

        return $data;
    }

    private function createSignature(array $data, string $secretKey)
    {
        ksort($data);

        return md5(json_encode($data) . $secretKey);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate(): \DateTime
    {
        $expirationDate = clone $this->date;

        try {
            $expirationInterval = new \DateInterval("PT" . $this->expiration . "S");

            return $expirationDate->add($expirationInterval);
        } catch (\Exception $e) {
            return $expirationDate;
        }
    }

    /**
     * @return string
     */
    private function getSecretKey(): string
    {
        return $this->secretKey;
    }

    public function updateSession()
    {
        $secretKey = $this->getSecretKey();

        if ($secretKey === null) {
            throw new \LogicException("Cannot update session. Method check or createToken must be called");
        }

        $this->createToken($this->getUserId(), $secretKey, $this->getExpiration());
    }
}