<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('i', 'A moment is waiting to click:');
        $this->assertStringContainsString(
            'A moment is waiting to click:',
            $client->getResponse()->getContent()
        );
    }


    public function testGetProfit(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/get-profit');
        $this->assertEquals(1, $crawler->count());
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
