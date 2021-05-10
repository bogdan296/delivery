<?php

namespace App\History\Domain\Model;

class History
{
    private int $id;
    private int $zipCode;
    private \DateTime $shipmentDate;
    private \DateTime $endDate;
    private \DateTime $orderDate;

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
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate(): \DateTime
    {
        return $this->orderDate;
    }

    /**
     * Sets the created field on PrePersist doctrine events.
     *
     * @throws \Exception
     */
    public function setOrderDate()
    {
        $this->orderDate = new \DateTime();
    }
}
