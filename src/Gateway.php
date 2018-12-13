<?php

namespace Omnipay\Mpesa;

use Omnipay\Common\AbstractGateway;
use Omnipay\Mpesa\Message\AccessTokenRequest;
use Omnipay\Mpesa\Message\C2BRequest;
use Omnipay\Mpesa\Message\RegisterUrlRequest;

/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    public function getDefaultParameters()
    {
        return [
            'apiKey' => '',
            'apiSecret' => '',
            'token' => '',
            'testMode' => false,
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Mpesa';
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return string
     */
    public function getApiSecret()
    {
        return $this->getParameter('apiSecret');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setApiSecret($value)
    {
        return $this->setParameter('apiSecret', $value);
    }

    /**
     * Get OAuth 2.0 access token.
     *
     * @param bool $createIfNeeded [optional] - If there is not an active token present, should we create one?
     *
     * @return string
     */
    public function getToken($createIfNeeded = true)
    {
        if ($createIfNeeded && !$this->hasToken()) {
            $response = $this->createToken()->send();
            if ($response->isSuccessful()) {
                $data = $response->getData();
                if (isset($data['access_token'])) {
                    $this->setToken($data['access_token']);
                    $this->setTokenExpires(time() + $data['expires_in']);
                }
            }
        }

        return $this->getParameter('token');
    }

    /**
     * Create OAuth 2.0 access token request.
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function createToken(array $parameters = [])
    {
        return $this->createRequest(AccessTokenRequest::class, $parameters);
    }

    /**
     * Set OAuth 2.0 access token.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * Get OAuth 2.0 access token expiry time.
     *
     * @return int
     */
    public function getTokenExpires()
    {
        return $this->getParameter('tokenExpires');
    }

    /**
     * Set OAuth 2.0 access token expiry time.
     *
     * @param int $value
     *
     * @return $this
     */
    public function setTokenExpires($value)
    {
        return $this->setParameter('tokenExpires', $value);
    }

    /**
     * Is there a bearer token and is it still valid?
     *
     * @return bool
     */
    public function hasToken()
    {
        $token = $this->getParameter('token');
        $expires = $this->getTokenExpires();
        if (!empty($expires) && !is_numeric($expires)) {
            $expires = strtotime($expires);
        }

        return !empty($token) && time() < $expires;
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function C2BRequest(array $parameters = [])
    {
        return $this->createRequest(C2BRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function registerUrlRequest(array $parameters = [])
    {
        return $this->createRequest(RegisterUrlRequest::class, $parameters);
    }
}
