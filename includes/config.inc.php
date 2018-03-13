<?php
define("DB_HOST","DB2.ludington.com");
define("DB_DATABASE","wwwldn_phpauctionpro_beta2017");
define("DB_USER","wwwldn_ldndb");
define("DB_PASSWORD","ldn01pass2");

define("BASE_FOLDER","/home/todayswheels/public_html/ldn_new_site/");
require_once(BASE_FOLDER . "includes/classes/settings.class.php");
$settings = new settings();
$settings->getSiteSettings();


$dbConn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
$dbConn->select_db(DB_DATABASE);
if($dbConn->errno)
{
    printf("Unable to connect to database:</br /> %s", $dbConn->error);
    exit();
}

if (!defined('SEARCH_RESULTS_COUNT')) { define("SEARCH_RESULTS_COUNT",25); }
if (!defined('CATEGORY_RESULTS_COUNT')) { define("CATEGORY_RESULTS_COUNT",25); }
if (!defined('BASE_URL')) { define("BASE_URL","http://67.227.134.122/~todayswheels/ldn_new_site/"); }
if (!defined('IMAGE_BASE_URL')) { define("IMAGE_BASE_URL","http://67.227.134.122/~todayswheels/ldn_new_site/images/uploaded/auctions/"); }
if (!defined('SITENAME')) { define("SITENAME",$settings->SiteName); }
if (!defined('ADMIN_EMAIL')) { define("ADMIN_EMAIL",$settings->AdminEmail); }



?>