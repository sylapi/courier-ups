<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;


enum RatingRequestOption: string {
    case RATE = 'Rate';
    case SHOP = 'Shop';
    case RATE_TIME_IN_TRANSIT = 'Ratetimeintransit';
    case SHOP_TIME_IN_TRANSIT = 'Shoptimeintransit';
}