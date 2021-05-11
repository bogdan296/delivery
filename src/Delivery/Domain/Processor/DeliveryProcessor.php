<?php

namespace App\Delivery\Domain\Processor;

class DeliveryProcessor
{
    public function getDefaultDeliveryTime()
    {
        $currentDate = new \DateTime('NOW');
        $result = $currentDate->modify('-10 day');
        var_dump(array_sum([10,2,4])/3);die();
        //var_dump($result->format('Y-m-d'));die();
    }

    public function computeDelivery(int $zipCode, $range = null)
    {
        if (isNull($range)) {
            return $this->getDefaultDeliveryTime();
        }

    }
}
