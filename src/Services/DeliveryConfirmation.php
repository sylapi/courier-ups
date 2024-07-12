<?php

namespace Sylapi\Courier\Ups\Services;

use Sylapi\Courier\Contracts\Validatable as ValidatableContract;
use Sylapi\Courier\Contracts\Service as ServiceContract;
use Sylapi\Courier\Abstracts\Service;
use \Sylapi\Courier\Traits\Validatable;

class DeliveryConfirmation extends Service implements ServiceContract, ValidatableContract
{
    use Validatable;

    const DEFAULT_DELIVERY_CONFIRMATION_CODE = '1'; //DELIVERY_CONFIRMATION

    public function getDeliveryConfirmationCode(): ?string
    {
        return $this->get('deliveryConfirmationCode', self::DEFAULT_DELIVERY_CONFIRMATION_CODE);
    }

    public function setDeliveryConfirmationCode(string $deliveryConfirmationCode): DeliveryConfirmation
    {
        $this->set('deliveryConfirmationCode', $deliveryConfirmationCode);
        return $this;
    }

    public function handle(): array
    {
        if(null !== $this->getRequest()){
            return  $this->getRequest();
        }
        
        $payload = $this->getRequest();
 
        $payload['ShipmentRequest']['Shipment']['Package']['PackageServiceOptions']['DeliveryConfirmation'] = [
            'DCISType' => '1' //Delivery Confirmation Signature Required
        ];
 
         return $payload;
    }
}