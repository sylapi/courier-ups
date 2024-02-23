<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;



enum ShipmentType :string {
    case DIRECT = 'DIRECT';
    case WAREHOUSE = 'WAREHOUSE';
}