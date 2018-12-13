<?php

namespace Omnipay\Mpesa\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['TransID'])
            || isset($this->data['access_token'])
            || isset($this->data['ResponseDescription']);
    }

    /**
     * @return string|null
     */
    public function getToken()
    {
        if (isset($this->data['access_token'])) {
            return $this->data['access_token'];
        }
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['TransID'])) {
            return $this->data['TransID'];
        }
    }
}
