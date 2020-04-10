<?php


namespace App\Tests\Repository;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
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

    public function testGetId()
    {
        $product = $this->entityManager
            ->getRepository(Product::class)
            ->find(1)
        ;
        $this->assertGreaterThanOrEqual(array(),$product);
    }

    public function testGetByName(){

        $product = new Product();
        $product->setName('Gnomes');
        $product->setCostPrice(11.11);
        $product->setBatchSequence(1);
        $product->setQuantity(1);

        $this->assertSame('Gnomes', $product->getName());
        $this->assertSame('11.11', $product->getCostPrice());
        $this->assertSame(1, $product->getQuantity());
    }


    public function testProductData(){
        $product = new Product();
        $product->setName('Gnomes');
        $product->setCostPrice(11.11);
        $product->setBatchSequence(1);
        $product->setQuantity(1);

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->createMock(ObjectRepository::class);
        $productRepository->expects($this->any())
            ->method('find')
            ->willReturn($product);

        $objectManager = $this->createMock( ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($productRepository);

        $this->assertEquals('Gnomes', $product->getName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

}