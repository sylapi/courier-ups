<?php

namespace Sylapi\Courier\Ups\Responses;

use Sylapi\Courier\Abstracts\Response as ResponseAbstract;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class Rating extends ResponseAbstract implements ResponseContract
{

    private ?string $arrivalDateTime = NULL;
    private ?string $totalCharge;
    private ?string $currencyCode;
    private ?string $serviceCode;
    private ?string $serviceDescription;

    public function setTotalCharge(string $totalCharge): self
    {
        $this->totalCharge = $totalCharge;

        return $this;
    }

    public function getTotalCharge(): string
    {
        return $this->totalCharge;
    }

    public function setCurrencyCode(string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setArrivalDateTime(?string $arrivalDateTime): self
    {
        $this->arrivalDateTime = $arrivalDateTime;

        return $this;
    }

    public function getArrivalDateTime(): ?string
    {
        return $this->arrivalDateTime;
    }

    public function setServiceCode(?string $serviceCode): self
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    public function getServiceCode(): ?string
    {
        return $this->serviceCode;
    }

    public function setServiceDescription(?string $serviceDescription): self
    {
        $this->serviceDescription = $serviceDescription;

        return $this;
    }

    public function getServiceDescription(): ?string
    {
        return $this->serviceDescription;
    }


    public function fill(): self
    {
        $response = $this->getResponse();

        $date = $response->RateResponse->RatedShipment->TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Date ?? null;
        $time = $response->RateResponse->RatedShipment->TimeInTransit->ServiceSummary->EstimatedArrival->Arrival->Time ?? null;

        if($date && $time) {
            $this->setArrivalDateTime((new \DateTime($date. ' ' . $time))->format('Y-m-d H:i:s'));
        } 

        $this->setTotalCharge($response->RateResponse->RatedShipment->TotalCharges->MonetaryValue ?? null)
            ->setCurrencyCode($response->RateResponse->RatedShipment->TotalCharges->CurrencyCode ?? null)
            ->setServiceDescription($response->RateResponse->RatedShipment->TimeInTransit->ServiceSummary->Service->Description ?? null);

        return $this;
    }
}
