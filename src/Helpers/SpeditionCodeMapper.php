<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Helpers;

use Sylapi\Courier\Ups\Enums\SpeditionCode;
use Sylapi\Courier\Ups\Enums\PickupSpeditionCode;

class SpeditionCodeMapper {
    public static function mapToPickupSpeditionCode(SpeditionCode $speditionCode): ?PickupSpeditionCode {
        switch ($speditionCode) {
            case SpeditionCode::NEXT_DAY_AIR:
                return PickupSpeditionCode::NEXT_DAY_AIR;
            case SpeditionCode::SECOND_DAY_AIR:
                return PickupSpeditionCode::SECOND_DAY_AIR;
            case SpeditionCode::GROUND:
                return PickupSpeditionCode::GROUND;
            case SpeditionCode::EXPRESS:
                return PickupSpeditionCode::EXPRESS;
            case SpeditionCode::EXPEDITED:
                return PickupSpeditionCode::EXPEDITED;
            case SpeditionCode::UPS_STANDARD:
                return PickupSpeditionCode::UPS_STANDARD;
            case SpeditionCode::THREE_DAY_SELECT:
                return PickupSpeditionCode::THREE_DAY_SELECT;
            case SpeditionCode::NEXT_DAY_AIR_SAVER:
                return PickupSpeditionCode::NEXT_DAY_AIR_SAVER;
            case SpeditionCode::UPS_NEXT_DAY_AIR_EARLY:
                return PickupSpeditionCode::UPS_NEXT_DAY_AIR_EARLY;
            case SpeditionCode::UPS_EXPRESS_SAVER:
                return PickupSpeditionCode::UPS_SAVER;                    
            default:
                throw new \InvalidArgumentException('SpeditionCodeMapper: Invalid spedition code, cannot map to pickup spedition code.');
        }
    }
}
