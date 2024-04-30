<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class RunnigApiTest extends TestCase
{

    protected $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8001',
            'http_errors' => false
        ]);
    }

    public function test_api_response_success_status()
    {
        $response = $this->client->get('/api');
        $this->assertEquals(200, $response->getStatusCode());
        $body = (string) $response->getBody();
        $this->assertNotEmpty($body);
    }
}
