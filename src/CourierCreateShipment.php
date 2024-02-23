<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use OlzaApiClient\Entities\Helpers\NewShipmentEnity;
use OlzaApiClient\Entities\Response\ApiBatchResponse;
use Sylapi\Courier\Contracts\CourierCreateShipment as CourierCreateShipmentContract;
use Sylapi\Courier\Contracts\Shipment;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Exceptions\ValidateException;
use Sylapi\Courier\Helpers\ReferenceHelper;
use Sylapi\Courier\Ups\Responses\Shipment as ShipmentResponse;
use Sylapi\Courier\Ups\Helpers\ApiErrorsHelper;
use Sylapi\Courier\Ups\Helpers\ValidateErrorsHelper;
use Sylapi\Courier\Ups\Services\COD;
use Sylapi\Courier\Ups\Services\PickupPoint;




class CourierCreateShipment implements CourierCreateShipmentContract
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function createShipment(Shipment $shipment): ShipmentResponse
    {
        $response = new ShipmentResponse();
        
        if (!$shipment->validate()) {
            throw new ValidateException('Invalid Shipment: ' . ValidateErrorsHelper::getError($shipment->getErrors()));
        }

        try {
            //TODO:
            var_dump( $this->session );
            $response->setRequest('RESPONSE');
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        $response->setResponse('RESPONSE');
        $response->setReferenceId((string) 1111);
        $response->setShipmentId((string) 222);

        return $response;
    }
}
