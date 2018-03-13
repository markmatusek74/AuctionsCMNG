<?php
require_once($basePath . "/includes/classes/bids.class.php");
$bids = new bids();
$arrBids = $bids->getHighestBidItems(100,3);
$now = time();
require_once($basePath . "/includes/helpers/auctionHelpers.class.php");
$ahlp = new auctionHelpers();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <h3>Featured Auctions</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                <?php
                //print_r($arrCats);
                foreach ($arrBids as $k) {
                    print "<div class=\"row\">";
                    print "<div class=\"col-sm-12\">";
                    print '<a href="listing.php?id=' . $k["Auction_ID"] . '">' . $k["Auction_Title"] . ')</a><br />';
                    print "</div>";
                    print "</div>";

                    print "<div class=\"row\">";


                    print "<div class=\"col-sm-12\">";
                    print "Current Bid: $" . trim($ahlp->returnAmount($k["Bid_Amount"])) .  "<br />";
                    $datediff = $now -  strtotime($k["Auction_Ends"]);
//                                print "Ends: <strong>" . $k["Auction_Ends"] . "</strong><br />";
//                                print "Bidding Ends: <strong>" . date('m/d/y H:i:s',strtotime($k["Auction_Ends"])) . "</strong><br />";
//                                print "Ends In: " . floor($datediff / (60 * 60 * 24)) . " day(s) " . floor($datediff / (60 * 60 * 24 * 60)) . " hour(s) " .  floor($datediff / (60 * 60 * 24 * 60 * 60 )) . " minute(s)";
                    print "Ends In: " . floor($datediff / (60 * 60 * 24)) . " day(s) ";

                    print "</div>";

                    print "</div>";
                    print "<div class=\"row\">";
                    print "<div class=\"col-sm-12\">&nbsp;";
                    print "</div>";
                    print "</div>";
                    // $arr[3] will be updated with each value from $arr...

                }
                ?>

            </div>
        </div>
    </div>
</div>
