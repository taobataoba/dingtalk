<?php

namespace ChenDingtalk\Tests\Clients;

use PHPUnit\Framework\TestCase;
use ChenDingtalk\Tests\CreateDingtalkManager;

class CallbackClientTest extends TestCase
{
    use CreateDingtalkManager;

    /**
     * @var \ChenDingtalk\Clients\CallbackClient
     */
    private $client;

    public function setUp()
    {
        $this->setDingtalkManager();
        $this->client = $this->dingtalkManager->callback();
    }

    /**
     *
     */
    public function registerCallback()
    {
        $call_back_tag = ['user_add_org'];
        $url = $_ENV['url'];
        $response = $this->client->registerCallback($call_back_tag , $url);
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @depends registerCallback
     */
    public function updateCallback()
    {
        $call_back_tag = ['user_modify_org'];
        $token = $_ENV['token'];
        $aes_key = $_ENV['aes_key'];
        $url = $_ENV['url'];
        $response = $this->client->updateCallback($call_back_tag, $token, $aes_key, $url);
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @depends registerCallback
     */
    public function deleteCallback()
    {
        $response = $this->client->deleteCallback();
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @depends registerCallback
     */
    public function getCallback()
    {
        $response = $this->client->getCallback();
        $this->assertEquals(0, $response->errcode);
    }

    /**
     * @test
     */
    public function getCallBackFailedResult()
    {
        $response = $this->client->getCallBackFailedResult();
        $this->assertEquals(0, $response->errcode);
    }
}