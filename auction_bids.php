<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location:index.php");
    exit();
}
$basePath =  str_replace("auction_bids.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once($basePath . "/includes/classes/bids.class.php");
require_once($basePath . "/includes/classes/Paginator.class.php");
require_once($basePath . "/includes/helpers/auctionHelpers.class.php");
$ahlp = new auctionHelpers();

$bids = new bids();
require_once($basePath . "includes/header_base.php");
$datediff = "";
$now = time();
$bids->Auction_ID = $_GET["id"];

/*  BEGIN - CODE TO BUILD VIEW BIDS TABLE */
$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 5;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
$bidsQuery = $bids->getAllBidsForAuction();
//print $query . "<br />";
$Paginator  = new Paginator( $dbConn, $bidsQuery );

$results    = $Paginator->getData( $limit, $page );
$startRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? ($_GET['page']-1)*5 + 1 : 1;
$endRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? $_GET['page']*$limit : $limit;

//print_r($results);
if ($endRec > $results->total) { $endRec = $results->total;}
$pageName .= "?id=" . $_GET["id"] ;
/*  END - CODE TO BUILD VIEW BIDS TABLE */
?>

<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header text-center">View Bids</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <?php
                echo $results->total . " total bids found, showing " .  $startRec . " - " . $endRec . " <br />";
                if (count($results->total) > 0 )
                    {

                        if ($results->total > $limit)
                        {
                            echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
                        }
                ?>
                <table class="table table-responsive table-striped">
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Bidder</th>
                                    </tr>
                                    <?php
                                        for( $i = 0; $i < count( $results->data ); $i++ )
                                        {
                                            print "<tr>";
                                            print "<td>" . $ahlp->formatDateTime($results->data[$i]['bidwhen']) . "</td>";
                                            print "<td>";
                                            $ahlp->displayAmounts($results->data[$i]['bid']);
                                            print "</td>";
                                            print "<td>" . $results->data[$i]['nick'] . "</td>";
                                            print "</tr>";
                                        }


                                    ?>
                </table>
                <?php
                        if ($results->total > $limit)
                        {
                            echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
                        }

                    }

                ?>
            </div>

        </div>
    </div>
</div> <!-- /container -->

<?php require_once($basePath . "includes/footer_base.php"); ?>
