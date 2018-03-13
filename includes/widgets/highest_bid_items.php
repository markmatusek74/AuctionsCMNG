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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Featured Auctions
                </div>
                <div class="panel-body">
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

                                print "<div class=\"col-sm-4\">";
                                if ($ahlp->is_url_exist(IMAGE_BASE_URL . $k["Auction_Picture"]))
                                {
                                    print "<img class=\"image-responsive\" src=\"" . IMAGE_BASE_URL . $k["Auction_Picture"] . "\" width=\"100%\" alt=\"" . $k["Auction_Title"] . "\">";

                                }
                                else
                                {
                                   // print "no image";
                                }
                                print "</div>";

                                print "<div class=\"col-sm-8\">";
                                print "Bid: <strong>$" . trim($ahlp->returnAmount($k["Bid_Amount"])) .  "</strong> <br />";
                                $datediff = $now -  strtotime($k["Auction_Ends"]);
//                                print "Ends: <strong>" . $k["Auction_Ends"] . "</strong><br />";
//                                print "Bidding Ends: <strong>" . date('m/d/y H:i:s',strtotime($k["Auction_Ends"])) . "</strong><br />";
//                                print "Ends In: " . floor($datediff / (60 * 60 * 24)) . " day(s) " . floor($datediff / (60 * 60 * 24 * 60)) . " hour(s) " .  floor($datediff / (60 * 60 * 24 * 60 * 60 )) . " minute(s)";
                                print "Ends In: <strong>" . floor($datediff / (60 * 60 * 24)) . " day(s) </strong> ";

                                print "</div>";

                                print "</div>";
                                print "<div class=\"row\">";
                                print "<div class=\"col-sm-12\">";
                                print "<hr />";
                                print "</div>";
                                print "</div>";
                                // $arr[3] will be updated with each value from $arr...

                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
