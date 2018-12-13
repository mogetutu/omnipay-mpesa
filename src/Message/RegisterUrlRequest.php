<?php

namespace Omnipay\Mpesa\Message;

class RegisterUrlRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $testEndpoint = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.safaricom.co.ke/v1/registerurl';

    /**
     * @return mixed
     */
    public function getResponseType()
    {
        return $this->getParameter('ResponseType');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\RegisterUrlRequest
     */
    public function setResponseType($value)
    {
        return $this->setParameter('ResponseType', $value);
    }

    /**
     * @return mixed
     */
    public function getConfirmationUrl()
    {
        return $this->getParameter('ConfirmationUrl');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\RegisterUrlRequest
     */
    public function setConfirmationUrl($value)
    {
        return $this->setParameter('ConfirmationUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getValidationUrl()
    {
        return $this->getParameter('ValidationURL');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\RegisterUrlRequest
     */
    public function setValidationUrl($value)
    {
        return $this->setParameter('ValidationURL', $value);
    }

    /**
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     *
     * @return array|mixed
     */
    public function getData()
    {
        $this->validate('ShortCode', 'ResponseType', 'ConfirmationURL', 'ValidationURL', 'token');
        $data = [
            'ShortCode' => $this->getShortCode(),
            'ConfirmationURL' => $this->getConfirmationUrl(),
            'ValidationURL' => $this->getValidationUrl(),
            'ResponseType' => $this->getResponseType(),
        ];

        return $data;
    }
}
