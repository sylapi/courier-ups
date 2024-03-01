<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Ups\Responses\Label as LabelResponse;
use Sylapi\Courier\Contracts\CourierGetLabels as CourierGetLabelsContract;
use Sylapi\Courier\Contracts\LabelType as LabelTypeContract;

class CourierGetLabels implements CourierGetLabelsContract
{

    const API_PATH = '/api/labels/v1/recovery';
    
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId, LabelTypeContract $labelType): LabelResponse
    {
        try {
            $payload = $this->getPayload([$shipmentId], $labelType);
            $stream = $this->session
            ->client()
            ->request(
                'POST',
                self::API_PATH,
                [ 'body' => json_encode($payload) ]
            );

            $result = json_decode($stream->getBody()->getContents());

            $labelContent = $result?->LabelRecoveryResponse?->LabelResults?->LabelImage?->GraphicImage ?? null;

            if($labelContent === null) {
                throw new TransportException('Label not found', 404);
            }
           
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }

        return new LabelResponse($labelContent);
    }

    private function getPayload(array $shipmentId, LabelTypeContract $labelType): array
    {
        $payload = [
          'LabelRecoveryRequest' => [
            'TrackingNumber' => $shipmentId,
          ]
        ];
        
        return $payload;
    }

    
}
