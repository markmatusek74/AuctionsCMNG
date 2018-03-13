
<div id="divLoginForm" class="row">
    <div class="col-sm-12">

        <form class="form-signin" id="login_form" method="POST">

            <div class="row form-group">
                <div class="col-sm-11 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="lgnUsername" placeholder="Username" class="form-control" autofocus="" type="text">
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-11 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input name="lgnPassword" placeholder="Password" class="form-control" autofocus="" type="password">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-11">
                    <a data-toggle="modal" data-target="#forgotPWModal">Forgot your password?</a>

                </div>
            </div>
            <div class="row checkbox">
                <div class="col-sm-11">
                <label>
                    <input name="frmRememberMe" type="checkbox" value="remember-me"> Remember me
                </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="loginStatus" class="throw_error text-danger small" style="display: none;"></div>

                <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
                </div>
            </div>
        </form>
        <br clear="all" />
    </div>
</div>

<div id="divLoggedIn" style="display: none;" class="row">
    <div class="col-sm-12">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center">User Info</h3>
            </div>
            <div class="panel-body">
                <?php
                if (isset($_SESSION["username"]))
                {
                 //   print "<li><a href=\"" . BASE_URL. "/edit_profile.php?id=" . $_SESSION["user_id"]  . "\" >Edit Profile <span class=\"glyphicon glyphicon-cog pull-right\" style=\"margin-top: -18px;\"></span></a></li>";

                    echo "<a href=\"" . BASE_URL. "/edit_profile.php?id=" . $_SESSION["user_id"]  . "\">" . $_SESSION["username"] . "</a><span class=\"glyphicon glyphicon-cog pull-right\"></span> <br />";
                }
                ?>
                <div class="divider"></div>
                <a href="#">Item Watch </a><span class="glyphicon glyphicon-time pull-right"></span><br />

                <?php
                    echo "<a href=\"" . BASE_URL. "/my_bids.php?id=" . "123234534"  . "\">My Bids</a><span class=\"glyphicon glyphicon-bookmark pull-right\"></span><br />";
                ?>
                <a href="#">View Feedback</a><span class="glyphicon glyphicon-comment pull-right"></span><br />
                <a id="lnkSignOut" href="#">Sign Out</a><span class="glyphicon glyphicon-log-out pull-right"></span><br />

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="forgotPWModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="frmforgotPassword" action="#" method="POST">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Forgot Password</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>If you have forgotten your password you can reset it here.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input name="forgotEmail" id="forgotEmail" type="email" class="form-control" placeholder="E-mail Address"  required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <div class="text-center">
                        <div id="forgotPwdStatus" class="throw_error text-danger small" style="display: none;"></div>

                        <input class="btn btn-success" type="submit" value="Send My Password" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_SESSION["username"]))
{
    ?>
    <script type="text/javascript">
        $("#divLoginForm").hide();
        $("#divLoggedIn").show();
    </script>
<?php
}
?>
<script type="text/javascript">

    $("#frmforgotPassword").submit(function(e) {
        var postForm = { //Fetch form data
            'email'     : $('#forgotEmail').val() //Store name fields value
        };

        e.preventDefault(); //Prevent the default submit

//do some verification
        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>includes/widgets/ajax_forgotPassword.php',
            data: postForm,
            dataType: 'json',
            success   : function(data) {
                if (!data.success) { //If fails
                    var failMsgs = "";
                    if (data.errors.email) { //Returned if any error from process.php
                        failMsgs = data.errors.email + "<br />"; //Throw relevant error
                    }
                    if (data.errors.un_check) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.un_check + "<br />"; //Throw relevant error
                    }

                    if (data.errors.email_check) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.email_check + "<br />"; //Throw relevant error
                    }
                    $('#forgotPwdStatus').fadeIn(1000).html(failMsgs); //Throw relevant error

                    //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                }
                else {
                    $('#forgotPwdStatus').show().html(data.posted); //Throw relevant error
                  //  location.reload();
                }
            }
        });

    });

$('#login_form').submit(function(e){

    var postForm = { //Fetch form data
        'username'     : $('input[name=lgnUsername]').val(), //Store name fields value
        'password'     : $('input[name=lgnPassword]').val(), //Store name fields value
        'rememberMe'     : $('input[name=frmRememberMe]').val() //Store name fields value
    };
//do some verification
    $.ajax({
    type: 'POST',
    url: '<?php echo BASE_URL;?>/includes/widgets/ajax_login.php',
    data: postForm,
    dataType: 'json',
        success   : function(data) {
            if (!data.success) { //If fails
                var failMsgs = "";
                if (data.errors.username) { //Returned if any error from process.php
                    failMsgs = data.errors.username + "<br />"; //Throw relevant error
                }
                if (data.errors.password) { //Returned if any error from process.php
                    failMsgs = failMsgs +data.errors.password + "<br />"; //Throw relevant error
                }
                if (data.errors.un_check) { //Returned if any error from process.php
                    failMsgs = failMsgs +data.errors.un_check + "<br />"; //Throw relevant error
                }
                if (data.errors.pwd_check) { //Returned if any error from process.php
                    failMsgs = failMsgs +data.errors.pwd_check + "<br />"; //Throw relevant error
                }
                $('.throw_error').fadeIn(1000).html(failMsgs); //Throw relevant error

             //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
            }
            else {
                location.reload();
            }
        }
    });
    e.preventDefault(); //Prevent the default submit
});
</script>
