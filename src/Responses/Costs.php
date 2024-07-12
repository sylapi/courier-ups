<?php

namespace Sylapi\Courier\Ups\Responses;

use Sylapi\Courier\Abstracts\Response as ResponseAbstract;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class Costs extends ResponseAbstract implements ResponseContract
{
    private string $total;

    public function fill(): self
    {
        $total = $this->getResponse()->shipment->grandTotal ?? null;

        if (!$total) {
            throw new \Exception('UPS response error: total not found');
        }

        $this->setTotal($total);

        return $this;
    }


    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }


    public function getTotal(): string
    {
        return $this->total;
    }

}
