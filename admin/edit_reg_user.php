<?php
session_start();
$currSection = "auctions";

require_once("includes/header.php");
require_once("includes/config.inc.php");
require_once("../includes/classes/users.class.php");
$userID = $_GET["id"];
$usr = new users();
$usr->ID = $userID;
$usr->getUserInfoByID();

if(isset($_SESSION['user']))   // Checking whether the session is already there or not if
    // true then header redirect it to the home page directly
{

?>
    <style type="text/css">
        form div.form-group { margin: 20px 0 !important; display: block;}
    </style>

    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header text-center">Edit Registered User</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
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
                                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-danger">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
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

    <script type="text/javascript" src="<?php echo BASE_URL;?>/js/moment.js" charset="UTF-8"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $('#startDate,#endDate').datetimepicker();
    </script>
<?php
}
else
{
    header("Location:index.php");
}

?>