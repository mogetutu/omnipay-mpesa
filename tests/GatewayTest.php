<?php

namespace Omnipay\Mpesa\Tests;

use Omnipay\Mpesa\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testC2BRequest()
    {
        $this->setMockHttpResponse('C2BRequestSuccess.txt');
        $parameters = [
            'token' => 'LYimVTmGb6wCa4FOOg2Wl1ZjvYrT',
            'shortCode' => '601426',
            'CommandID' => 'PaybillOnlineCommand',
            'Amount' => '200',
            'Msisdn' => '254708374149',
            'BillRefNumber' => 'credit-topup',
        ];
        $response = $this->gateway->C2BRequest($parameters)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
        $this->assertEquals($response->getData()['ResponseDescription'], 'Accept the service request successfully.');
    }

    public function testAccessTokenRequest()
    {
        $this->setMockHttpResponse('AccessTokenRequestSuccess.txt');
        $options = [
            'apiKey' => '9rwAdA0OIsMzW1DxW6FeSmkrZdtArJZa',
            'apiSecret' => 'zyZb0lJhznoi4rtc',
            'testMode' => true,
        ];
        $gateway = $this->gateway->initialize($options);
        $this->assertEquals('LYimVTmGb6wCa4FOOg2Wl1ZjvYrT', $gateway->getToken());
        $this->assertEquals(time() + 3599, $gateway->getTokenExpires());
    }
}
