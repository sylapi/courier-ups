<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Parcel as ParcelAbstract;

class Parcel extends ParcelAbstract
{
    const DEFAULT_UNIT_OF_DIMENSIONS_CODE = 'CM';
    const DEFAULT_UNIT_OF_DIMENSIONS_DESCRIPTION = 'Centimeters';

    const DEFAULT_UNIT_OF_WEIGHT_CODE = 'KGS';
    const DEFAULT_UNIT_OF_WEIGHT_DIMENSIONS_DESCRIPTION = 'Kilograms';

    private string $unitOfDimensionsCode = self::DEFAULT_UNIT_OF_DIMENSIONS_CODE;
    private string $unitOfDimensionsDescription = self::DEFAULT_UNIT_OF_DIMENSIONS_DESCRIPTION;

    private string $unitOfWeightCode = self::DEFAULT_UNIT_OF_WEIGHT_CODE;
    private string $unitOfWeightDescription = self::DEFAULT_UNIT_OF_WEIGHT_DIMENSIONS_DESCRIPTION;

    private string $containerCode;


    public function getUnitOfDimensionsCode(): string
    {
        return  $this->unitOfDimensionsCode;
    }

    public function setUnitOfDimensionsCode(string $unitOfDimensionsCode): ParcelAbstract
    {
        $this->unitOfDimensionsCode = $unitOfDimensionsCode;

        return $this;
    }

    public function getUnitOfDimensionsDescription(): string
    {
        return  $this->unitOfDimensionsDescription;
    }

    public function setUnitOfDimensionsDescription(string $unitOfDimensionsDescription): ParcelAbstract
    {
        $this->unitOfDimensionsDescription = $unitOfDimensionsDescription;

        return $this;
    }

    public function getUnitOfWeightCode(): string
    {
        return  $this->unitOfWeightCode;
    }

    public function setUnitOfWeightCode(string $unitOfWeightCode): ParcelAbstract
    {
        $this->unitOfWeightCode = $unitOfWeightCode;

        return $this;
    }

    public function getUnitOfWeightDescription(): string
    {
        return  $this->unitOfWeightDescription;
    }

    public function setUnitOfWeightDescription(string $unitOfWeightDescription): ParcelAbstract
    {
        $this->unitOfWeightDescription = $unitOfWeightDescription;

        return $this;
    }

    public function getContainerCode(): string
    {
        return  $this->containerCode;
    }

    public function setContainerCode(string $containerCode): ParcelAbstract
    {
        $this->containerCode = $containerCode;

        return $this;
    }

    public function validate(): bool
    {
        $rules = [
            'length' => 'required|numeric|min:0.01',
            'weight' => 'required|numeric|min:0.01',
            'height' => 'required|numeric|min:0.01',
        ];
        $data = [
            'length' => $this->getLength(),
            'weight' => $this->getWeight(),
            'height' => $this->getHeight(),
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
