<?php
$basePath =  str_replace("delete_help_topic.php","",$_SERVER["SCRIPT_FILENAME"]);

require_once($basePath . "../../../includes/classes/help.class.php");
$help = new help();

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$help->HelpTopic = $_GET['id'];


$delRecStat = $help->deleteHelpTopic();
$status = ($delRecStat == 1) ? true : false;

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$form_data['success'] = $status;
$form_data['title'] = stripslashes($news->Title);
$form_data['content'] = stripslashes($news->Content);
echo json_encode($form_data);

?>