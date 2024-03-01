<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Sylapi\Courier\Abstracts\Credentials as CredentialsAbstract;

class Credentials extends CredentialsAbstract
{
    public function setShipperNumber(string $shipperNumber): self
    {
        $this->set('shipperNumber', $shipperNumber);

        return $this;
    }

    public function getShipperNumber(): string
    {
        return $this->get('shipperNumber');
    }
    
    public function setShipperCountryCode(string $shipperCountryCode): self
    {
        $this->set('shipperCountryCode', $shipperCountryCode);

        return $this;
    }

    public function getShipperCountryCode(): string
    {
        return $this->get('shipperCountryCode');
    }

    public function setTransId(string $transId): self
    {
        $this->set('transId', $transId);

        return $this;
    }

    public function getTransId(): string
    {
        return $this->get('transId', uniqid());
    }

    public function setTransactionSrc(string $transactionSrc): self
    {
        $this->set('transactionSrc', $transactionSrc);

        return $this;
    }

    public function getTransactionSrc(): string
    {
        return $this->get('transactionSrc', $this->getSandbox() ? 'testing' : 'production');
    }
}
