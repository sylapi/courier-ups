<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Sylapi\Courier\Abstracts\Options as OptionsAbstract;

class Options extends OptionsAbstract
{
    const REQUEST_OPTION = 'nonvalidate';


    public function setPackagingCode(string $packagingCode): self
    {
        $this->set('packagingCode', $packagingCode);
        return $this;
    }

    public function getPackagingCode(): ?string
    {
        return $this->get('packagingCode');
    }

    public function getSpeditionCode(): ?string
    {
        return $this->get('speditionCode');
    }

    public function setSpeditionCode(string $speditionCode): self
    {
        $this->set('speditionCode', $speditionCode);
        return $this;
    }
    
    public function getSubVersion(): ?string
    {
        return $this->get('subVersion');
    }

    public function setSubVersion(string $subVersion): self
    {
        $this->set('subVersion', $subVersion);
        return $this;
    }

    public function getRequestOption(): string
    {
        return $this->get('requestOption', self::REQUEST_OPTION);
    }

    public function setRequestOption(string $requestOption): self
    {
        $this->set('requestOption', $requestOption);
        return $this;
    }

    public function validate(): bool
    {
        return true;
    }
}
