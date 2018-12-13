<?php

namespace Omnipay\Mpesa\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\AbstractRequest
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * @return string
     */
    public function getShortCode()
    {
        return $this->getParameter('ShortCode');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\AbstractRequest
     */
    public function setShortCode($value)
    {
        return $this->setParameter('ShortCode', $value);
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        $headers = array_merge(
            ['Content-Type' => 'application/json'],
            ['Authorization' => 'Bearer ' . $this->getToken()]
        );
        $body = $data ? json_encode($data) : null;
        $httpResponse = $this->httpClient
            ->request(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                $headers,
                $body
            );

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, json_decode($data, true));
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
