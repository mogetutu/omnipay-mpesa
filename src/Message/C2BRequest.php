<?php

namespace Omnipay\Mpesa\Message;

class C2BRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.safaricom.co.ke';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\C2BRequest
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
     * @return \Omnipay\Mpesa\Message\AbstractRequest|\Omnipay\Mpesa\Message\C2BRequest
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
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\C2BRequest
     */
    public function setMsisdn($value)
    {
        return $this->setParameter('Msisdn', $value);
    }

    /**
     * @return mixed
     */
    public function getBillRefNumber()
    {
        return $this->getParameter('BillRefNumber');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Mpesa\Message\C2BRequest
     */
    public function setBillRefNumber($value)
    {
        return $this->setParameter('BillRefNumber', $value);
    }

    /**
     * @return array|mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('ShortCode', 'CommandID', 'Amount', 'Msisdn', 'BillRefNumber');
        $data = [
            'ShortCode' => $this->getShortCode(),
            'CommandID' => $this->getCommandId(),
            'Amount' => $this->getAmount(),
            'Msisdn' => $this->getMsisdn(),
            'BillRefNumber' => $this->getBillRefNumber(),
        ];

        return $data;
    }
}
