<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location:index.php");
    exit();
}
$basePath =  str_replace("edit_profile.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$blnDebug = false;
$formSubmitted = false;
$regSuccess = false;
require_once($basePath . "/includes/classes/users.class.php");
$usr = new users();
$usr->ID = $_GET["id"];
$usr->getUserInfoByID();
$debug = false;

if ($_POST && ($_POST["register"] == "Update Info"))
{
    $dbBirthDate = new DateTime($_POST["birthDate"]);
    $usr->Name = $_POST["fullName"];
    $usr->Username = $_POST["username"];
    $usr->Email = $_POST["email"];
    $usr->Birthday = date_format($dbBirthDate, 'Ymd') ;
    $usr->Address = $_POST["street_address"];
    $usr->City = $_POST["city"];
    $usr->State = $_POST["state"];
    $usr->Country = $_POST["country"];
    $usr->Zip = $_POST["zip"];
    $usr->Phone = preg_replace("/[^0-9]/", "", $_POST["phone"]);

    if ($debug)
    {
        /*
         *     [fullName] => Mark Matusek
    [username] => mmatusek1388a
    [email] => markmatusek74@gmail.com
    [birthDate] => 05/17/1974
    [street_address] => 3905 Crown Ridge Ct
    [city] => College Station
    [state] => TX
    [country] => 1
    [zip] => 77845
    [phone] => (979) 571-5353
    [register] => Update Info
         */
        print "<table>";
        print "<tr><td>user id </td><td>" . $usr->ID  . "</td></tr>";
        print "<tr><td>full Name</td><td>" . $usr->Name . "</td></tr>";
        print "<tr><td>username</td><td>" . $usr->Username . "</td></tr>";
        print "<tr><td>email</td><td>" . $usr->Email . "</td></tr>";
        print "<tr><td>birthdate</td><td>" . $usr->Birthday . "</td></tr>";
        print "<tr><td>street address</td><td>" . $usr->Address . "</td></tr>";
        print "<tr><td>city</td><td>" . $usr->City . "</td></tr>";
        print "<tr><td>state</td><td>" . $usr->State . "</td></tr>";
        print "<tr><td>country</td><td>" . $usr->Country . "</td></tr>";
        print "<tr><td>zip</td><td>" . $usr->Zip . "</td></tr>";
        print "<tr><td>phone</td><td>" . $usr->Phone . "</td></tr>";
        print "</table>";
    }

    $dbStatus = $usr->UpdateUserInfo();
    if ($dbStatus == true)
    {
        header("Location:index.php");
        exit();
        //        print "status is: <b>" . $dbStatus . "</b><br />";

    }
}
require_once($basePath . "includes/header.php");

?>
<style type="text/css">
    form div.form-group { margin: 20px 0 !important; display: block;}
</style>

<link rel="stylesheet" type="text/css" media="screen" href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css" />
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header text-center">Edit Profile</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a class="chgPassword btn btn-success" data-toggle="modal" data-id="<?php echo $usr->ID;?>" data-username="<?php echo $usr->Username;?>" title="" href="#modalChangePassword">Change Password&nbsp;<span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                </div>
                <div id="regForm" class="row">
                    <div class="col-sm-12">

                        <div id="success_message"></div>
                        <form id="register_form" method="post" action="#" data-toggle="validator" role="form">

                        <div class="row form-group">
                            <label for="fullName" class="col-sm-3 control-label text-right">Full Name</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input name="fullName" placeholder="Full Name" class="form-control" autofocus="" type="text" required value="<?php print $usr->Name; ?>" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="username" class="col-sm-3 control-label text-right">Username</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input name="username" placeholder="Username" class="form-control" autofocus="" type="text" value="<?php print $usr->Username; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="email" class="col-sm-3 control-label text-right">Email Address</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input name="email" placeholder="E-Mail Address" class="form-control" autofocus="" type="email" data-error="Please enter a email address" required  value="<?php print $usr->Email; ?>"  />
                                </div>
                                <div class="help-block with-errors"></div>

                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="birthdate" class="col-sm-3 control-label text-right">Birthdate</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input id="birthDate" name="birthDate" placeholder="Date of Birth" class="form-control" autofocus="" type="text" value="<?php print substr($usr->Birthday,4,2) . "/" . substr($usr->Birthday,6,2) . "/" .  substr($usr->Birthday,0,4); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="street_address" class="col-sm-3 control-label text-right">Street Address</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input name="street_address" placeholder="Street Address" class="form-control" autofocus="" type="text"  value="<?php print $usr->Address; ?>"  />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="city" class="col-sm-3 control-label text-right">City</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input name="city" placeholder="City" class="form-control" autofocus="" type="text"  value="<?php print $usr->City; ?>"  />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="state" class="col-sm-3 control-label text-right">State</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input name="state" placeholder="State" class="form-control" autofocus="" type="text"  value="<?php print $usr->State; ?>"  />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="country" class="col-sm-3 control-label text-right">Country</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <select name="country" class="form-control required">
                                        <option value="1" <?php if ($usr->Country == "1"){ echo " selected=\"selected\" "; } ?>>United States</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="zip" class="col-sm-3 control-label text-right">Zip</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                    <input name="zip" placeholder="Zip" class="form-control" autofocus="" type="text"  value="<?php print $usr->Zip; ?>"  />
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="phone" class="col-sm-3 control-label text-right">Phone #</label>
                            <div class="col-sm-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                    <input name="phone" placeholder="(123)456-7890" class="form-control" autofocus="" type="tel"  value="<?php print "(". substr($usr->Phone,0,3) . ") " . substr($usr->Phone,3,3) . "-" .  substr($usr->Phone,6,4) ; ?>"  />
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
                            <input type="submit" name="register" value="Update Info" class="btn btn-success" />
                            <input type="reset" name="resetSearch" value="Reset" class="btn btn-danger" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
            <?php
            require_once("includes/right_rail.php");

            ?>
    </div>

<div class="modal fade" id="modalChangePassword" role="dialog">
    <form name="mdlPasswordForm" id="mdlPasswordForm" data-async data-target="#modalChangePassword" method="post" >
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title ">Change Password</h4>
            </div>
            <div class="modal-body">
                    <input type="hidden" id="mwUserID" name="mwUserID" value="<?php echo $usr->ID; ?>" />
                    <div class="row form-group">
                        <label for="phone" class="col-sm-3 control-label text-right">Password</label>
                        <div class="col-sm-9 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input name="mwPassword" placeholder="Enter Password" class="form-control" autofocus="" type="password"  />
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="phone" class="col-sm-3 control-label text-right">Confirm</label>
                        <div class="col-sm-9 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input name="mwConfPassword" placeholder="Enter Password" class="form-control" autofocus="" type="password"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=col-sm-12 text-center">
                        <div class="throw_error text-danger small" style="display: none;"></div>
                    </div>
                    </div>

            </div>
            <div class="modal-footer bg-white ">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </form>
</div>

<script type="text/javascript" src="<?php echo BASE_URL;?>/js/bootstrap-datepicker.js" charset="UTF-8"></script>
<script type="text/javascript">

    $('#birthDate').datepicker();
    $('#mdlPasswordForm').submit(function(e){
        var postForm = { //Fetch form data
            'id'     : $('input[name=mwUserID]').val(), //Store name fields value
            'password'     : $('input[name=mwPassword]').val(), //Store name fields value
            'confirmPassword'     : $('input[name=mwConfPassword]').val() //Store name fields value
        };
//do some verification
        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>/includes/widgets/updatePassword.php',
            data: postForm,
            dataType: 'json',
            success   : function(data) {
                if (!data.success) { //If fails
                    var failMsgs = "";
                    if (data.errors.password) { //Returned if any error from process.php
                        failMsgs = data.errors.password + "<br />"; //Throw relevant error
                    }
                    if (data.errors.confirmPassword) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.confirmPassword + "<br />"; //Throw relevant error
                    }
                    if (data.errors.pwd_check) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.pwd_check + "<br />"; //Throw relevant error
                    }
                    if (data.errors.pwd_length) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.pwd_length + "<br />"; //Throw relevant error
                    }


                    $('.throw_error').fadeIn(1000).html(failMsgs); //Throw relevant error

                    //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                }
                else {
                    $('.throw_error').hide(); //Throw relevant error
                    //location.reload();
                }
            }
        });
        e.preventDefault(); //Prevent the default submit
    });
</script>
<?php require_once($basePath . "includes/footer.php"); ?>