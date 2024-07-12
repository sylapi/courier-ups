<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Utilities;

use Sylapi\Courier\Ups\Session;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Entities;
use Sylapi\Courier\Ups\Responses;
use Sylapi\Courier\Ups\Entities\Credentials;
use Sylapi\Courier\Ups\Entities\Parcel;
use Sylapi\Courier\Ups\Entities\Options;

class Rating 
{
    const API_PATH = '/api/rating/v1/{requestoption}';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function rating(Entities\Rating $rating): Responses\Rating
    {
    
        $response = new Responses\Rating();

        try {
            $payload = $this->getPayload($rating, $this->session->credentials());

            $response->setRequest($payload);
            $stream = $this->session
            ->client()
            ->request(
                'POST',
                $this->getApiPath($rating->getRequestOption()),
                [ 
                    'body' => json_encode($payload), 
                    'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$payloadData) {
                                $request = $stats->getRequest();
                                $payloadData['request'] = [
                                    'method' => $request->getMethod(),
                                    'uri' => (string) $request->getUri(),
                                    'headers' => $request->getHeaders(),
                                    'body' => (string) $request->getBody()
                                ];
                            }                    
                ]
            );

            $result = json_decode($stream->getBody()->getContents());
            $response->setResponse($result);
            $response->fill();

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

        //     var_dump($responseBodyAsString);
        //     var_dump($payloadData);
        //    echo  json_encode($payloadData, JSON_PRETTY_PRINT);

            throw new TransportException($e->getMessage(), $e->getCode());
        }
        

        return $response;
    }

    private function getApiPath(string $requestOption): string
    {
        return str_replace('{requestoption}', $requestOption, self::API_PATH);
    }


    private function getPayload(Entities\Rating $rating, Credentials $credentials): array
    {
        $shipment = $rating->getShipment();
        /**
         * @var Options $options
         */
        $options = $shipment->getOptions();        
        $sender = $shipment->getSender();
        $receiver = $shipment->getReceiver();

        /**
         * @var Parcel $parcel
         */
        $parcel = $shipment->getParcel();

        return [
            'RateRequest' => [
                'Request' => [
                    'RequestOption' => $rating->getRequestOption()
                ],
                'Shipment' => [
                    'Shipper' => [
                        'Name' => $sender->getFullName(),
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
                        'Address' => [
                            'AddressLine' => [
                                $sender->getAddress()
                              ],
                            'City' => $sender->getCity(),
                            'PostalCode' => $sender->getZipCode(),
                            'CountryCode' => $sender->getCountryCode()
                        ]
                    ],
                    'PaymentDetails' => [
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
                    'NumOfPieces' => $shipment->getQuantity(),
                    'InvoiceLineTotal' => [
                        'CurrencyCode' => $rating->getInvoiceCurrencyCode(),
                        'MonetaryValue' => $rating->getInvoiceTotalValue()
                    ],
                    'Package' => [
                        'PackagingType' => [
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
                    ],
                    'DeliveryTimeInformation' => [
                        'PackageBillType' => '03'
                    ],
                    'ShipmentTotalWeight' => [
                        'UnitOfMeasurement' => [
                            'Code' => $parcel->getUnitOfWeightCode(),
                            
                            'Description' => $parcel->getUnitOfWeightDescription()

                        ],
                        'Weight' => (string) $parcel->getWeight()
                    ]
                ],
                                
            ],

        ];
    }
}
