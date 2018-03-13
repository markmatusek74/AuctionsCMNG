<?php
session_start();

$basePath =  str_replace("register_rules.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once($basePath . "includes/header.php");

?>

<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header text-center">Register</h1>
            </div>
        </div>

        <div id="regForm" class="row">
            <div class="col-sm-12">

                <p><strong>You must read and accept the following auction rules before registering.</strong></p>

                <p>Auction bidding begins through the Shoreline Media auction web site. Starting at 9 a.m. Saturday, April 18 and continuing through Sunday, April 19, live bids will be taken by calling 845-5181 or toll-free at 1-800-748-0407.</p>

                <p>Items will be featured in twenty minute segments throughout both days. (See Listing of items and closing times in the special auction insert distributed with the Ludington Daily News, Oceana's Herald-Journal and White Lake Beacon the week preceedig the auction).</p>

                <p>At the end of the twenty-minute segment, online live bidding will be closed on those items. Because a limited number of phone lines are available, phone bids will be accepted on items featured in that twenty-minute segment provided there are two or more persons interested in the item at time of closing.</p>

                <p>All items may be bid online at anytime up to the closing time listed. Auction closings online will be determined by the time shown in the Auction program.</p>

                <p>Bidders on the phone and actively bidding at the time of the closing will be allowed to continue bidding. No new phone calls on that item will be accepted after the closing times listed. If there are no bidders on the phone at auction item closing, the auction is considered closed. <strong>Proxy bids placed online through the auction software will continue to be active until the auction is deemed closed, however no new online bids or proxy bids will be accepted after the closing times stated online.</strong></p>

                <p>Winning bid amounts will be posted on the website for all auction items by final auction closing on Sunday. Winning bidders will be contacted by phone and will have one week to pick up their merchandise certificates to redeem at the participating merchant.</p>

                <p>All payments can be made at the Ludington Daily News offices located at 202 N. Rath Ave., in Ludington, Oceana's Herald-Journal, 123 State Street, Hart or White Lake Beacon, 425 Spring Street, Whitehall. Sales tax and any other fees involved with obtaining any of the items purchased must be paid to the company providing the item for bid and are not included in the bid price. All sales are final. No exchanges or returns are allowed.</p>

                <p><a href="register.php?a=<?php echo md5("AcceptRules"); ?>" class="btn btn-success">Accept Rules</a></p>

            </div>
        </div>
    </div>
</div> <!-- /container -->

<?php require_once($basePath . "includes/footer.php"); ?>
