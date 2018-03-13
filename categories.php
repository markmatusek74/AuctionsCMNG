<?php
session_start();

$basePath =  str_replace("categories.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($basePath . "/includes/classes/categories.class.php");
require_once($basePath . "/includes/classes/Paginator.class.php");

require_once($basePath . "/includes/helpers/auctionHelpers.class.php");
$ahlp = new auctionHelpers();
$cat = new categories();
$arrCats = $cat->getCategoryList();
$catID = (isset($_GET["id"])) ? $_GET["id"] : 0;

require_once($basePath . "includes/header.php");
//phpinfo();
//print_r($dbConn);



$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : CATEGORY_RESULTS_COUNT;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
$query      = "SELECT auc.*, cat.cat_name,COUNT(bid.bid) Total_Bids, MAX(bid.bid) Highest_Bid FROM PHPAUCTIONPROPLUS_auctions auc
                    JOIN PHPAUCTIONPROPLUS_categories cat on cat.cat_id = auc.category
                    left JOIN PHPAUCTIONPROPLUS_bids bid on bid.auction = auc.id
                    WHERE category = '" . $catID . "'
                    GROUP BY auc.ID";
//print $query . "<br />";
$Paginator  = new Paginator( $dbConn, $query );

$results    = $Paginator->getData( $limit, $page );
$startRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? ($_GET['page']-1)*25 + 1 : 1;
$endRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? $_GET['page']*$limit : $limit;

if ($endRec > $results->total) { $endRec = $results->total;}
$pageName .= "?id=" . $_GET["id"] ;
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="http://67.227.134.122/~todayswheels/ldn_new_site/">Home</a></li>
                    <li class="breadcrumb-item active"><?=$results->data[0]['cat_name'];?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <?php require_once($basePath . "includes/widgets/category_list_widget.php"); ?>
            <div class="col-md-6">

                <?php

                echo "You are viewing category <strong>" . $cat->getCategoryNameByID($catID) . "</strong><br />";


                echo "<strong>" .$results->total . "</strong> total auctions found, showing <strong>" .  $startRec . " - " . $endRec . "</strong> <br />";

                if ($results->total > $limit)
                {
                    echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
                }
                else
                {
                    print "<br />";
                }

                for( $i = 0; $i < count( $results->data ); $i++ )
                    {

                 ?>
                <div class="row">
                    <div class="col-sm-3">
                        <?php
                            if (( $results->data[$i]['pict_url'] != "") && ($ahlp->is_url_exist(IMAGE_BASE_URL .$results->data[$i]['pict_url'])))
                            {


                        ?>
                        <a href="<?php print BASE_URL; ?>listing.php?id=<?php print $results->data[$i]['id']; ?>">
                        <img class='img-rounded' src="<?php echo IMAGE_BASE_URL .$results->data[$i]['pict_url']; ?>" style="max-height: 100%; max-width: 100%;" />
                        </a>
                            <?php } ?>
                    </div>
                    <div class="col-sm-9">
                        <?php
                            print "<a href=\"" .  BASE_URL. "listing.php?id=" . $results->data[$i]['id'] ."\">";
                            print $results->data[$i]['title'] . "<br />";
                            print "</a>";
                            print  $results->data[$i]['short_desc'];
                            print "<br />Total Bids: <strong>" . $results->data[$i]["Total_Bids"] . "</strong><br />";
                            print "Bid Amount: <strong>";
                            $ahlp->displayAmounts($results->data[$i]["Highest_Bid"]);
                            print  "</strong><br />";
                                $now = time();

                        $datediff = $now -  strtotime($results->data[$i]["ends"]);
                            print "Ends: <strong>" . date('d/m/y h:i:s A',strtotime($results->data[$i]["ends"])) . "</strong><br />";
                            print "Ends in: " . floor($datediff / (60 * 60 * 24)) . " day(s)";
                            print "<br />";
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <hr />
                    </div>
                </div>
                <?php
                    }
                if ($results->total > $limit)
                {
                echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
                }
            ?>
            </div>
            <?php
                    // Start Right Rail
                    require_once("includes/right_rail.php");
            ?>
        </div>
    </div>


<?php require_once($basePath . "includes/footer.php"); ?>
