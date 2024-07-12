<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Utilities;

use Sylapi\Courier\Ups\Session;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Entities;
use Sylapi\Courier\Ups\Responses;

class Costs 
{
    const API_PATH = '/api/landedcost/v1/quotes';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function costs(Entities\Costs $costs): Responses\Costs
    {
    
        $response = new Responses\Costs();

        try {
            $payload = $this->getPayload($costs);

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


    private function getPayload(Entities\Costs $costs): array
    {
        return [
            'currencyCode' => 'PLN',
            'transID' => (string) rand(1000, 9999),
            'allowPartialLandedCostResult' => false,
            'shipment' => [
                'id' => 'ShipmentID'.rand(1000, 9999),
                'importCountryCode' => 'PL',
                'importProvince' => '',
                'shipDate' => '',
                'exportCountryCode' => 'DE',
                'incoterms' => '',
                'shipmentItems' => [
                    [
                        'commodityId' => '1',
                        'grossWeight' => '',
                        'grossWeightUnit' => '',
                        'priceEach' => '125',
                        'hsCode' => "9506.62",
                        'description' => 'Product description',
                        'quantity' => 1,
                        'UOM' => 'Each',
                        'originCountryCode' => 'PL',
                        'commodityCurrencyCode' => 'PLN',
                    ]
                ],
                'transModes' => '',
                'transportCost' => '100',
                'shipmentType' => 'Sale'
            ]
        ];
    }
}
