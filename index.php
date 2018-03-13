<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1");

$basePath =  str_replace("index.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once($basePath . "includes/header.php");
$auc->getFeaturedAuction();

//phpinfo();
//print_r($dbConn);
?>
<style type="text/css">
    .carousel-control.left, .carousel-control.right { background-image: none; }
    .carousel-caption { color: #666666;}
    #myCarousel {background-color: #eee;}

    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        display: block;
        max-width: 100%;
        height: 250px !important;
    }
</style>
<br clear="all" />
<br clear="all" />
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
        <div class="row">

            <?php require_once($basePath . "includes/widgets/category_list_widget.php"); ?>
            <div class="col-sm-7">
                <div class="row">
                    <div class="col-sm-12">
                        <img class="img img-responsive" src="<?php echo BASE_URL; ?>images/auction-middle.jpg" alt="Auctions 2018 | Start bidding Now" />
                    </div>
                </div>
            <?php require_once("includes/widgets/hp_recent_bids.php"); ?>
        </div>
        <?php require_once("includes/right_rail.php"); ?>

    </div>
</div> <!-- /container -->

<?php require_once($basePath . "includes/footer.php"); ?>