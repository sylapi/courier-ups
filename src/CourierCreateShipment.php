<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Contracts\Shipment;
use Sylapi\Courier\Ups\Entities\Parcel;
use Sylapi\Courier\Ups\Entities\Options;
use Sylapi\Courier\Ups\Entities\Credentials;
use Sylapi\Courier\Exceptions\ValidateException;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Helpers\ValidateErrorsHelper;
use Sylapi\Courier\Ups\Entities\Shipment as ShipmentEntity;

use Sylapi\Courier\Ups\Responses\Shipment as ShipmentResponse;
use Sylapi\Courier\Contracts\CourierCreateShipment as CourierCreateShipmentContract;

class CourierCreateShipment implements CourierCreateShipmentContract
{

  const API_PATH = '/api/shipments/v1/ship';

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

            $payload = $this->getPayload($shipment, $this->session->credentials());

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

        $response->setResponse($response);

        $response->setReferenceId((string) $result->ShipmentResponse?->Response?->TransactionReference?->TransactionIdentifier);
        $response->setShipmentId((string) $result->ShipmentResponse?->ShipmentResults?->ShipmentIdentificationNumber);
        return $response;
    }

    private function getPayload(Shipment $shipment, Credentials $credentials)
    {
        /**
         * @var Options $options
         * @var ShipmentEntity $shipment
         */
        $options = $shipment->getOptions();
        $sender = $shipment->getSender();
        $receiver = $shipment->getReceiver();
        /**
         * @var Parcel $parcel
         */
        $parcel = $shipment->getParcel();

        $payload = [
            'ShipmentRequest' => [
                'Request' => [
                    'RequestOption' => $options->getRequestOption()
                ],
                'Shipment' => [
                  'Description' => $shipment->getContent(),
                  'Shipper' => [
                      'Name' => $sender->getFullName(),
                      "AttentionName" => $sender->getFullName(),
                      'Phone' => [
                        'Number' => $sender->getPhone(),
                      ],
                      'ShipperNumber' => $credentials->getShipperNumber(),
                      'Address' => [
                          'AddressLine' => [
                              $sender->getAddress()
                          ],
                          'City' => $sender->getCity(),
                          'PostalCode' => $sender->getZipCode(),
                          'CountryCode' => $sender->getCountryCode()
                      ]
                  ],
                
                  'ShipTo' => [
                      'Name' => $receiver->getFullName(),
                      "AttentionName" => $receiver->getFullName(),
                      'Phone' => [
                        'Number' => $receiver->getPhone()
                      ],
                      'Address' => [
                          'AddressLine' => [
                              $receiver->getAddress()                          
                          ],
                          'City' => $receiver->getCity(),
                          'PostalCode' => $receiver->getZipCode(),
                          'CountryCode' => $receiver->getCountryCode()
                      ],
                  ],

                  'ShipFrom' => [
                    'Name' => $sender->getFullName(),
                    'Phone' => [
                      'Number' => $sender->getPhone()
                    ],
                    'Address' => [
                        'AddressLine' => [
                            $sender->getAddress()                          
                        ],
                        'City' => $sender->getCity(),
                        'PostalCode' => $sender->getZipCode(),
                        'CountryCode' => $sender->getCountryCode()
                    ],
                  ],
                  'PaymentInformation' => [
                    'ShipmentCharge' => [
                      'Type' => $options->getPackagingCode(),
                      'BillShipper' => [
                        'AccountNumber' => $credentials->getShipperNumber()
                      ]
                    ]
                  ],
                  'Service' => [
                    'Code' => $options->getSpeditionCode(),
                  ],
                  'Package' => [
                    'Packaging' => [
                      'Code' => '02',
                    ],
                    'Dimensions' => [
                      'UnitOfMeasurement' => [
                        'Code' => $parcel->getUnitOfDimensionsCode(),
                        'Description' => $parcel->getUnitOfDimensionsDescription()
                      ],
                      'Length' => (string) $parcel->getLength(),
                      'Width' => (string) $parcel->getWidth(),
                      'Height' => (string) $parcel->getHeight()
                    ],
                    'PackageWeight' => [
                      'UnitOfMeasurement' => [
                        'Code' => $parcel->getUnitOfWeightCode(),
                        'Description' => $parcel->getUnitOfWeightDescription()
                      ],
                      'Weight' => (string) $parcel->getWeight()
                    ]
                  ]
                ],
                'LabelSpecification' => [
                  'LabelImageFormat' => [
                    'Code' => $shipment->getLabelType()->getLabelType()
                  ],
                  'HTTPUserAgent' => 'Mozilla/4.5'
                ]
            ]
        ];

        $services = $shipment->getServices();
        
        if($services) {
            foreach($services as $service) {
                $service->setRequest($payload);
                $payload = $service->handle();
            }
        } 

        if($options->get('subVersion')) {
            $payload['ShipmentRequest']['Request']['SubVersion'] = $options->get('subVersion');
        }

        if($shipment->getReferenceId()) {
            $payload['ShipmentRequest']['Request']['TransactionReference'] = [
                'CustomerContext' => $shipment->getReferenceId()
            ];
        }

        if($shipment->getContent()) {
            $payload['ShipmentRequest']['Shipment']['Description'] = $shipment->getContent();
        }

        // var_dump($payload);
        return $payload;
    }
}
