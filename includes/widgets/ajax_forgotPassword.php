<?php
session_start();
$basePath =  str_replace("ajax_forgotPassword.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../config.inc.php");

require_once($basePath . "..//classes/users.class.php");

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`

/* Validate the form on the server side */
if (empty($_POST['email'])) { //Name cannot be empty
    $errors['email'] = 'Email Address cannot be blank';
}

if (!empty($errors)) { //If errors in validation
 //   $form_data['success'] = false;
//    $form_data['errors']  = $errors;
}


else {
    $lUser = new users();
 //If not, process the form, and return true on success
    $lUser->Email = $_POST["email"];
    $results = $lUser->checkForUsernameByEmail();

    //print_r($results);
    if (count( $results ) > 0)
    {
        $form_data['success'] = true;
        $form_data['posted'] = 'Password sent to <strong>' . $_POST["email"] . '</strong>';
     //   $_SESSION["user_id"] = $results[0]["id"];
        for( $i = 0; $i < count( $results ); $i++ )
        {
            //print "username: " . $results[$i]['username'] . "<br />";
            //print "password: " . $results[$i]['password'] . "<br />";
            //print "submitted password: " . md5($_POST['password']) . "<br />";
            if (empty($results[$i]['username']))
            {
               $errors['un_check'] = 'Username not found';
            }
            else
            {
                $username = $results[$i]['username'];
                $id = $results[$i]['id'];
                $lUser->ID = $id;

            }
            if (empty($results[$i]['email']))
            {
                $errors['email_check'] = 'Email address is not found';
            }

        }

    }
    else
    {
        $errors['email_check'] = 'Email address is not found';
    }

}
if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
}
else
{

    $NEWPASSWD = substr(uniqid(md5(time())),0,6);


    $lUser->Password = md5($NEWPASSWD);
    $lUser->updatePasswordForUser();

    $to 		= $_POST["email"];
    $from 	= "From:" . SITENAME ." <" . ADMIN_EMAIL . ">\nReplyTo:" . ADMIN_EMAIL . "\n";
    $subject	= "Your new password";
    $message = "
        Hi $username,

        As you requested, we have created a new password for your account.

        It is: $NEWPASSWD

        Use it to login to " . SITENAME . " and remember to change it to the one you prefer.
";
    mail($to,$subject,$message,$from);

}
//Return the data back to form.php
echo json_encode($form_data);

?>