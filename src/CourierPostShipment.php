<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Contracts\Booking;

use Sylapi\Courier\Ups\Enums\SpeditionCode;
use Sylapi\Courier\Ups\Entities\Credentials;
use Sylapi\Courier\Exceptions\ValidateException;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Helpers\SpeditionCodeMapper;
use Sylapi\Courier\Ups\Helpers\ValidateErrorsHelper;
use Sylapi\Courier\Ups\Entities\Booking as UpsBooking;
use Sylapi\Courier\Ups\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Contracts\CourierPostShipment as CourierPostShipmentContract;

class CourierPostShipment implements CourierPostShipmentContract
{
    const API_PATH = '/api/pickupcreation/v1/pickup';

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

            /**
             * @var UpsBooking $booking
             */
            $payload = $this->getPayload($booking, $this->session->credentials());
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

        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        
        $response->setShipmentId($booking->getShipmentId());
        
        return $response;
    }


    private function getPayload(UpsBooking $booking, Credentials $credentials)
    {
        $pickupAddress = $booking->getPickupAddress();
        

        $pickupPiece = array_map(function($shipment) {
            $speditionCode = $shipment->getOptions()?->getSpeditionCode() ?? null;

            if($speditionCode === null) {
                throw new \Exception('Spedition code is required');
            }

            return [
                "ServiceCode" => SpeditionCodeMapper::mapToPickupSpeditionCode(SpeditionCode::from($speditionCode)),
                "Quantity" => (string) $shipment->getQuantity(),
                "DestinationCountryCode" => $shipment->getReceiver()->getCountryCode(),
                "ContainerCode" => $shipment->getParcel()->getContainerCode()
            ];
        }, $booking->getShipments());


        $payload = [
            "PickupCreationRequest" => [
              "RatePickupIndicator" => "N",
              "Shipper" => [
                "Account" => [
                  "AccountNumber" => $credentials->getShipperNumber(),
                  "AccountCountryCode" => $credentials->getShipperCountryCode()
                ]
              ],
              "PickupDateInfo" => [
                "CloseTime" => $booking->getPickupCloseTime(),
                "ReadyTime" => $booking->getPickupReadyTime(),
                "PickupDate" => $booking->getPickupDate()
              ],
              'PickupAddress' => [
                'CompanyName' => $pickupAddress->getFullName(),
                'ContactName' => $pickupAddress->getContactPerson(),
                'AddressLine' => $pickupAddress->getAddress(),
                'Room' => $pickupAddress->getApartmentNumber(),
                'City' => $pickupAddress->getCity(),
                'PostalCode' => $pickupAddress->getZipCode(),
                'CountryCode' => $pickupAddress->getCountryCode(),
                'ResidentialIndicator' => $pickupAddress->getResidentialIndicator(),
                'PickupPoint' => $pickupAddress->getResidentialIndicator(),
                'Phone' => [
                  'Number' => $pickupAddress->getPhone(),
                ]
              ],
              "AlternateAddressIndicator" => "N",
              "PickupPiece" => $pickupPiece,
              "TotalWeight" => [
                "Weight" => $booking->getTotalWeight(),
                "UnitOfMeasurement" => $booking->getUnitOfWeightCode()
              ],
              "OverweightIndicator" => "N",
              "PaymentMethod" => "01",
            ]
        ];

        return $payload;
    }
}
