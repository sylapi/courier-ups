<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Utilities;

use Sylapi\Courier\Ups\Session;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Entities;
use Sylapi\Courier\Ups\Responses;

class TransitTimes 
{
    const API_PATH = '/api/shipments/v1/transittimes';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function transitTimes(Entities\TransitTimes $transitTimes): Responses\TransitTimes
    {
    
        $response = new Responses\TransitTimes();

        try {
            $payload = $this->getPayload($transitTimes);

            $response->setRequest($payload);
            $stream = $this->session
            ->client()
            ->request(
                'POST',
                self::API_PATH,
                [ 'body' => json_encode($payload) ]
            );

            $result = json_decode($stream->getBody()->getContents());
            $response->setResponse($result);
            $response->fill();

        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }
        

        return $response;
    }


    private function getPayload(Entities\TransitTimes $transitTimes): array
    {
        $shipment = $transitTimes->getShipment();

        $sender = $shipment->getSender();
        $receiver = $shipment->getReceiver();

        /**
         * @var Entities\Parcel $parcel
         */
        $parcel = $shipment->getParcel();

        return [
            'originCountryCode' => $sender->getCountryCode(),
            'originStateProvince' => '',
            'originCityName' => $sender->getCity() ?? '',
            'originTownName' => '',
            'originPostalCode' => $sender->getZipCode(),
            'destinationCountryCode' => $receiver->getCountryCode(),
            'destinationStateProvince' => '',
            'destinationCityName' => $receiver->getCity() ?? '',
            'destinationTownName' => '',
            'destinationPostalCode' => $receiver->getZipCode(),
            'weight' => $parcel->getWeight(),
            'weightUnitOfMeasure' => $parcel->getUnitOfWeightCode(),
            'shipmentContentsValue' => $transitTimes->getShipmentContentsValue(),
            'shipmentContentsCurrencyCode' => $transitTimes->getShipmentContentsCurrencyCode(),
            'billType' => $transitTimes->getBillType(),
            'shipDate' => $transitTimes->getShipDate(),
            'shipTime' => $transitTimes->getShipTime(),
            'residentialIndicator' => '',
            'avvFlag' => $transitTimes->getAvvFlag(),
            'numberOfPackages' => $shipment->getQuantity()
        ];

    }


}
