<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location:index.php");
    exit();
}
$basePath =  str_replace("my_bids.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once($basePath . "/includes/classes/bids.class.php");
require_once($basePath . "/includes/classes/Paginator.class.php");
require_once($basePath . "/includes/helpers/auctionHelpers.class.php");
$ahlp = new auctionHelpers();

$bids = new bids();
$user_id = $_SESSION["user_id"];
$query = $bids->getUsersBids($user_id);
require_once($basePath . "includes/header.php");
$datediff = "";
$now = time();


$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
$Paginator  = new Paginator( $dbConn, $query );

$results    = $Paginator->getData( $limit, $page );

$pageName .= "?id=" . $_GET["id"] ;
$startRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? ($_GET['page']-1)*25 + 1 : 1;
$endRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? $_GET['page']*$limit : $limit;

if ($endRec > $results->total) { $endRec = $results->total;}

?>

<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">&nbsp;</div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="http://67.227.134.122/~todayswheels/ldn_new_site/">Home</a></li>
                    <li class="breadcrumb-item">My Bids</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header text-center">My Bids</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9">

                <?php
                echo $results->total . " total bids found, showing " .  $startRec . " - " . $endRec . " <br />";
                if (count($results->total) > 0 )
                    {

                        if ($results->total > $limit)
                        {
                            echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
                        }

                        print '<table class="table table-bordered table-responsive table-striped">';
                        print '<tr>';
                        print '<th>Bid Date</th>';
                        print '<th>Your Bid</th>';
                        print '<th>Auction</th>';
                        print '<th>Ends In</th>';
                        print '</tr>';

                        for( $i = 0; $i < count( $results->data ); $i++ )
                        {
                            $datediff = $now -  strtotime($results->data[$i]["ends"]);

                            print "<tr>";
                            print "<td>" . date('m/d/y h:i A',strtotime($results->data[$i]["bidwhen"])) . "</td>";
                            print "<td>";
                            $ahlp->displayAmounts($results->data[$i]["bid"]);
                            print  "</td>";
                            print "<td>" . $results->data[$i]["title"] . "</td>";
                            print "<td>" . floor($datediff / (60 * 60 * 24)) . " day(s)</td>";
                            print "</tr>";

                        }
                        print "</table>";
                        if ($results->total > $limit)
                        {
                            echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
                        }

                    }

                ?>
            </div>
            <?php require_once("includes/right_rail.php"); ?>

        </div>
    </div>
</div> <!-- /container -->

<?php require_once($basePath . "includes/footer.php"); ?>
