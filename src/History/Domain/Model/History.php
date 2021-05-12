<?php

namespace App\History\Domain\Model;

class History
{
    const ZIP_CODE = 'zipCode';
    private int $id;
    private int $zipCode;
    private \DateTime $shipmentDate;
    private \DateTime $deliveredDate;
    private \DateTime $orderDate;

    /**
     * @param \DateTime $orderDate
     */
    public function setOrderDate(\DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return \DateTime
     */
    public function getDeliveredDate(): \DateTime
    {
        return $this->deliveredDate;
    }

    /**
     * @param \DateTime $deliveredDate
     */
    public function setDeliveredDate(\DateTime $deliveredDate): void
    {
        $this->deliveredDate = $deliveredDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getZipCode(): int
    {
        return $this->zipCode;
    }

    /**
     * @param int $zipCode
     */
    public function setZipCode(int $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return \DateTime
     */
    public function getShipmentDate(): \DateTime
    {
        return $this->shipmentDate;
    }

    /**
     * @param \DateTime $shipmentDate
     */
    public function setShipmentDate(\DateTime $shipmentDate): void
    {
        $this->shipmentDate = $shipmentDate;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate(): \DateTime
    {
        return $this->orderDate;
    }
}
