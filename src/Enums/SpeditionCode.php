<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;

enum SpeditionCode: string {
    case NEXT_DAY_AIR = '01';
    case SECOND_DAY_AIR = '02';
    case GROUND = '03';
    case EXPRESS = '07';
    case EXPEDITED = '08';
    case UPS_STANDARD = '11';
    case THREE_DAY_SELECT = '12';
    case NEXT_DAY_AIR_SAVER = '13';
    case UPS_NEXT_DAY_AIR_EARLY = '14';
    case UPS_WORLDWIDE_ECONOMY_DDU = '17';
    case EXPRESS_PLUS = '54';
    case SECOND_DAY_AIR_AM = '59';
    case UPS_EXPRESS_SAVER = '65';
    case FIRST_CLASS_MAIL = 'M2';
    case PRIORITY_MAIL = 'M3';
    case EXPEDITED_MAIL_INNOVATIONS = 'M4';
    case PRIORITY_MAIL_INNOVATIONS = 'M5';
    case ECONOMY_MAIL_INNOVATIONS = 'M6';
    case MAIL_INNOVATIONS_MI_RETURNS = 'M7';
    case UPS_ACCESS_POINT_ECONOMY = '70';
    case UPS_WORLDWIDE_EXPRESS_FREIGHT_MIDDAY = '71';
    case UPS_WORLDWIDE_ECONOMY_DDP = '72';
    case UPS_EXPRESS_1200 = '74';
    case UPS_HEAVY_GOODS = '75';
    case UPS_TODAY_STANDARD = '82';
    case UPS_TODAY_DEDICATED_COURIER = '83';
    case UPS_TODAY_INTERCITY = '84';
    case UPS_TODAY_EXPRESS = '85';
    case UPS_TODAY_EXPRESS_SAVER = '86';
    case UPS_WORLDWIDE_EXPRESS_FREIGHT = '96';
}