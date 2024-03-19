<?php

namespace Sylapi\Courier\Ups\Tests\Integration;

use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Ups\CourierGetStatuses;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Ups\Tests\Helpers\SessionTrait;

class CourierGetStatusesTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testGetStatusSuccess(): void
    {
        $courierGetStatuses = new CourierGetStatuses(
            $this->getSession([
                ['file' => __DIR__.'/Mock/CourierGetStatusSuccess.json', 'code' => 200]
            ])
        );

        $response = $courierGetStatuses->getStatus('1Z023E2X0214323462');
        $this->assertEquals($response, StatusType::DELIVERED->value);
    }

    public function testGetStatusFailure(): void
    {
        $courierGetStatuses = new CourierGetStatuses(
            $this->getSession([
                ['file' => __DIR__.'/Mock/CourierGetStatusFailure.json', 'code' => 400]
            ])
        );

        $this->expectException(TransportException::class);
        $courierGetStatuses->getStatus('1Z023E2X0214323462');
    }
}
