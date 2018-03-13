<?php
$basePath =  str_replace(basename($_SERVER['PHP_SELF']),"",$_SERVER["SCRIPT_FILENAME"]);
require_once("../config.inc.php");
require_once($basePath . "../../../includes/classes/auctions.class.php");
$auc = new auctions();
$dtNow = date("YmdHis");

$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$auc->Auction_ID =  $_POST["id"];
$auc->Title = $_POST["auctionTitle"];
$auc->Starts = $_POST["startDate"];
$auc->Ends = $_POST["endDate"];
$auc->Description = $_POST["auctionDescription"];
$auc->Auction_Type = $_POST["auctionType"];
$auc->Quantity = $_POST["auctionQuantity"];
$auc->Minimum_Bid = $_POST["startingBid"];
$auc->Reserve_Price = $_POST["reservePrice"];
$auc->Increment = $_POST["bidIncrement"];
$auc->Location_Zip = $_POST["zipCode"];

/*
if (!empty($_POST['username'])) { //Name cannot be empty
   // $form_data['helpTopic'] = $_POST["topic"];
}

if (empty($_POST['password'])) { //Name cannot be empty
    $errors['password'] = 'Password can not be blank.';
}

if (empty($_POST['username'])) { //Name cannot be empty
    $errors['username'] = 'Username can not be blank.';
}
*/
// Target file if want to use the original filename
if ($_FILES["pictUrl"]["name"] <> "") {
    $uploadedFile = IMG_UPLOAD_FOLDER . "auctions/" . basename($_FILES["pictUrl"]["name"]);

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
    $auctionImageFile = IMG_UPLOAD_FOLDER . "auctions/" . $_POST["id"] . "." . $imageFileType;
    $auctionFilenameNoExt = $_POST["id"];

    $uplFilenameNoExt = basename(basename($_FILES["pictUrl"]["name"]), "." . $imageFileType);
    $target_file = IMG_UPLOAD_FOLDER . "auctions/" . $_POST["id"] . "." . $imageFileType;
    $arcUploadedFilename = $uplFilenameNoExt . "_" . $dtNow . "." . $imageFileType;
    $arcAuctionFilename = $auctionFilenameNoExt . "_" . $dtNow . "." . $imageFileType;
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["pictUrl"]["tmp_name"]);
    if ($check !== false) {
        // File is an image - " . $check["mime"] . "."
        $uploadOk = 1;
    } else {
        // File is not an image.
        $uploadOk = 0;
    }

    if (file_exists($auctionImageFile)) {
        rename($auctionImageFile, IMG_UPLOAD_FOLDER . "auctions/archive/" . $arcAuctionFilename);
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        rename($target_file, IMG_UPLOAD_FOLDER . "auctions/archive/" . $arcUploadedFilename);
    }
    // Check file size
    if ($_FILES["pictUrl"]["size"] > 5000000) {
        // Your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        // only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // your file was not uploaded.";
    } // if everything is ok, try to upload file
    else {
        if (move_uploaded_file($_FILES["pictUrl"]["tmp_name"], $target_file)) {
            $auc->Picture_URL = $_POST["id"] . "." . $imageFileType;

            //  basename( $_FILES["pictUrl"]["name"]). " has been uploaded.";
        } else {
            // There was an error uploading your file.";
        }
    }
}

//print_r($errors);

if (!empty($errors))
    { //If errors in validation
        $form_data['success'] = false;
        $form_data['errors']  = $errors;
    }
else
    {
        $form_data['success'] = true;
        $form_data['errors']  = $errors;
        $success = $auc->updateAuction();
    }
if ($success)
{
    $returnUrl = BASE_URL . "admin/auctions.php";
    header('Location: ' . $returnUrl);

}


?>