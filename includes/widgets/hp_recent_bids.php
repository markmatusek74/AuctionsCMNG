<?php
require_once($basePath . "/includes/classes/bids.class.php");
$bids = new bids();
$arrBids = $bids->getFeaturedRecentBids(5);

require_once($basePath . "/includes/helpers/auctionHelpers.class.php");
$ahlp = new auctionHelpers();
?>
<div class="row">
    &nbsp;
</div>
<div class="row">
    <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Recent Bids</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            <table class="table table-responsive table-striped">
                                <tr>
                                    <th>Amount</th>
                                    <th>Description</th>
                                </tr>
                                <?php
                                //print_r($arrCats);
                                foreach ($arrBids as $k) {
                                    print "<tr>";
                                    print "<td class='text-right'>";
                                    $ahlp->displayAmounts($k["Bid_Amount"]);
                                    print  "</td>";
                                    print '<td><a href="listing.php?id=' . $k["Auction_ID"] . '">' . $k["Auction_Title"] . ')</a></td>';
                                    print "</tr>";
                                    // $arr[3] will be updated with each value from $arr...

                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
