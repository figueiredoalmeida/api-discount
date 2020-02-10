<?php declare(strict_types = 1);

namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use Test\Unit\GuzzleHttp\Client;

class DiscountCalculatorTest extends TestCase
{
    public function testPOST()
    {
        $client = new \GuzzleHttp\Client();
        
        $data = '{"id":"3","customer-id":"2","items":[{"product-id":"B101","quantity":"5","unit-price":"9.75","total":"48.75"}],"total":"901.00"}';

        $response = $client->request('POST', 'http://localhost:8000/api/discount?token=token1', [
            'body' => $data
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('content-type'));
    }
}