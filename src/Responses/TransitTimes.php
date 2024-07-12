<?php

namespace Sylapi\Courier\Ups\Responses;

use Sylapi\Courier\Abstracts\Response as ResponseAbstract;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class TransitTimes extends ResponseAbstract implements ResponseContract
{
    private array $shippingSuggestions = [];

    public function fill(): self
    {
        $services = $this->getResponse()->emsResponse->services ?? [];

        $services = array_map(function ($service){
            $shippingSuggestion = new ShippingSuggestion();
            $shippingSuggestion->setResponse($service);
            $shippingSuggestion->fill();
            
            return $shippingSuggestion;
        }, $services);

        $this->setShippingSuggestions($services);

        return $this;
    }

    public function setShippingSuggestions(array $shippingSuggestions): self
    {
        $this->shippingSuggestions = $shippingSuggestions;

        return $this;
    }

    public function getShippingSuggestions(): array
    {
        return $this->shippingSuggestions;
    }

}
