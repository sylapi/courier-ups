<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;

enum PickupSpeditionCode: string {
    case NEXT_DAY_AIR = '001';
    case SECOND_DAY_AIR = '002';
    case GROUND = '003';
    case GROUND_STANDARD = '004';
    case EXPRESS = '007';
    case EXPEDITED = '008';
    case UPS_STANDARD = '011';
    case THREE_DAY_SELECT = '012';
    case NEXT_DAY_AIR_SAVER = '013';
    case UPS_NEXT_DAY_AIR_EARLY = '014';
    case UPS_ECONOMY = '021';
    case UPS_BASIC = '031';
    case EXPRESS_PLUS = '054';
    case SECOND_DAY_AIR_AM = '059';
    case UPS_EXPRESS_NA1 = '064';
    case UPS_SAVER = '065';
    case UPS_WORLDWIDE_EXPRESS_FREIGHT_MIDDAY = '071';
    case UPS_EXPRESS_1200 = '074';
    case UPS_TODAY_STANDARD = '082';
    case UPS_TODAY_DEDICATED_COURIER = '083';
    case UPS_TODAY_INTERCITY = '084';
    case UPS_TODAY_EXPRESS = '085';
    case UPS_TODAY_EXPRESS_SAVER = '086';
    case UPS_WORLDWIDE_EXPRESS_FREIGHT = '096';  
}


