<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Address;

class PickupAddress extends Address
{
    private ?string $pickupPoint = null;
    private bool $residentialIndicator = false;
    private ?string $countryCode = null;

    public function getCountryCode(): ?string
    {
        return ($this->countryCode === null) ? null: strtoupper($this->countryCode);
    }


    public function setPickupPoint(string $pickupPoint): self
    {
        $this->pickupPoint = $pickupPoint;
        return $this;
    }

    public function getPickupPoint(): ?string
    {
        return $this->pickupPoint;
    }

    public function setResidentialIndicator(bool $isResidentialIndicator): self
    {
        $this->residentialIndicator = $isResidentialIndicator;
        return $this;
    }

    public function getResidentialIndicator(): string
    {
        return $this->residentialIndicator ? 'Y' : 'N';
    }
    

    public function validate(): bool
    {
        $rules = [
            'firstName'   => 'required',
            'surname'     => 'required',
            'countryCode' => 'required|min:2|max:2',
            'city'        => 'required',
            'zipCode'     => 'required',
            'street'      => 'required',
            'address'     => 'required',
            'email'       => 'required|email',
        ];

        $data = $this->toArray();

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());

            return false;
        }

        return true;
    }
}
