<?php

namespace Sylapi\Courier\Ups\Tests\Integration;

use Sylapi\Courier\Ups\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Ups\Entities\Booking;
use Sylapi\Courier\Ups\CourierPostShipment;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Ups\Tests\Helpers\SessionTrait;

class CourierPostShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    private function getBookingMock($shipmentId)
    {
        $bookingMock = $this->createMock(Booking::class);
        $bookingMock->method('getShipmentId')->willReturn($shipmentId);
        $bookingMock->method('validate')->willReturn(true);

        return $bookingMock;
    }

    public function testPostShipmentSuccess(): void
    {
        $courierPostShipment = new CourierPostShipment(
            $this->getSession([
                ['file' => __DIR__.'/Mock/CourierPostShipmentSuccess.json', 'code' => 200]
            ])
        );

        $shipmentId = '123';
        $booking = $this->getBookingMock($shipmentId);
        $response = $courierPostShipment->postShipment($booking);

        $this->assertInstanceOf(ParcelResponse::class, $response);
        $this->assertEquals($response->getShipmentId(), $shipmentId);
    }

    public function testPostShipmentFailure(): void
    {
        $courierPostShipment = new CourierPostShipment(
            $this->getSession([
                ['file' => __DIR__.'/Mock/CourierPostShipmentFailure.json', 'code' => 400]
            ])
        );

        $shipmentId = '123';
        $this->expectException(TransportException::class);
        $booking = $this->getBookingMock($shipmentId);
        $courierPostShipment->postShipment($booking);
    }
}
