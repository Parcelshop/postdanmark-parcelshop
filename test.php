<?php
require 'vendor/autoload.php';

$shopper = new \Lsv\PdDk\ParcelShop('726c484d-5dde-4dc5-9646-58176d2ab823', 'DK');
$shops = $shopper->getParcelshopsFromZipcode(4100);

var_dump($shops);