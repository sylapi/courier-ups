<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Ups\Entities\PickupAddress;
use Sylapi\Courier\Abstracts\Booking as BookingAbstract;

class Booking extends BookingAbstract
{
    private PickupAddress $pickupAddress;
    private array $shipments = [];

    private string $pickupDate;
    private string $pickupReadyTime;
    private string $pickupCloseTime;

    public function __construct()
    {
        $this->pickupAddress = new PickupAddress();
    }

    public function setShipment(array $shipments): self
    {
        $this->shipments = $shipments;
        return $this;
    }

    public function addShipment(Shipment $shipment): self
    {
        $this->shipments[] = $shipment;
        return $this;
    }   

    public function getShipments(): array
    {
        return $this->shipments;
    }    

    public function getTotalWeight(): string
    {
        $totalWeight = 0;
        foreach ($this->shipments as $shipment) {
            $totalWeight += $shipment->getParcel()->getWeight();
        }
        return (string) $totalWeight;
    }

    public function getUnitOfWeightCode(): string
    {
        if(count($this->shipments) < 1 || !isset($this->shipments[0])){
            return '';
        }

        return $this->shipments[0]->getParcel()->getUnitOfWeightCode();
    }

    public function setPickupAddress(PickupAddress $pickupAddress): self
    {
        $this->pickupAddress = $pickupAddress;
        return $this;
    }

    public function getPickupAddress(): PickupAddress
    {
        return $this->pickupAddress;
    }

    public function setPickupDateTime(string $pickupDate, string $pickupReadyTime, $pickupCloseTime): self
    {
        $this->pickupDate = $pickupDate;
        $this->pickupReadyTime = $pickupReadyTime;
        $this->pickupCloseTime = $pickupCloseTime;
        return $this;
    }

    public function getPickupDate(): string
    {
        return $this->pickupDate;
    }

    public function getPickupReadyTime(): string
    {
        return $this->pickupReadyTime;
    }

    public function getPickupCloseTime(): string
    {
        return $this->pickupCloseTime;
    }

    public function validate(): bool
    {
        $rules = [
            'shipmentId' => 'required',
        ];
        $data = [
            'shipmentId' => $this->getShipmentId(),
        ];

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());
            return false;
        }

        return true;
    }
}
