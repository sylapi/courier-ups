<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Responses\Status as StatusResponse;
use Sylapi\Courier\Contracts\CourierGetStatuses as CourierGetStatusesContract;


class CourierGetStatuses implements CourierGetStatusesContract
{
    const API_PATH = '/api/track/v1/details/';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getStatus(string $shipmentId): StatusResponse
    {
        try {
            $query = [
                'locale' => 'en_US',
                'returnSignature' => 'false',
                'returnMilestones' => 'false'
            ];

            $stream = $this->session
              ->client()
              ->request(
                  'GET',
                  self::API_PATH . $shipmentId . "?" . http_build_query($query)
              );
              
                $result = json_decode($stream->getBody()->getContents());

                $originalStatus = $result->trackResponse?->shipment[0]?->package[0]?->activity[0]?->status?->description ?? null;
        
                if($originalStatus === null) {
                    throw new TransportException('Status not found', 404);
                }
             
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }
        

        return new StatusResponse((string) new StatusTransformer($originalStatus), $originalStatus);
    }

    public function getPayload(string $shipmentId): array
    {
        return [
            'shipmentId' => $shipmentId
        ];
    }

}
