<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Responses\Label as LabelResponse;
use Sylapi\Courier\Contracts\CourierGetLabels as CourierGetLabelsContract;
use Sylapi\Courier\Contracts\LabelType as LabelTypeContract;

class CourierGetLabels implements CourierGetLabelsContract
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId, LabelTypeContract $labelType): LabelResponse
    {
        try {
            //TODO:
            var_dump( $this->session );
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        return new LabelResponse(base64_decode('CONTENT'));
    }

    
}
