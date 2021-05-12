<?php

namespace App\Delivery\Domain\Exception;

class DeliveryDataNotFoundException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
