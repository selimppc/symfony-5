<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SalesControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sales');

        $node = $crawler->getNode(0);
        $nodeName = $node->nodeName;

        $this->assertEquals('http://localhost/sales', $crawler->getUri());
        $this->assertEquals('html', $nodeName);
    }

    public function testNewGet(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/sales/new');

        $this->assertEquals(
            'http://localhost/sales/new',
            $crawler->getUri()
        );

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h4', 'New Sell');
    }

    public function testNewPost(){
        $client = static::createClient();
        $client->request('POST', '/sales/new', ['name' => 'sales_new']);
        $client->insulate();

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('form', $client->getRequest()->getContentType());
        $this->assertEquals('sales_new', $client->getRequest()->request->get('name'));
        $this->assertEquals('/sales/new', $client->getRequest()->getRequestUri());
    }
}
