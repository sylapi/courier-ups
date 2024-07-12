<?php

namespace Sylapi\Courier\Ups\Services;

use Sylapi\Courier\Abstracts\Services\Insurance as InsuranceAbstract;
use Sylapi\Courier\Contracts\Services\Insurance as InsuranceContract;

class Insurance extends InsuranceAbstract
{
    public function getCurrency(): ?string
    {
        return $this->get('currency', null);
    }

    public function setCurrency(string $currency): InsuranceContract
    {
        $this->set('currency', $currency);
        return $this;
    }

    public function handle(): array
    {
        if(null !== $this->getRequest()){
            return  $this->getRequest();
        }
        
        $payload = $this->getRequest();
 
        $payload['ShipmentRequest']['Shipment']['Package']['PackageServiceOptions']['InsuredValue'] = [
            'CurrencyCode' => $this->getCurrency(),
            'MonetaryValue' => $this->getAmount()
        ];
 
        return $payload;
    }

}