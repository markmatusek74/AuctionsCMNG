<?php
$basePath =  str_replace("update_news_item.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../../../includes/classes/news.class.php");
$news = new news($_POST["newsId"]);

//print_r($_POST);
$news->ID = $_POST["newsId"];
$news->Title = stripslashes($_POST["newsTitle"]);
$news->Content = stripslashes($_POST["newsContent"]);
$news->NewsDate = date("Ydm", strtotime($_POST["newsDate"]));
/*
 *
 News id: " . $news->ID . "\n";

print "News date: " . date("Ydm", strtotime($_POST["newsDate"])) . "\n";

print "News title: " . $news->Title . "\n";
print "News content from form: " . $_POST["newsContent"] . "<br />";

print "News content: " . $news->Content . "\n";
*/
$news->updateNewsTopic();
//exit;

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$form_data['success'] = true;
$form_data['title'] = stripslashes($news->Title);
$form_data['content'] = stripslashes($news->Content);
echo json_encode($form_data);
?>