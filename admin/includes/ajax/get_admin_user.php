<?php
$basePath =  str_replace("get_admin_user.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../classes/login.class.php");
$usr = new AdminLogin();
$usr->ID = $_POST["id"];
$usr->getAdminUserInfo();

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$form_data['success'] = true;
$form_data['username'] = stripslashes($usr->Username);
$form_data['password'] = stripslashes($usr->Password);
echo json_encode($form_data);

?>