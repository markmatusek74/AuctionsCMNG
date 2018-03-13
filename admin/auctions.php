<?php
session_start();
$currSection = "auctions";
if(isset($_SESSION['user']))   // Checking whether the session is already there or not if
    // true then header redirect it to the home page directly
{
require_once("includes/header.php");
require_once("includes/config.inc.php");
require_once("../includes/classes/Paginator.class.php");
require_once("../includes/helpers/auctionHelpers.class.php");
$ahlp = new auctionHelpers();



    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    $query      = "SELECT auc.*, cat.cat_name,COUNT(bid.bid) Total_Bids, MAX(bid.bid) Highest_Bid
                    FROM PHPAUCTIONPROPLUS_auctions auc
                    LEFT JOIN PHPAUCTIONPROPLUS_categories cat on cat.cat_id = auc.category
                    left JOIN PHPAUCTIONPROPLUS_bids bid on bid.auction = auc.id
                    GROUP BY auc.ID";
//print $query . "<br />";
    $Paginator  = new Paginator( $dbConn, $query );

    $results    = $Paginator->getData( $limit, $page );

    $startRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? ($_GET['page']-1)*25 + 1 : 1;
    $endRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? $_GET['page']*$limit : $limit;

    if ($endRec > $results->total) { $endRec = $results->total;}
    //   echo "Logged in as: " .$_SESSION['user'];

?>
 <div class="row">
     <div class="col-md-10 col-md-offset-1">
         <h4 class="text-center">Auction Information</h4>
         <?php echo $results->total . " total auctions found, showing " .  $startRec . " - " . $endRec . " <br />"; ?>
         <?php
         if ($results->total > $limit)
         {
             echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
         }

         ?>

         <table class="table table-responsive table-striped">

             <?php
             for( $i = 0; $i < count( $results->data ); $i++ )
             {

                 ?>
                 <tr>
                    <td>
                         <?php
                         if ($results->data[$i]['pict_url'] != "" )
                         {
                             ?>
                            <div class="col-sm-3">
                                <a href="edit_auction.php?id=<?php print $results->data[$i]['id']; ?>">
                                    <img class='img-rounded' src="<?php print IMAGE_BASE_URL . $results->data[$i]['pict_url']; ?>" style="max-height: 100%; max-width: 100%;" />
                                </a>
                            </div>
                            <div class="col-sm-9">
                         <?php }
                         else {
                             print '<div class="col-sm-12">';
                         }?>
                         <?php
                         print "<a href=\"edit_auction.php?id=" .  $results->data[$i]['id'] . "\">";
                         print $results->data[$i]['title'] . "<br />";
                         print "</a>";
                         print "<br />Total Bids: <strong>" . $results->data[$i]["Total_Bids"] . "</strong><br />";
                         print "Current Bid: <strong>";
                         $ahlp->displayAmounts($results->data[$i]["Highest_Bid"]);
                         print  "</strong><br />";
                         $now = time();

                         $datediff = $now -  strtotime($results->data[$i]["ends"]);
                         print "Bidding Ends: <strong>" . date('d/m/y H:i:s',strtotime($results->data[$i]["ends"])) . "</strong><br />";
                         print "<br />";
                         ?>
                        </div>
                    </td>
                </tr>
             <?php
             }
             ?>

         </table>
         <?php
         if ($results->total > $limit)
         {
             echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
         }
         ?>

     </div>
 </div>

<?php
    require_once("includes/widgets/auction_details.php");

}
else
{
    header("Location: index.php");
}

?>