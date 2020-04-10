<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/product');

        $node = $crawler->getNode(0);
        $nodeName = $node->nodeName;

        $this->assertEquals('http://localhost/product', $crawler->getUri());
        $this->assertEquals('html', $nodeName);
    }


    public function testNewGet(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/product/new');

        $this->assertEquals(
            'http://localhost/product/new',
            $crawler->getUri()
        );

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h4', 'Buy Item');
    }

    public function testNewPost(){
        $client = static::createClient();
        $client->request('POST', '/product/new', ['name' => 'product_new']);
        $client->insulate();

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('form', $client->getRequest()->getContentType());
        $this->assertEquals('product_new', $client->getRequest()->request->get('name'));
        $this->assertEquals('/product/new', $client->getRequest()->getRequestUri());
    }
}
