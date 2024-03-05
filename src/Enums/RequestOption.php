<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;

enum RequestOption: string {
    case VALIDATE = 'validate';
    case NON_VALIDATE = 'nonvalidate';
}