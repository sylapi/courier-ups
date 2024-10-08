<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Ups\Entities\LabelType;
use Sylapi\Courier\Abstracts\Shipment as ShipmentAbstract;

class Shipment extends ShipmentAbstract
{
    private LabelType $labelType;

    public function getLabelType(): LabelType
    {
        return $this->labelType;
    }

    public function setLabelType(LabelType $labelType): self
    {
        $this->labelType = $labelType;

        return $this;
    }

    public function getQuantity(): int
    {
        return 1;
    }

    public function validate(): bool
    {
        $rules = [
            'quantity' => 'required|min:1|max:1',
            'parcel'   => 'required',
            'sender'   => 'required',
            'receiver' => 'required',
        ];

        $data = [
            'quantity' => $this->getQuantity(),
            'parcel'   => $this->getParcel(),
            'sender'   => $this->getSender(),
            'receiver' => $this->getReceiver(),
        ];

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());

            return false;
        }

        return true;
    }
}
