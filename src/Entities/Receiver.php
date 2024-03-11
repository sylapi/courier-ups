<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Receiver as ReceiverAbstract;

class Receiver extends ReceiverAbstract
{
    private ?string $countryCode = null;

    public function getCountryCode(): ?string
    {
        return ($this->countryCode === null) ? null: strtoupper($this->countryCode);
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
