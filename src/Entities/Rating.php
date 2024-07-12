<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

class Rating
{
    private Shipment $shipment;
    private string $requestOption;
    private string $invoiceTotalValue;
    private string $invoiceCurrencyCode;
    
    function setShipment(Shipment $shipment): self
    {
        $this->shipment = $shipment;

        return $this;
    }

    function getShipment(): Shipment
    {
        return $this->shipment;
    }

    function setRequestOption(string $requestOption): self
    {
        $this->requestOption = $requestOption;

        return $this;
    }

    function getRequestOption(): string
    {
        return $this->requestOption;
    }

    function setInvoiceTotalValue(string $invoiceTotalValue): self
    {
        $this->invoiceTotalValue = $invoiceTotalValue;

        return $this;
    }

    function getInvoiceTotalValue(): string
    {
        return $this->invoiceTotalValue;
    }

    function setInvoiceCurrencyCode(string $invoiceCurrencyCode): self
    {
        $this->invoiceCurrencyCode = $invoiceCurrencyCode;

        return $this;
    }

    function getInvoiceCurrencyCode(): string
    {
        return $this->invoiceCurrencyCode;
    }
}
