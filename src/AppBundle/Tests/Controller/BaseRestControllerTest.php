<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BaseRestControllerTest extends WebTestCase
{
    protected function getResponseData(Response $response)
    {
        return json_decode($response->getContent(), true);
    }

    protected function assertSuccessResponse(Response $response)
    {
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertJson($response->getContent());
    }

    protected function request($method, $uri, $body = [])
    {
        $client = $this->getClient();
        $client->request($method, $uri, [], [], [], json_encode($body));

        return $client->getResponse();
    }

    protected function getClient()
    {
        return static::createClient([], [
            'CONTENT_TYPE' => 'application/json',
        ]);
    }
}
