<?php

namespace Sylapi\Courier\Ups\Tests\Integration;

use Sylapi\Courier\Ups\Entities\Parcel;
use Sylapi\Courier\Ups\Entities\Sender;
use Sylapi\Courier\Ups\Entities\Options;
use Sylapi\Courier\Ups\Entities\Receiver;
use Sylapi\Courier\Ups\Entities\Shipment;
use Sylapi\Courier\Ups\CourierCreateShipment;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Ups\Tests\Helpers\SessionTrait;
use Sylapi\Courier\Ups\Responses\Shipment as ResponsesShipment;

class CourierCreateShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    private function getShipmentMock()
    {
        $shipmentMock = $this->createMock(Shipment::class);
        $senderMock = $this->createMock(Sender::class);
        $receiverMock = $this->createMock(Receiver::class);
        $parcelMock = $this->createMock(Parcel::class);
        $optionsMock = $this->createMock(Options::class);
        

        $shipmentMock->method('getSender')->willReturn($senderMock);
        $shipmentMock->method('getReceiver')->willReturn($receiverMock);
        $shipmentMock->method('getParcel')->willReturn($parcelMock);
        $shipmentMock->method('getOptions')->willReturn($optionsMock);
        $shipmentMock->method('getContent')->willReturn('Description');
        $shipmentMock->method('validate')->willReturn(true);


        return $shipmentMock;
    }

    public function testCreateShipmentSuccess(): void
    {
        $courierCreateShipment = new CourierCreateShipment(
            $this->getSession([
                ['file' => __DIR__.'/Mock/CourierCreateShipmentSuccess.json', 'code' => 200]
            ])
        );

        $response = $courierCreateShipment->createShipment($this->getShipmentMock());

        $this->assertInstanceOf(ResponsesShipment::class, $response);
        $this->assertEquals($response->getShipmentId(), '123');
    }

    public function testCreateShipmentFailure(): void
    {
        $courierCreateShipment = new CourierCreateShipment(
            $this->getSession([
                ['file' => __DIR__.'/Mock/CourierCreateShipmentFailure.json', 'code' => 400]
            ])
        );
        $this->expectException(TransportException::class);

        $courierCreateShipment->createShipment($this->getShipmentMock());

    }
}
