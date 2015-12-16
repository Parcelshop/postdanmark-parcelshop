<?php
require 'vendor/autoload.php';

$shopper = new \Lsv\PdDk\ParcelShop('', 'DK');
$shops = $shopper->getParcelshopsFromZipcode(4100);

var_dump($shops);
