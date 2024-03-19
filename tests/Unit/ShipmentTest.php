<?php

namespace Sylapi\Courier\Ups\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Ups\Entities\Parcel;
use Sylapi\Courier\Ups\Entities\Receiver;
use Sylapi\Courier\Ups\Entities\Sender;
use Sylapi\Courier\Ups\Entities\Shipment;

class ShipmentTest extends PHPUnitTestCase
{
    public function testNumberOfPackagesIsAlwaysEqualTo1(): void
    {
        $parcel = new Parcel();
        $shipment = new Shipment();
        $shipment->setParcel($parcel);
        $shipment->setParcel($parcel);

        $this->assertEquals(1, $shipment->getQuantity());
    }

    public function testShipmentValidate(): void
    {
        $receiver = new Receiver();
        $sender = new Sender();
        $parcel = new Parcel();

        $shipment = new Shipment();
        $shipment->setSender($sender)
            ->setReceiver($receiver)
            ->setParcel($parcel);

        $this->assertIsBool($shipment->validate());
        $this->assertIsBool($shipment->getReceiver()->validate());
        $this->assertIsBool($shipment->getSender()->validate());
        $this->assertIsBool($shipment->getParcel()->validate());
    }
}
