<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Responses\Status as StatusResponse;
use Sylapi\Courier\Contracts\CourierGetStatuses as CourierGetStatusesContract;


class CourierGetStatuses implements CourierGetStatusesContract
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getStatus(string $shipmentId): StatusResponse
    {
        try {
            //TODO:
            var_dump( $this->session );
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        
        //TODO: get status from API

        $originalStatus = 'PENDING';

        return new StatusResponse((string) new StatusTransformer($originalStatus), $originalStatus);
    }

}
