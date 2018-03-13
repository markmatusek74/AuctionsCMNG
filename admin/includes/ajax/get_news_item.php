<?php
$basePath =  str_replace("get_news_item.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../../../includes/classes/news.class.php");
$news = new news($_POST["id"]);

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$form_data['success'] = true;
$form_data['title'] = stripslashes($news->Title);
$form_data['content'] = stripslashes($news->Content);
$form_data['id'] = $_POST["id"];

/*
print "News id: " . $news->ID . "\n";

print "News date: " . date("Ydm", strtotime($_POST["newsDate"])) . "\n";

print "News title: " . $news->Title . "\n";
print "News content: " . $news->Content . "\n";
exit;
*/
echo json_encode($form_data);

?>