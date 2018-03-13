<?php
$basePath =  str_replace("delete_admin_user.php","",$_SERVER["SCRIPT_FILENAME"]);

require_once($basePath . "../../../includes/classes/adminUsers.class.php");
$user = new adminUsers();

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$user->ID = $_GET['id'];


$delRecStat = $user->deleteAdminUser();
$status = ($delRecStat == 1) ? true : false;

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$form_data['success'] = $status;
$form_data['title'] = stripslashes($news->Title);
$form_data['content'] = stripslashes($news->Content);
echo json_encode($form_data);

?>