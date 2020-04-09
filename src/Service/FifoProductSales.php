<?php


namespace App\Service;


use App\Repository\ProductRepository;
use App\Repository\SalesRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class FifoProductSales
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var SalesRepository
     */
    private $salesRepository;

    /**
     * FifoProductSales constructor.
     * @param ProductRepository $productRepository
     * @param SalesRepository $salesRepository
     */
    public function __construct(ProductRepository $productRepository, SalesRepository $salesRepository)
    {
        $this->productRepository = $productRepository;
        $this->salesRepository = $salesRepository;
    }


    /**
     * @param $sales
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getFifoItem($sales)
    {
        $orderQty = $sales['order_qty'];
        $totalSold = $this->salesRepository->getSoldItem();
        $products = $this->productRepository->getProducts();

        $orderArray = array();
        foreach ($products as $product){

            $itemId = $product->getId();
            $productQty = $product->getQuantity();
            $productSequent = $product->getBatchSequence();
            $productCost = $product->getCostPrice();
            if ($productQty > $totalSold) {
                $qty = $this->getOrderQty($orderQty, $productQty, $totalSold);
                if ($qty){
                    $orderArray[$productSequent] = array(
                        'item_id' => $itemId,
                        'order_qty' => $qty,
                        'batch_sequence' => $productSequent,
                        'cost_price' => $productCost,
                    );
                    $orderQty = $orderQty - $qty;
                }
            }elseif ($productQty < $totalSold){
                $reduceSoldQty = $totalSold - $productQty;
                $totalSold = $reduceSoldQty;
            }
        }
        return $orderArray;
    }

    /**
     * @param $orderQty
     * @param $productQty
     * @param $totalSold
     * @return null
     */
    protected function getOrderQty($orderQty, $productQty, $totalSold){
        $val = null;
        $diff = $productQty - $totalSold;
        if ($diff >= $orderQty){
            $val = $orderQty;
        }
        if ($diff < $orderQty){
            $val = $productQty - $totalSold;
        }
        return $val;
    }


}