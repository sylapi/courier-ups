<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;


enum PackagingCode: string {
    /**
     *  01 = Transportation 02 = Duties and Taxes 03 = Broker of Choice
     */
    case TRANSPORTATION = '01';
    case DUTIES_AND_TAXES = '02';
    case BROKER_OF_CHOICE = '03';
}