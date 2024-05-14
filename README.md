# courier-ups


## Init

```php
$courier = \Sylapi\Courier\CourierFactory::create('Ups',[
    'login' => 'client_id',
    'password' => 'secret',
    'sandbox' => true,
    'shipperNumber' =>'1234AB',
    'shipperCountryCode' => 'PL',
    'transId' => 'string', //OPTIONAL
    'transactionSrc' => 'testing' //OPTIONAL
]);
```

## CreateShipment

```php
$sender = $courier->makeSender();
$sender->setFullName('Nazwa Firmy/Nadawca')
    ->setStreet('Ulica')
    ->setHouseNumber('2a')
    ->setApartmentNumber('1')
    ->setCity('Miasto')
    ->setZipCode('66100')
    ->setCountry('Poland')
    ->setCountryCode('PL')
    ->setContactPerson('Jan Kowalski')
    ->setEmail('my@email.com')
    ->setPhone('48500600700');

$receiver = $courier->makeReceiver();

$receiver->setFirstName('Piotr')
    ->setSurname('Nowak')
    ->setStreet('Ulica')
    ->setHouseNumber('3')
    ->setApartmentNumber('')
    ->setCity('Miasto')
    ->setZipCode('66200')
    ->setCountry('Poland')
    ->setCountryCode('PL')
    ->setProvince('Bacau')
    ->setContactPerson('Piotr Nowak')
    ->setEmail('piotr.nowak@sylapi.com')
    ->setPhone('48500100200');

/**
 * @var \Sylapi\Courier\Ups\Entities\Parcel $parcel
 */
$parcel = $courier->makeParcel();
$parcel->setWeight(5)
    ->setLength(10)
    ->setWidth(10)
    ->setHeight(10)
    ->setContainerCode(ContainerCode::PACKAGE->value);

$options = $courier->makeOptions();
$options->setSpeditionCode(\Sylapi\Courier\Ups\Enums\SpeditionCode::UPS_STANDARD->value)
    ->setPackagingCode(\Sylapi\Courier\Ups\Enums\PackagingCode::TRANSPORTATION->value)
    ->setRequestOption(\Sylapi\Courier\Ups\Enums\RequestOption::NON_VALIDATE->value);

$shipment = $courier->makeShipment();
$shipment->setSender($sender)
        ->setReceiver($receiver)
        ->setParcel($parcel)
        ->setContent('Content')
        ->setReferenceId('1234567890')
        ->setOptions($options);

try {
    $response = $courier->createShipment($shipment);
    var_dump($response->getReferenceId()); // Utworzony wewnetrzny idetyfikator zamowienia
    var_dump($response->getShipmentId()); // Zewnetrzny idetyfikator zamowienia

} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```

## PostShipment

```php
try {
    /**
    * @var \Sylapi\Courier\Ups\Entities\Booking $booking
    */    
    $booking = $response->getBooking();
    $booking->setPickupDateTime('YYYYMMDD', 'HHmm', 'HHmm');
    $pickupAddress = $booking->getPickupAddress();

    $pickupAddress->setFullName('Nazwa Firmy/Nadawca')
        ->setStreet('Ulica')
        ->setHouseNumber('2a')
        ->setApartmentNumber('1')
        ->setCity('Miasto')
        ->setZipCode('66100')
        ->setCountry('Poland')
        ->setCountryCode('PL')
        ->setContactPerson('Jan Kowalski')
        ->setEmail('my@email.com')
        ->setPhone('48500600700');
        ->setResidentialIndicator(false)
        ->setPickupPoint('Lobby');
    
    $booking->setPickupAddress($pickupAddress);
    $booking->addShipment($shipment);
    
    $response = $courier->postShipment($booking);
    var_dump($response->getShipmentId()); // Zewnetrzny idetyfikator zamowienia
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```

## GetStatus

```php
try {  
    $responseStatus = $courier->getStatus($response->getShipmentId());

    var_dump((string )$responseStatus);
    var_dump(($responseStatus->getStatusName()));
    var_dump(($responseStatus->getOriginalStatusName()));
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```

## GetLabel

```php
try {

    $labelType = $courier->makeLabelType();
    $response = $courier->getLabel($response->getShipmentId(), $labelType);
    echo ((string) $response);
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
```

## Komendy

| KOMENDA | OPIS |
| ------ | ------ |
| composer tests | Testy |
| composer phpstan |  PHPStan |
| composer coverage | PHPUnit Coverage |
| composer coverage-html | PHPUnit Coverage HTML (DIR: ./coverage/) |
