<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

class TransitTimes
{
    const BILL_TYPE_DEFAULT = '03';
    const AVV_FLAG_DEFAULT = true;

    private Shipment $shipment;
    private string $shipDate;
    private string $shipTime;
    private string $billType;
    private string $shipmentContentsValue;
    private string $shipmentContentsCurrencyCode;


    function setShipment(Shipment $shipment): self
    {
        $this->shipment = $shipment;

        return $this;
    }

    function getShipment(): Shipment
    {
        return $this->shipment;
    }

    function setShipDate(string $shipDate): self
    {
        $this->shipDate = $shipDate;

        return $this;
    }

    function getShipDate(): string
    {
        return $this->shipDate ?? '';
    }

    function setShipTime(string $shipTime): self
    {
        $this->shipTime = $shipTime;

        return $this;
    }

    function getShipTime(): string
    {
        return $this->shipTime ?? '';
    }

    function setBillType(string $billType): self
    {
        $this->billType = $billType;

        return $this;
    }

    function getBillType(): string
    {
        return $this->billType ?? self::BILL_TYPE_DEFAULT;
    }

    function setShipmentContentsValue(string $shipmentContentsValue): self
    {
        $this->shipmentContentsValue = $shipmentContentsValue;

        return $this;
    }

    function getShipmentContentsValue(): string
    {
        return $this->shipmentContentsValue ?? '';
    }

    function setShipmentContentsCurrencyCode(string $shipmentContentsCurrencyCode): self
    {
        $this->shipmentContentsCurrencyCode = $shipmentContentsCurrencyCode;

        return $this;
    }

    function getShipmentContentsCurrencyCode(): string
    {
        return $this->shipmentContentsCurrencyCode ?? '';
    }

    function getAvvFlag(): bool
    {
        return self::AVV_FLAG_DEFAULT;
    }   
}
