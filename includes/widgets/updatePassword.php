<?php
$basePath =  str_replace("updatePassword.php","",$_SERVER["SCRIPT_FILENAME"]);

require_once($basePath . "../classes/users.class.php");
$usr = new users();
$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`

if (!empty($_POST['id'])) { //Name cannot be empty
    $form_data['userID'] = $_POST["id"];
}


/* Validate the form on the server side */
if (empty($_POST['password'])) { //Name cannot be empty
    $errors['password'] = 'Password cannot be blank';
}



if (empty($_POST['confirmPassword'])) { //Name cannot be empty
    $errors['confirmPassword'] = 'Confirm password cannot be blank';
}

if (!empty($errors)) { //If errors in validation
 //   $form_data['success'] = false;
//    $form_data['errors']  = $errors;
}


else {

    if ((strtolower(trim($_POST["password"]))) == strtolower(trim($_POST["confirmPassword"])))
    {

        if ((!empty($_POST['password'])) && (strlen($_POST["password"]) < 6)) { //Name cannot be empty
            $errors['pwd_length'] = 'Password is too short (must be at least 6 characters).';
        }
        else
        {
            $form_data['success'] = true;
            $usr->ID = $_POST['id'];
            $usr->Password = md5($_POST['password']);
            $usr->updatePasswordForUser();

        }

        // update the password
    }
    else
    {
        $errors['pwd_check'] = 'Passwords do not match';

    }

}
if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
}

//print_r($form_data);

//Return the data back to form.php
echo json_encode($form_data);

?>