Postdanmark parcelshop (for Denmark)
============================

[![Build Status](https://travis-ci.org/lsv/postdanmark-parcelshop-api.svg)](https://travis-ci.org/lsv/postdanmark-parcelshop) [![Coverage Status](https://coveralls.io/repos/lsv/postdanmark-parcelshop/badge.svg?branch=master)](https://coveralls.io/r/lsv/postdanmark-parcelshop?branch=master)

Get parcelshops from either

* A parcelshop number
* A danish zipcode
* Nearby an address

### Connecting

You will need a CONSUMER_ID to get access to the API

[You can get the CONSUMER_ID here](http://www.postdanmark.dk/da/Logistik/netbutikker/vaelg-selv-udleveringssted/Sider/Implementer-vaelg-selv.aspx#tab2)

### Get single parcelshop by Id

````php
<?php
require 'vendor/autoload.php';

use Lsv\PdDk\ParcelShop;

$p = new ParcelShop( CONSUMER_ID );
$shop = $p->getParcelshop( ZIPCODE , ID );
// Yes zipcode is unfortunately mandatory
````

Throws ````Exceptions\ParcelNotFoundException```` if not found

Returns ````$shop```` is a ````Entity\Parcelshop```` object

### Get parcelshops from a zipcode

````php
<?php
require 'vendor/autoload.php';

use Lsv\PdDk\ParcelShop;

$p = new ParcelShop( CONSUMER_ID );
$shops = $p->getParcelshopsFromZipcode( ZIPCODE );
````

Throws ````Exceptions\NoParcelsFoundInZipcodeException```` if none found

Returns ````$shops```` is a array of ````Entity\Parcelshop````

### Get parcelshops near address
 
````php
<?php
require 'vendor/autoload.php';

use Lsv\PdDk\ParcelShop;

$p = new ParcelShop( CONSUMER_ID );
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

use Lsv\PdDk\ParcelShop;
use GuzzleHttp\Subscriber\Retry\RetrySubscriber;

$retry = new RetrySubscriber([
    'filter' => RetrySubscriber::createStatusFilter()
]);

$client = new GuzzleHttp\Client();
$client->getEmitter()->attach($retry);

$p = new ParcelShop($client);
$shops = $p->getParcelshopsNearAddress( STREET , ZIPCODE, 20 );
````