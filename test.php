<?php
require 'vendor/autoload.php';

$shopper = new \Lsv\PdDk\ParcelShop('d2f482ad99a9e74afad04dd3571bd6cf', 'DK');
$shops = $shopper->getParcelshopsFromZipcode(4100);

var_dump($shops);
