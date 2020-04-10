<?php


namespace App\Tests\Repository;


use App\Entity\Sales;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SalesRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetByName(){
        $sales = new Sales();
        $sales->setBatchSequence(1);
        $sales->setCostPrice(11.11);
        $sales->setSellPrice(11.11);
        $sales->setOrderQty(1);

        $this->assertSame('11.11', $sales->getSellPrice());
        $this->assertSame('11.11', $sales->getCostPrice());
        $this->assertSame(1, $sales->getOrderQty());
    }


    public function testProductData(){
        $sales = new Sales();
        $sales->setBatchSequence(1);
        $sales->setCostPrice(11.11);
        $sales->setSellPrice(11.11);
        $sales->setOrderQty(1);

        // Now, mock the repository so it returns the mock of the employee
        $salesRepository = $this->createMock(ObjectRepository::class);
        $salesRepository->expects($this->any())
            ->method('find')
            ->willReturn($sales);

        $objectManager = $this->createMock( ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($salesRepository);

        $this->assertEquals('11.11', $sales->getCostPrice());
        $this->assertEquals(1, $sales->getOrderQty());
        $this->assertEquals('11.11', $sales->getSellPrice());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

}