
<?php
$basePath =  str_replace("share_friend_email.php","",$_SERVER["SCRIPT_FILENAME"]);


require_once($basePath . "../config.inc.php");
require_once($basePath . "../classes/phpMailer/class.phpmailer.php");
require_once($basePath . "../classes/phpMailer/class.smtp.php");
$eml = new PHPMailer();

//print_r($_POST);
$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`

/* Validate the form on the server side */
if (empty($_POST['friendName'])) {
    $errors['friendName'] = 'Your friend\'s name cannot be blank';
}
if (empty($_POST['friendEmail'])) {
    $errors['password'] = 'Your friend\'s email cannot be blank';
}
if (empty($_POST['yourName'])) {
    $errors['yourName'] = 'Your name cannot be blank';
}
if (empty($_POST['yourEmail'])) {
    $errors['yourEmail'] = 'Your email cannot be blank';
}
if (empty($_POST['comments'])) {
    $errors['comments'] = 'Comments cannot be blank';
}

if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
}
else
{
    $friendName = $_POST['friendName'];
    $friendEmail = $_POST['friendEmail'];
    $yourName = $_POST['yourName'];
    $yourEmail = $_POST['yourEmail'];
    $comments = $_POST["comments"];
    $auctionTitle = $_POST["auctionTitle"];
    $auctionDescription = "";
    $htmlMessage = "";
    $htmlMessage .= "<body>";
    $htmlMessage .= "<p>Dear $friendName,</p>";

    $htmlMessage .= "<p>$yourName at $yourEmail has forwarded an auction at " . SITENAME . " for you to see.</p>

<p>$yourName comments: $comments</p>

<p>Title: $auctionTitle</p>
<p>Item: $auctionDescription</p>

<p>You may visit the auction here: <a href=\"" . BASE_URL . "listing.php?id=" . $_POST["auctionID"] . "\">" . BASE_URL . "/listing.php?id=" . $_POST["auctionID"] . "</a></p>

<p>If you have received this message in error, please reply to this email,
write to support@ludingtondailynews.com, or visit Shoreline Media  Auction at " . BASE_URL . ".</p>";


    $htmlMessage .= "</body>";
    $eml->AddAddress($_POST['friendEmail']);
//    $eml->AddBCC("markmatusek74@gmail.com");
//    $eml->AddBCC("mark@matusek.com");
    $eml->FromName = "Shoreline Media  Auction";
    $eml->From = "support@ludingtondailynews.com";

    $eml->MsgHTML($htmlMessage);
    $eml->Subject = "Shoreline Auctions - Send to a Friend";
    $eml->Send();

    $form_data['success'] = true;

}

//print_r($form_data);

//Return the data back to form.php
echo json_encode($form_data);

?>