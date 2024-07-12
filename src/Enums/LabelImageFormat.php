<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Enums;


enum LabelImageFormat: string {
    /**
     * GIF -- label is in HTML format.
     * PDF -- label is in PDF format.
     * ZPL -- Thermal label in ZPL format.
     * EPL -- Thermal label in EPL2 format.
     * SPL -- Thermal label in SPL format.
     */
    case GIF = 'GIF';
    case PDF = 'PDF';
    case ZPL = 'ZPL';
    case EPL = 'EPL';
    case SPL = 'SPL';
}