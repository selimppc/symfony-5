<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FifoProductSalesService extends WebTestCase
{
    public function testSomething()
    {
        self::bootKernel();
        // returns the real and unchanged service container
        $container = self::$kernel->getContainer();
        // gets the special container that allows fetching private services
        $container = self::$container;

        $service = $container->get('App\Service\FifoProductSales');
        $sampleArray = array(
            "order_qty" => "6",
            "sell_price" => "6"
        );
        $result = $service->getFifoItem($sampleArray);
        $this->assertEquals(array(), $result);
    }
}
