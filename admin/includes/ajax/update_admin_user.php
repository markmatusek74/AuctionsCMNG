<?php
$basePath =  str_replace("update_admin_user.php","",$_SERVER["SCRIPT_FILENAME"]);

require_once($basePath . "../../../includes/classes/adminUsers.class.php");
$user = new adminUsers();
$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$user->ID = $_POST['id'];
$user->Username = $_POST["username"];
$user->Password = md5($_POST["password"]);


if (!empty($_POST['username'])) { //Name cannot be empty
   // $form_data['helpTopic'] = $_POST["topic"];
}

/* Validate the form on the server side */
if (empty($_POST['password'])) { //Name cannot be empty
    $errors['password'] = 'Password can not be blank.';
}

if (empty($_POST['username'])) { //Name cannot be empty
    $errors['username'] = 'Username can not be blank.';
}
/*
print_r($_POST);
print_r($errors);
exit;
*/
if (!empty($errors))
    { //If errors in validation
        $form_data['success'] = false;
        $form_data['errors']  = $errors;
    }
else
    {
        $form_data['success'] = true;
        $form_data['errors']  = $errors;
        $user->updateAdminUser();
    }
//Return the data back to form.php
echo json_encode($form_data);
?>