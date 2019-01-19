PostNord parcelshop (tested with Denmark and Sweden)
============================

[![Build Status](https://travis-ci.org/Parcelshop/postdanmark-parcelshop.svg?branch=master)](https://travis-ci.org/Parcelshop/postdanmark-parcelshop)

Get parcelshops from either

* A parcelshop number
* A danish zipcode
* Nearby an address

### Connecting

You will need an ApiKey to get access to the API

[You can get the ApiKey here](https://developer.postnord.com/)

### Get single parcelshop by Id

````php
<?php
require 'vendor/autoload.php';

use Lsv\PdDk\Client;

$p = new Client( API_KEY );
$shop = $p->getParcelshop( ZIPCODE , ID );
// Yes zipcode is unfortunately mandatory
````

Throws ````Exceptions\ParcelNotFoundException```` if not found

Returns ````$shop```` is a ````Entity\Parcelshop```` object

### Get parcelshops from a zipcode

````php
<?php
require 'vendor/autoload.php';

use Lsv\PdDk\Client;

$p = new Client( API_KEY );
$shops = $p->getParcelshopsFromZipcode( ZIPCODE );
````

Throws ````Exceptions\NoParcelsFoundInZipcodeException```` if none found

Returns ````$shops```` is a array of ````Entity\Parcelshop````

### Get parcelshops near address
 
````php
<?php
require 'vendor/autoload.php';

use Lsv\PdDk\Client;

$p = new Client( API_KEY );
$shops = $p->getParcelshopsNearAddress( STREET , ZIPCODE, 20 );
````

Third argument is how many you want

Throws ````Exceptions\MalformedAddressException```` if address is unknown

Returns ````$shops```` is a array of ````Entity\Parcelshop````
 
### Add retry guzzle client

First install it with composer

````
composer require guzzlehttp/retry-subscriber
````

Now create our client

````php
<?php
require 'vendor/autoload.php';

use Lsv\PdDk\Client;
use GuzzleHttp\Subscriber\Retry\RetrySubscriber;

$retry = new RetrySubscriber([
    'filter' => RetrySubscriber::createStatusFilter()
]);

$httpClient = new GuzzleHttp\Client();
$httpClient->getEmitter()->attach($retry);

$p = new Client($httpClient);
$shops = $p->getParcelshopsNearAddress( STREET , ZIPCODE, 20 );
````
