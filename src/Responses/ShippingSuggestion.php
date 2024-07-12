<?php

namespace Sylapi\Courier\Ups\Responses;

use Sylapi\Courier\Abstracts\Response as ResponseAbstract;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class ShippingSuggestion extends ResponseAbstract implements ResponseContract
{
    public string $description;
    public int $totalDays;
    public string $deliveryDate;
    public string $deliveryTime;

    public function fill(): self
    {
        $service = $this->getResponse();

        $this->setDescription($service->serviceLevelDescription ?? null)
            ->setTotalDays($service->totalTransitDays ?? null)
            ->setDeliveryDate($service->deliveryDate ?? null)
            ->setDeliveryTime($service->deliveryTime ?? null);

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setTotalDays(int $totalDays): self
    {
        $this->totalDays = $totalDays;

        return $this;
    }

    public function getTotalDays(): int
    {
        return $this->totalDays;
    }

    public function setDeliveryDate(string $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getDeliveryDate(): string
    {
        return $this->deliveryDate;
    }

    public function setDeliveryTime(string $deliveryTime): self
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    public function getDeliveryTime(): string
    {
        return $this->deliveryTime;
    }

    public function getFullDeliveryDate(): string
    {
        return $this->getDeliveryDate() . ' ' . $this->getDeliveryTime();
    }
}
