<?php


namespace App\Service;

/**
 * Class AbstractService
 * @package App\Service
 */
abstract class AbstractService
{

    /**
     * @param $sales
     */
    public function getFifoItem($sales){}

    /**
     * @param $soldItems
     */
    protected function prepareArrayOfSoldItem($soldItems){}

}