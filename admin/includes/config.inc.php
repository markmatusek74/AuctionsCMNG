<?php

define("DB_HOST","DB2.ludington.com");
define("DB_DATABASE","wwwldn_phpauctionpro_beta2017");
define("DB_USER","wwwldn_ldndb");
define("DB_PASSWORD","ldn01pass2");


$dbConn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
$dbConn->select_db(DB_DATABASE);
if($dbConn->errno)
{
    printf("Unable to connect to database:</br /> %s", $dbConn->error);
    exit();
}

define("BASE_URL","http://67.227.134.122/~todayswheels/ldn_new_site/");
if (!defined('IMAGE_BASE_URL')) { define("IMAGE_BASE_URL","http://67.227.134.122/~todayswheels/ldn_new_site/images/uploaded/auctions/"); }
if (!defined('IMG_UPLOAD_FOLDER')) { define("IMG_UPLOAD_FOLDER","/home/todayswheels/public_html/ldn_new_site/images/uploaded/"); }
if (!defined('BASE_FOLDER')) { define("BASE_FOLDER","/home/todayswheels/public_html/ldn_new_site/"); }
$auction_types = array (
    1 => "Standard auction",
    2 => "Dutch auction"
);
$countries = array("",
    "United States",
);
?>