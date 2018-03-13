<?php
$basePath =  str_replace("delete_news_item.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../../../includes/classes/news.class.php");
$newsID = $_GET["id"];

$news = new news($newsID);


$delRecStat = $news->deleteNewsTopic();

$status = ($delRecStat == 1) ? true : false;

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$form_data['success'] = $status;
$form_data['title'] = stripslashes($news->Title);
$form_data['content'] = stripslashes($news->Content);
echo json_encode($form_data);
?>