<?php

namespace Sylapi\Courier\Ups\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Ups\StatusTransformer;

class StatusTransformerTest extends PHPUnitTestCase
{
    public function testStatusTransformer(): void
    {
        $statusTransformer = new StatusTransformer('DELIVERED');
        $this->assertEquals(StatusType::DELIVERED->value, (string) $statusTransformer);
    }
}
