<?php


namespace App\Service;


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