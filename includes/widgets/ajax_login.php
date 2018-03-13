<?php
session_start();
$basePath =  str_replace("ajax_login.php","",$_SERVER["SCRIPT_FILENAME"]);

require_once($basePath . "..//classes/users.class.php");

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`

/* Validate the form on the server side */
if (empty($_POST['username'])) { //Name cannot be empty
    $errors['username'] = 'Username cannot be blank';
}
if (empty($_POST['password'])) { //Name cannot be empty
    $errors['password'] = 'Password cannot be blank';
}

if (!empty($errors)) { //If errors in validation
 //   $form_data['success'] = false;
//    $form_data['errors']  = $errors;
}


else {
    $lUser = new users();
 //If not, process the form, and return true on success
    $lUser->Username = $_POST["username"];
    $results = $lUser->getUsernamePasswordFromDB();
    //print_r($results);
    $form_data['success'] = true;
    $form_data['posted'] = 'Login successful';
    if (count( $results ) > 0)
    {
        $_SESSION["user_id"] = $results[0]["id"];
        for( $i = 0; $i < count( $results ); $i++ )
        {
            //print "username: " . $results[$i]['username'] . "<br />";
            //print "password: " . $results[$i]['password'] . "<br />";
            //print "submitted password: " . md5($_POST['password']) . "<br />";
            if (empty($results[$i]['username']))
            {
               $errors['un_check'] = 'Username not found';
            }
            if ($results[$i]['password'] != md5($_POST['password']))
            {
                $errors['pwd_check'] = 'Password is incorrect';
            }

        }
    }
    else
    {
        $errors['un_check'] = 'Username not found';
    }

}
if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
}

if (!empty($_POST['rememberMe']))
{
    $cookiehash = md5(sha1($_POST["username"] . $_SERVER['REMOTE_ADDR']));
    setcookie("username",$cookiehash,time()+3600*24*365,'/','.todayswheels.com');
    $form_data['ldn_cookie'] = $cookiehash;
}
    $_SESSION["username"] = $_POST["username"];
//print_r($form_data);

//Return the data back to form.php
echo json_encode($form_data);

?>
