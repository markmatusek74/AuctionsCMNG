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
    <style type="text/css">
        #branding .row { display: table; width: 100%;}
        #branding .row > div { display: table-cell;}
        #siteList { display: table-cell; vertical-align: bottom; }

        #bs-example-navbar-collapse-1,
        #bs-example-navbar-collapse-1.collapse.navbar-collapse.navbar-inverse.bg-inverse ul.nav.navbar-nav li.nav-item a.nav-link,
        #bs-example-navbar-collapse-1.collapse.navbar-collapse.navbar-inverse.bg-inverse ul.nav.navbar-nav li.nav-item.dropdown a.dropdown-toggle
        { color: white !important; background-color: #336699 !important; font-weight: 600;}
    </style>
<body>

<div id="branding" class="container">
    <div  class="row">
        <div class="col-sm-6">
            <a href="<?php echo BASE_URL; ?>">
                <img class="img img-responsive center-block" src="<?php BASE_URL;?>images/Spring-Fever-Auction.png" />
            </a>
        </div>
        <div id="siteList" class="col-sm-6 text-right align-bottom-text" style="position: relative; top: 70px; ">
            <a href="http://www.ludingtondailynews.com" target="_blank">Ludington Daily News</a> <span style="color: #336699;">&#9679;</span>
            <a href="http://www.oceanaheraldjournal.com/" target="_blank">Oceana's Herald Journal</a> <span style="color: #336699;">&#9679;</span>
            <a href="http://www.whitelakebeacon.com" target="_blank">White Lake Beacon</a>
        </div>
    </div>
</div>


<br clear="all" />

    <div class="row">
        <div class="col-sm-12">
            <div class="collapse navbar-collapse navbar-inverse  bg-inverse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <?php
        ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories</a>

                        <ul class="dropdown-menu">
                            <?php
                            //print_r($arrCats);
                            foreach ($arrCats as $k) {
                                print "<li><a href=\"" . BASE_URL. "categories.php?id=" . $k["CategoryID"]  . "\" >" . $k["CategoryName"] . ' ('. $k["CategoryCount"] . ')</a></li>';

                            }
                            ?>
                        </ul>
                    </li>

                    </ul>
                    <ul class="nav navbar-nav pull-right">
                    <li class="nav-item dropdown">
                        <?php
                        if (isset($_SESSION["username"]))
                        {
                            print "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . $_SESSION["username"] ." <span class=\"glyphicon glyphicon-user pull-right\"></span></a>";
                        }
                        else
                        {
                            print "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Login</a>";
                        }
                        if (isset($_SESSION["username"]))
                        {
                        ?>
                        <ul id="mnuLoggedIn"  class="dropdown-menu">
                            <?php

                            print "<li><a href=\"" . BASE_URL. "edit_profile.php?id=" . $_SESSION["user_id"]  . "\" >Edit Profile <span class=\"glyphicon glyphicon-cog pull-right\" style=\"margin-top: -18px;\"></span></a></li>";
                            ?>
                            <li class="divider"></li>
                            <li><a href="#">Item Watch <span class="glyphicon glyphicon-time pull-right" style="margin-top: -18px;"></span></a></li>
                            <li class="divider"></li>
                            <?php
                                echo "<li><a href=\"" . BASE_URL. "my_bids.php?id=" .  $_SESSION["user_id"]  . "\" >My Bids<span class=\"glyphicon glyphicon-bookmark pull-right\" style=\"margin-top: -18px;\"></span></a></li>";
                            ?>

                            <li class="divider"></li>
                            <li><a href="#">View Feedback <span class="glyphicon glyphicon-comment pull-right" style="margin-top: -18px;"></span></a></li>
                            <li class="divider"></li>
                            <li><a id="mnuSignout" href="#">Sign Out <span class="glyphicon glyphicon-log-out pull-right" style="margin-top: -18px;"></span></a></li>
                        </ul>
                        <?php
                            }
                        else
                        {
                        ?>
                        <ul id="mnuNotLoggedIn" class="dropdown-menu" style="width: 200px;">
                            <li class="col-sm-12">
                                <form class="form-signin" id="mnulogin_form" method="POST">

                                    <div class="row form-group">
                                        <div class="col-sm-12 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input name="mnuUsername" placeholder="Username" class="form-control" autofocus="" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-12 inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input name="mnuPassword" placeholder="Password" class="form-control" autofocus="" type="password">
                                            </div>
                                        </div>
                                    </div>

                                    <!--
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <a data-toggle="modal" data-target="#forgotPWModal">Forgot your password?</a>


                                        </div>
                                    </div>
                                    <div class="row checkbox">
                                        <div class="col-sm-11">
                                            <label>
                                                <input type="checkbox" value="remember-me"> Remember me
                                            </label>
                                        </div>
                                    </div>
                                    -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="loginStatus" class="throw_error text-danger small" style="display: none;"></div>

                                            <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
                                        </div>
                                    </div>
                                </form>
                                <br clear="all" />

                            </li>
                        </ul>
                        <?php
                        }
                        ?>
                    </li>
                        <?php
                        if (!isset($_SESSION["username"]))
                        {
                            print "<li class=\"nav-item\">";
                            print "<div class=\"nav-link\" style='margin-top: 14px;'>&nbsp;|&nbsp;</div>";
                            print "</li>";
                            print "<li class=\"nav-item\">";
                            print "<a class=\"nav-link\" href=\"register_rules.php\">Register Now</a>";
                            print "</li>";
                        }
                        ?>


                </ul>
                <ul class="nav navbar-nav pull-right col-sm-4">
                    <form class="form-inline text-right" style=" margin-top: 8px;" action="search.php">

                    <li class="nav-item">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="searchTerm" id="searchTerm">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>

                    </li>
                    </form>
                </ul>

            </div>
        </div>
    </div>
<?php
require_once($basePath . "/includes/widgets/submit_feedback.php");

?>
