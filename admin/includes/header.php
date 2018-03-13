<?php
$pageName =  basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #loginFail { display: none;}
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery.ui.widget.js"></script>
    <script src="js/jquery.fileupload.js"></script>

    <link href="http://67.227.134.122/~todayswheels/ldn_new_site/css/datepicker.css" rel="stylesheet">

    <base href="http://67.227.134.122/~todayswheels/ldn_new_site/admin/">
    <style type="text/css">
        .spacer10 { height: 10px; display: block; }
    </style>
</head>
<body>

<div class="container theme-showcase" role="main">
    <?php
    if (($pageName != "index.php") && ($pageName != "logouy.php"))
    {
   //     print "current section is: " . $currSection . "<br />";
    ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="home.php">Auctions Admin</a>
            </div>
            <ul class="nav navbar-nav">
                <li<?php if ($currSection == "home") print " class=\"active\""; ?>><a href="home.php">Home</a></li>
                <li<?php if ($currSection == "auctions") print " class=\"active\""; ?>>
                    <a href="auctions.php">Auctions</a>
                </li>
                <li class="dropdown<?php if (($currSection == "news") || ($currSection == "help_topics"))  print " active"; ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Content
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="news.php">News</a></li>
                        <li><a href="help_topics.php">Help Topics</a></li>
                    </ul>
                </li>
                <li class="dropdown<?php if (($currSection == "users") || ($currSection == "admin_users"))  print " active"; ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="reg_users.php">Users</a></li>
                        <li><a href="admin_users.php">Admin Users</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Fees
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sign Up Fee</a></li>
                        <li><a href="#">Buyers Final Value Fee</a></li>
                        <li><a href="#">Sellers Setup Fee</a></li>
                        <li><a href="#">Seller's Final Value Fee</a></li>
                        <li><a href="#">Picture Gallery Fee</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">General Settings</a></li>
                        <li><a href="#">Currency Symbol</a></li>
                        <li><a href="#">Fonts and Colors</a></li>
                        <li><a href="#">Time Settings</a></li>
                        <li><a href="#">Batch Procedure Settings</a></li>
                        <li><a href="#">Dates Format</a></li>
                        <li><a href="#">PayPal E-mail Address</a></li>
                        <li><a href="#">Picture Gallery</a></li>
                        <li><a href="#">Error Handling</a></li>
                        <li><a href="#">SSL Support</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.container-fluid -->
    </nav>
<?php
    }
?>