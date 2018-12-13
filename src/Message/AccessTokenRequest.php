<?php

namespace Omnipay\Mpesa\Message;

class AccessTokenRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    /**
     * @var string
     */
    protected $testEndpoint = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    /**
     * Generate access_token
     *
     * @param mixed $data
     *
     * @return string|bool
     */
    public function sendData($data)
    {
        $headers = [
            'Authorization' => 'Basic ' . base64_encode($this->getApiKey() . ':' . $this->getApiSecret()),
        ];
        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers);

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\AccessTokenRequest
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return mixed
     */
    public function getApiSecret()
    {
        return $this->getParameter('apiSecret');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\AccessTokenRequest
     */
    public function setApiSecret($value)
    {
        return $this->setParameter('apiSecret', $value);
    }

    /**
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     *
     * @return array|mixed
     */
    public function getData()
    {
        $this->validate('apiKey', 'apiSecret');
        $data = [
            'apiKey' => $this->getApiKey(),
            'apiSecret' => $this->getApiSecret(),
        ];

        return $data;
    }
}
