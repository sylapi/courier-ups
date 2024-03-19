<?php

namespace Sylapi\Courier\Ups\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Courier;
use Sylapi\Courier\Ups\Entities\Booking;
use Sylapi\Courier\Ups\CourierApiFactory;
use Sylapi\Courier\Ups\Entities\Parcel;
use Sylapi\Courier\Ups\Entities\Receiver;
use Sylapi\Courier\Ups\Entities\Sender;
use Sylapi\Courier\Ups\Session;
use Sylapi\Courier\Ups\SessionFactory;
use Sylapi\Courier\Ups\Entities\Shipment;
use Sylapi\Courier\Ups\Entities\Credentials;

class CourierApiFactoryTest extends PHPUnitTestCase
{
    public function testUpsSessionFactory(): void
    {
        $credentials = new Credentials();
        $credentials->setLogin('login');
        $credentials->setPassword('password');
        $credentials->setSandbox(true);
        $sessionFactory = new SessionFactory();
        $session = $sessionFactory->session(
            $credentials
        );
        $this->assertInstanceOf(Session::class, $session);
    }

    public function testCourierFactoryCreate(): void
    {
        $credentials = [
            'login' => 'login',
            'password' => 'password',
            'sandbox' => true,
        ];

        $courierApiFactory = new CourierApiFactory(new SessionFactory());
        $courier = $courierApiFactory->create($credentials);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(Booking::class, $courier->makeBooking());
        $this->assertInstanceOf(Parcel::class, $courier->makeParcel());
        $this->assertInstanceOf(Receiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(Sender::class, $courier->makeSender());
        $this->assertInstanceOf(Shipment::class, $courier->makeShipment());
    }
}
