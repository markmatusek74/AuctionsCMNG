<?php
$basePath =  str_replace("get_help_topic.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../../../includes/classes/help.class.php");
$topic = $_POST["topic"];
$help = new help($topic);
$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$form_data['success'] = true;
$form_data['topic'] = stripslashes($help->HelpTopic);
$form_data['text'] = stripslashes($help->HelpText);
echo json_encode($form_data);

?>