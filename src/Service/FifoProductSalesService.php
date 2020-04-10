<?php


namespace App\Service;


use App\Repository\ProductRepository;
use App\Repository\SalesRepository;

class FifoProductSalesService extends AbstractService
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
     */
    public function getFifoItem($sales)
    {
        $orderQty = $sales['order_qty'];
        $soldItems = $this->salesRepository->getSoldItem();
        $soldArray = $this->prepareArrayOfSoldItem($soldItems);

        $products = $this->productRepository->getProducts();

        $orderArray = array();
        foreach ($products as $product){
            $itemId = $product->getId();
            $productQty = $product->getQuantity();
            $productSequent = $product->getBatchSequence();
            $productCost = $product->getCostPrice();

            # get the sold quantity for this product
            $soldQty = isset($soldArray[$productSequent])?$soldArray[$productSequent]:0;
            # check available quantity
            $availableProduct = $productQty - $soldQty;

            if ($availableProduct > 0){
                if ($availableProduct >= $orderQty){
                    $qty = $orderQty;
                }else{
                    $qty = $availableProduct;
                }
                $orderArray[$productSequent] = array(
                    'item_id' => $itemId,
                    'order_qty' => $qty,
                    'batch_sequence' => $productSequent,
                    'cost_price' => $productCost,
                );
                $orderQty = $orderQty - $qty;
            }
            if ($orderQty == 0) return $orderArray;
        }
        return $orderArray;
    }


    /**
     * @param $soldItems
     * @return array
     */
    protected function prepareArrayOfSoldItem($soldItems){
        $arr = array();
        foreach ($soldItems as $item){
            $arr[$item['batch_sequence']] = $item['order_qty'];
        }
        return $arr;
    }


}