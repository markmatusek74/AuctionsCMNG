<?php
session_start();
$basePath =  str_replace("ajax_bidNow.php","",$_SERVER["SCRIPT_FILENAME"]);
require_once($basePath . "../config.inc.php");

require_once($basePath . "..//classes/users.class.php");
require_once($basePath . "../classes/bids.class.php");
$bids = new bids();
$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$currentAuction = $_POST["hdnBNAuctionID"];
$currentBidder = $_POST["hdnBNUserID"];
$bidIncrement = $_POST["hdnBNIncrement"];

$bids->Auction_ID = $currentAuction;
$bids->Bidder = $currentBidder;
$bids->Bid_Amount = $_POST['bid_amount'];
$nextBidAmount = $_POST['bid_amount'] + $bidIncrement;
$arrCurrBid = $bids->getHighestBidAndBidderForAuction();
$arrProxyBid = $bids->getHighestProxyBidAndBidderForAuction();
$bidSubmitted = $_POST["bid_amount"];
$bidMinimum = $_POST['minBidAmount'];
$highestRegBid = $arrCurrBid[0]["Highest_Bid"];
$highestRegBidder =  $arrCurrBid[0]["Bidder"];
$highestProxyBid = $arrProxyBid[0]["Highest_Bid"];
$highestRegBidder =  $arrProxyBid[0]["Bidder"];
/* Validate the form on the server side */
if (empty($_POST['bid_amount'])) { //Name cannot be empty
    $errors['bidAmount'] = 'Bid Amount cannot be blank';
}

if (!empty($errors)) { //If errors in validation
 //   $form_data['success'] = false;
//    $form_data['errors']  = $errors;
}


else {
    $lUser = new users();
 //If not, process the form, and return true on success
    $lUser->ID = $_POST["hdnBNUserID"];
    $lUser->getUserInfoByID();

    if ($lUser->Username)
    {
        if (($bidSubmitted >= $bidMinimum))
        {
            if (($bidSubmitted < $highestProxyBid) && ( $nextBidAmount <= $highestProxyBid))
            {
                $bids->AddUserBid();
                // Add Proxy Bidder Bid
                $bids->Bid_Amount = $_POST['bid_amount'] + $bidIncrement;
                $bids->Bidder = $highestRegBidder;
                $bids->AddUserBid();
              //  print "insert bid, then proxy bid<br />\n";
            }
            else
            {
                $bids->AddUserBid();
               // print "put your bid highest<br />\n";
            }
        }
        $form_data['success'] = true;
        $form_data['posted'] = 'Bid has been placed successfully.';


    }
    else
    {
        $errors['uid_check'] = 'Can not place bid, user is not found in the system.';
    }

}
if (!empty($errors)) { //If errors in validation
    $form_data['success'] = false;
    $form_data['errors']  = $errors;
}
else
{

}
//Return the data back to form.php
echo json_encode($form_data);

?>