<?php

namespace Omnipay\Mpesa\Message;

class STKPushStatusRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('Password', 'CheckoutRequestID');
        $data = [
            'BusinessShortCode' => $this->getShortCode(),
            'Password' => $this->getPassword(),
            'Timestamp' => $this->getTimestamp(),
            'CheckoutRequestID' => $this->getCheckoutRequestID(),
        ];

        return $data;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('Password');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushStatusRequest
     */
    public function setPassword($value)
    {
        $value = base64_encode($this->getShortCode() . $value . $this->getTimestamp());

        return $this->setParameter('Password', $value);
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return '20' . date('ymdhis');
    }

    /**
     * @return string
     */
    public function getCheckoutRequestID()
    {
        return $this->getParameter('CheckoutRequestID');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushStatusRequest
     */
    public function setCheckoutRequestID($value)
    {
        return $this->setParameter('CheckoutRequestID', $value);
    }
}
