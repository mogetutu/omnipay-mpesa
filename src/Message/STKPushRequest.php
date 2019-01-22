<?php

namespace Omnipay\Mpesa\Message;

class STKPushRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    /**
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     *
     * @return array|mixed
     */
    public function getData()
    {
        $this->validate('Password', 'Amount', 'Msisdn', 'CallBackURL');
        $data = [
            'BusinessShortCode' => $this->getShortCode(),
            'Password' => $this->getPassword(),
            'Timestamp' => $this->getTimestamp(),
            'TransactionType' => $this->getCommandId(),
            'Amount' => $this->getAmount(),
            'PartyA' => $this->getMsisdn(),
            'PartyB' => $this->getShortCode(),
            'PhoneNumber' => $this->getMsisdn(),
            'CallBackURL' => $this->getCallbackUrl(),
            'AccountReference' => $this->getAccountReference(),
            'TransactionDesc' => $this->getTransactionDescription(),
        ];

        return $data;
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushRequest
     */
    public function setCommandId($value)
    {
        return $this->setParameter('CommandID', $value);
    }

    /**
     * @return mixed
     */
    public function getCommandId()
    {
        return $this->getParameter('CommandID');
    }

    /**
     * @return mixed|string
     */
    public function getAmount()
    {
        return $this->getParameter('Amount');
    }

    /**
     * @param string|null $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushRequest
     */
    public function setAmount($value)
    {
        return $this->setParameter('Amount', $value);
    }

    /**
     * @return mixed
     */
    public function getMsisdn()
    {
        return $this->getParameter('Msisdn');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushRequest
     */
    public function setMsisdn($value)
    {
        return $this->setParameter('Msisdn', $value);
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
     * @return \Omnipay\Mpesa\Message\STKPushRequest
     */
    public function setPassword($value)
    {
        $value = base64_encode($this->getShortCode() . $value . $this->getTimestamp());

        return $this->setParameter('Password', $value);
    }

    public function getTimestamp()
    {
        return '20' . date('ymdhis');
    }

    /**
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->getParameter('CallBackURL');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushRequest
     */
    public function setCallbackUrl($value)
    {
        return $this->setParameter('CallBackURL', $value);
    }

    /**
     * @return string
     */
    public function getAccountReference()
    {
        return $this->getParameter('AccountReference');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushRequest
     */
    public function setAccountReference($value)
    {
        return $this->setParameter('AccountReference', $value);
    }

    /**
     * @return string
     */
    public function getTransactionDescription()
    {
        return $this->getParameter('TransactionDesc');
    }

    /**
     * @param string $value
     *
     * @return \Omnipay\Mpesa\Message\STKPushRequest
     */
    public function setTransactionDescription($value)
    {
        return $this->setParameter('TransactionDesc', $value);
    }
}
