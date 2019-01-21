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
        $options = [
            'apiKey' => '9rwAdA0OIsMzW1DxW6FeSmkrZdtArJZa',
            'apiSecret' => 'zyZb0lJhznoi4rtc',
            'testMode' => true,
        ];
        $this->gateway->initialize($options);
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

    public function testSTKPushRequest()
    {
        $this->setMockHttpResponse('STKPushRequestSuccess.txt');
        $parameters = [
            'token' => 'LYimVTmGb6wCa4FOOg2Wl1ZjvYrT',
            'shortCode' => '601426',
            'CommandID' => 'CustomerPayBillOnline',
            'Amount' => '200',
            'Msisdn' => '254708374149',
            'Password' => 'password',
            'CallBackURL' => 'https://localhost/',
        ];
        $response = $this->gateway->STKPush($parameters)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
        $this->assertEquals($response->getData()['ResponseDescription'], 'Success. Request accepted for processing');
    }

    public function testSTKPushStatusRequest()
    {
        $this->setMockHttpResponse('STKPushStatusRequestSuccess.txt');
        $parameters = [
            'token' => 'LYimVTmGb6wCa4FOOg2Wl1ZjvYrT',
            'shortCode' => '601426',
            'CommandID' => 'CustomerPayBillOnline',
            'CheckoutRequestID' => 'ws_CO_DMZ_280497284_14012019145102297',
            'Password' => 'password',
        ];
        $response = $this->gateway->STKPushStatus($parameters)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
        $this->assertEquals($response->getData()['ResponseDescription'], 'The service request has been accepted successsfully');
    }
}
