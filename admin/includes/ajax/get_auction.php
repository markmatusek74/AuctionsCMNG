<?php
$basePath =  str_replace("get_auction.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../../../includes/classes/auctions.class.php");
$auctionID = $_POST["id"];
$auc = new auctions();
$auc->getSingleAuctionInfo($auctionID);

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`

$form_data['success'] = true;
$form_data['auctionID'] = $auctionID;
$form_data['auctionTitle'] = $auc->Title;
$form_data["auctionDescription"] = ($auc->Description);
echo json_encode($form_data);

?>