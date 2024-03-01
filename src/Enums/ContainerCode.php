<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;


enum ContainerCode: string {
    /**
     * 01 = PACKAGE
     * 02 = UPS LETTER
     * 03 = PALLET
     */
    case PACKAGE = '01';
    case UPS_LETTER = '02';
    case PALLET = '03';
}