<?php

namespace Sylapi\Courier\Ups\Services;

use Sylapi\Courier\Abstracts\Services\COD as CODAbstract;
use Sylapi\Courier\Contracts\Services\COD as CODContract;

class COD extends CODAbstract
{   

    const DEFAULT_FUNDS_CODE = '1'; //CASH

    public function getFundsCode(): ?string
    {
        return $this->get('fundsCode', self::DEFAULT_FUNDS_CODE);
    }

    public function setFundsCode(string $fundsCode): CODContract
    {
        $this->set('fundsCode', $fundsCode);
        return $this;
    }

    public function handle(): array
    {
    
        if(null !== $this->getRequest()){
           return  $this->getRequest();
        }
        

        $payload = $this->getRequest();

        $payload['ShipmentServiceOptions']['COD'] = [
            'CODFundsCode' => $this->getFundsCode(),
            'CODAmount' => [
                'CurrencyCode' => $this->getCurrency(),
                'MonetaryValue' => $this->getAmount()
            ]
        ];

        return $payload;
    }
}