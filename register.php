<?php
session_start();

$basePath =  str_replace("register.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$blnDebug = false;
$formSubmitted = false;
$regSuccess = false;
require_once($basePath . "/includes/classes/users.class.php");
$usr = new users();

if (isset($_GET["a"]))
{
if ($_GET["a"] == md5("AcceptRules"))
{
    $_SESSION["AcceptRule"] = true;

}
elseif ((isset($_SESSION["AcceptRule"])) && ($_GET["a"] != md5("AcceptRules")))
{
$_SESSION["AcceptRule"] = false;

}
}

require_once($basePath . "includes/header.php");

if ($_POST)
{
    if ((isset($_POST["register"])) && ($_POST["register"] == "Register"))
    {
        $arrPhoneFind = array("(",")","-");

        $id = md5($_POST["username"]);
        $usr->ID = $id;
        $usr->Name = $_POST["fullName"];
        $usr->Username = $_POST["username"];
        $usr->Password = md5($_POST["password"]);
        $usr->Email = $_POST["email"];
        $usr->Birthday = $_POST["birthdate"];
        $usr->Address = $_POST["street_address"];
        $usr->City = $_POST["city"];
        $usr->State = $_POST["state"];
        $usr->Zip = $_POST["zip"];
        $usr->Country = $_POST["country"];
        $usr->Phone = preg_replace("/[^0-9]/", "", $_POST["phone"]);
        $regSuccess = $usr->createNewUser();
        if ($blnDebug)
        {
            print "<h4>Form variables</h4>";
            print "Name: " . $usr->Name . "<br />";
            print "Username: " . $usr->Username . "<br />";
            print "Password: " . $usr->Password . "<br />";
            print "Confirm Password: " . $_POST["confirm_password"] . "<br />";
            print "Email: " . $usr->Email . "<br />";
            print "Birthday: " . $usr->Birthday . "<br />";
            print "Street Address: " . $usr->Address . "<br />";
            print "City: " . $usr->City . "<br />";
            print "State: " . $usr->State . "<br />";
            print "Country: " . $usr->Country . "<br />";
            print "Zip: " . $usr->Zip . "<br />";
            print "Phone: " . $usr->Phone . "<br />";
        }
        if ($regSuccess)
        {
            $formSubmitted = true;
        }
    }
//    print_r($_POST);
}

?>
<style type="text/css">
    form div.form-group { margin: 20px 0 !important; display: block;}
</style>

<link rel="stylesheet" type="text/css" media="screen" href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css" />
<br clear="all" />
<br clear="all" />
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header text-center">Register</h1>
            </div>
        </div>

        <?php
        if (($_SESSION["AcceptRule"]  == true) && ($formSubmitted == false))
        {
        ?>
        <div id="regForm" class="row">
            <div class="col-sm-12">

                <div id="success_message"></div>
            <form id="register_form" method="post" action="#" data-toggle="validator" role="form">

                    <div class="row form-group">
                        <label for="fullName" class="col-sm-3 control-label text-right">Full Name</label>
                        <div class="col-sm-9 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="fullName" placeholder="Full Name" class="form-control" autofocus="" type="text" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="username" class="col-sm-3 control-label text-right">Username</label>
                        <div class="col-sm-9 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="username" placeholder="Username" class="form-control" autofocus="" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="password" class="col-sm-3 control-label text-right">Password</label>
                        <div class="col-sm-9 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input name="password" placeholder="Password" class="form-control" autofocus="" type="password">
                            </div>
                        </div>
                    </div>
                <div class="row form-group">
                    <label for="confirm_password" class="col-sm-3 control-label text-right">Confirm Password</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input name="confirm_password" placeholder="Password" class="form-control" autofocus="" type="password" data-match="#password" data-match-error="Whoops, these don't match" required>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="email" class="col-sm-3 control-label text-right">Email Address</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input name="email" placeholder="E-Mail Address" class="form-control" autofocus="" type="email" data-error="Please enter a email address" required>
                        </div>
                        <div class="help-block with-errors"></div>

                    </div>
                </div>
                <div class="row form-group">
                    <label for="birthdate" class="col-sm-3 control-label text-right">Birthdate</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input id="birthDate" name="birthdate" placeholder="Date of Birth" class="form-control" autofocus="" type="text">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="street_address" class="col-sm-3 control-label text-right">Street Address</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="street_address" placeholder="Street Address" class="form-control" autofocus="" type="text">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="city" class="col-sm-3 control-label text-right">City</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="city" placeholder="City" class="form-control" autofocus="" type="text">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="state" class="col-sm-3 control-label text-right">State</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="state" placeholder="State" class="form-control" autofocus="" type="text">
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="country" class="col-sm-3 control-label text-right">Country</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <select name="country" class="form-control required">
                                <option value="1">United States</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="zip" class="col-sm-3 control-label text-right">Zip</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="zip" placeholder="Zip" class="form-control" autofocus="" type="text">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="phone" class="col-sm-3 control-label text-right">Phone #</label>
                    <div class="col-sm-9 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <input name="phone" placeholder="(123)456-7890" class="form-control" autofocus="" type="tel">
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <strong>By clicking below you agree to the terms of this website and that you agree to be bound by your winning bids.</strong>
                        </div>
                    </div>
                    <div class="form-group">
                        &nbsp;
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" name="register" value="Register" class="btn btn-success" />
                        <input type="reset" name="resetSearch" value="Reset" class="btn btn-danger" />
                    </div>

                </form>
                <?php
                }
                else if (($_SESSION["AcceptRule"]  == true) && ($formSubmitted == true))

                {
                    print "Thank you for registering.  You may now bid on auctions.";
                }
                else
                {
                    print "You must accept the rules prior to registering.  <a href=\"register_rules.php\">Click here</a> to read the rules.";

                }
                ?>
            </div>
        </div>
    </div>

