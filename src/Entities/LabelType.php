<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Sylapi\Courier\Ups\Enums\LabelImageFormat;
use Sylapi\Courier\Abstracts\LabelType as LabelTypeAbstract;

class LabelType extends LabelTypeAbstract
{
    private string $labelType;

    public function setLabelType(string $labelType): self
    {
        $this->labelType = $labelType;

        return $this;
    }

    public function getLabelType(): string
    {
        return $this->labelType ?? LabelImageFormat::PDF->value;
    }


    public function validate(): bool
    {
        return true;
    }
}
