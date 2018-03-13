<?php
session_start();

require_once("includes/classes/login.class.php");
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 2/27/17
 * Time: 11:12 PM
 * To change this template use File | Settings | File Templates.
 */

if(isset($_SESSION['user']))   // Checking whether the session is already there or not if
    // true then header redirect it to the home page directly
{
    header("Location:home.php");
}

$loginOK = true;


if ($_POST)
{
    $login = new AdminLogin();

    $userID = $login->checkAdminUserLoginInfo($_POST["username"],md5($_POST["password"]));

    if ($userID ==  0)
    {
        $loginOK = false;

    }
    else
    {
        $_SESSION['user']= $_POST["username"];
        header("Location:home.php");
    }
}
require_once("includes/header.php");
?>

<form method="post">

    <div class="row">
        <label for="username">Username</label>
    </div>
    <div class="row">
        <input type="text" maxlength="50" name="username" id="username" />
    </div>
    <div class="row">
        <label for="username">Password</label>
    </div>
    <div class="row">
        <input type="password" maxlength="100" name="password" id="password" />
    </div>
    <div class="row">&nbsp;</div>
    <div class="row">
        <div id="loginFail" class="alert alert-danger" role="alert" style="display: none;">Invalid Username / Password combo.  Please try again.</div>
    </div>
    <div class="row">
        <input type="submit" name="Login" value="Login" class="btn btn-sm btn-success" />
    </div>
</form>
<?php
//echo "md5 hash: " . md5("d916m1138#");
if ($loginOK)
{

    ?>
    <script type="text/javascript">
        $("#loginFail").css("display","none");
        $("#loginFail").hide();

    </script>
<?php
}
else
{
    ?>

    <script type="text/javascript">
        $("#loginFail").css("display","block");
        $("#loginFail").show();

    </script>
<?php
}
require_once("includes/footer.php");
?>
