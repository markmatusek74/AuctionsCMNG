<?php
require_once("config.inc.php");
require_once($basePath . "/includes/classes/users.class.php");
$users = new users();
require_once($basePath . "/includes/classes/auctions.class.php");
$auc = new auctions();
require_once($basePath . "/includes/classes/categories.class.php");
$cat = new categories();

require_once("classes/help.class.php");
$hlp = new help();
$arrHelpTopics = $hlp->getHelpTopics();
$arrCats = $cat->getCategoryList();

$pageName =  basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Auctions Site | Bootstrap Template</title>

    <!-- Bootstrap core CSS -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link href="css/auctions.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">

<body>

