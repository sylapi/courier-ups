<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Contracts\Booking;

use Sylapi\Courier\Ups\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Exceptions\ValidateException;
use Sylapi\Courier\Ups\Helpers\ApiErrorsHelper;
use Sylapi\Courier\Exceptions\TransportException;
use OlzaApiClient\Entities\Response\ApiBatchResponse;
use Sylapi\Courier\Ups\Helpers\ValidateErrorsHelper;
use OlzaApiClient\Entities\Helpers\PostShipmentsEnity;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Contracts\CourierPostShipment as CourierPostShipmentContract;
use Sylapi\Courier\Ups\Entities\Parcel;

class CourierPostShipment implements CourierPostShipmentContract
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function postShipment(Booking $booking): ParcelResponse
    {
        $response = new ParcelResponse();

        if (!$booking->validate()) {
            throw new ValidateException('Invalid Shipment: ' . ValidateErrorsHelper::getError($booking->getErrors()));
        }

        try {
            //TODO:
            var_dump( $this->session );
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        $response->setResponse('OK');
        $response->setShipmentId('111');
        $response->setTrackingId('111');
        $response->setTrackingBarcode('111');
        $response->setTrackingUrl('http://example.com');
        
        return $response;
    }
}
