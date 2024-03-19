<?php

namespace Sylapi\Courier\Olza\Tests\Integration;

use Sylapi\Courier\Contracts\Label;
use Sylapi\Courier\Ups\CourierGetLabels;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Ups\Entities\LabelType;
use Sylapi\Courier\Ups\Tests\Helpers\SessionTrait;

class CourierGetLabelsTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testGetLabelsFailure(): void
    {
        $courierGetLabels = new CourierGetLabels(
            $this->getSession([
                ['file' => __DIR__.'/Mock/CourierGetLabelsFailure.json', 'code' => 400]
            ])
        );

        $this->expectException(TransportException::class);
        $labelTypeMock = $this->createMock(LabelType::class);
        $courierGetLabels->getLabel('1Z023E2X0214323462',$labelTypeMock);
    }
}
