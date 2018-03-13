<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1");

$basePath =  str_replace("listing.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once($basePath . "includes/header.php");
//phpinfo();
//print_r($dbConn);
require_once($basePath . "/includes/classes/auctions.class.php");
require_once($basePath . "/includes/classes/bids.class.php");
require_once($basePath . "/includes/helpers/auctionHelpers.class.php");
require_once($basePath . "/includes/classes/Paginator.class.php");

$bid = new bids();
$auc = new auctions();
$auc->Auction_ID = $_GET["id"];
$auc->addAuctionView();
$auc->getSingleAuctionInfo($_GET["id"]);
$bid->Auction_ID = $_GET["id"];
/*  BEGIN - CODE TO BUILD VIEW BIDS TABLE */
$limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 5;
$page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
$bidsQuery = $bid->getAllBidsForAuction();
//print $query . "<br />";
$Paginator  = new Paginator( $dbConn, $bidsQuery );

$results    = $Paginator->getData( $limit, $page );
$startRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? ($_GET['page']-1)*25 + 1 : 1;
$endRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? $_GET['page']*$limit : $limit;

if ($endRec > $results->total) { $endRec = $results->total;}
$pageName .= "?id=" . $_GET["id"] ;
/*  END - CODE TO BUILD VIEW BIDS TABLE */
$ahlp = new auctionHelpers();
?>
<style type="text/css">

    .hide-bullets {
        list-style:none;
        margin-left: -40px;
        margin-top:20px;
    }

    .thumbnail {
        padding: 0;
    }

    .carousel-inner>.item>img, .carousel-inner>.item>a>img {
        width: 100%;
    }
</style>
<br clear="all" />
<br clear="all" />
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ."categories.php?id=" . $auc->CategoryID; ?>"><?=$auc->Category;?></a></li>
                    <li class="breadcrumb-item active"><?=$auc->Title;?></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header text-center">

                    <?php
                    print $auc->Title;
                    print "&nbsp;&nbsp;";
                    if ($auc->Closed)
                    {
                        print '<button type="button" class="btn btn-danger btn-sm">Closed</button>';
                    }
                    else
                    {
                        print '<button type="button" class="btn btn-success btn-sm">Active</button>';
                    }
                    ?>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalShareAuction">Share Auction</button>

                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?php
                if ($ahlp->is_url_exist(IMAGE_BASE_URL .$auc->Picture_URL)) {
                ?>
            <!-- Slider -->
                <div class="row">
                    <div class="col-sm-4" id="slider-thumbs">
                        <!-- Bottom switcher of slider -->
                        <ul class="hide-bullets">
                            <li class="col-sm-12">
                                <a class="thumbnail" id="carousel-selector-0">
                                    <img src="<?php echo IMAGE_BASE_URL .$auc->Picture_URL; ?>">
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-sm-8">
                        <div class="col-xs-12" id="slider">
                            <!-- Top part of the slider -->
                            <div class="row">
                                <div class="col-sm-12" id="carousel-bounding-box">
                                    <div class="carousel slide" id="myCarousel">
                                        <!-- Carousel items -->
                                        <div class="carousel-inner">
                                            <div class="active item" data-slide-number="0">
                                                <img src="<?php echo IMAGE_BASE_URL . $auc->Picture_URL; ?>">
                                            </div>

                                            <!-- Carousel nav -->
                                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                            </a>
                                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/Slider-->
                <?php } ?>
            </div>
            <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                <?php
                $now = time();

                $datediff = $now -  strtotime($auc->Ends);
                    print "Bidding Ends: <strong>" . date('m/d/y - h:i A',strtotime($auc->Ends)) . "</strong><br />";
                    print "Date Difference: " . floor($datediff / (60 * 60 * 24)) . " day(s)";
                    print "<br />";
?>
                    <h5>Quantity: <?=$auc->Quantity;?></h5>
                    <h5>Current Price:
                        <?php
                            $ahlp->displayAmounts($auc->Current_Bid);
                            if (($auc->Value > $auc->Current_Bid) && ($auc->Current_Bid > 0))
                            {
                        ?>
                        &nbsp;&nbsp;<button type="button" class="btn btn-success btn-sm">Value</button>
                <?php
                            }
                ?>
                    </h5>
                    <h5>Value:<?php $ahlp->displayAmounts($auc->Value); ?></h5>
                    <h5>Staring Bid:<?php $ahlp->displayAmounts($auc->Minimum_Bid); ?></h5>
                    <h5>Current Bid:<?php
                        $currBidAmt = ($auc->Number_Of_Bids > 0) ? $auc->Highest_Bid : '0.00';
                        $ahlp->displayAmounts($currBidAmt);
                        ?></h5>
                    <h5>Bid Increment:<?php $ahlp->displayAmounts($auc->Increment); ?></h5>
                    <h5>Minimum Bid:<?php
                        $minBidAmount = (($auc->Current_Bid + $auc->Increment) > $auc->Minimum_Bid) ? $auc->Current_Bid + $auc->Increment : $auc->Minimum_Bid;
                        $ahlp->displayAmounts($minBidAmount);
                        ?></h5>
                    <h5># of Bids:<?php echo $auc->Number_Of_Bids; ?></h5>
                    <h5>Auction ID:<?php echo $auc->Auction_ID ?></h5>
                    <h5><strong>This item has been viewed <?php echo $auc->Auction_Views; ?> time(s)</strong></h5>
                    <h5>Payment Methods: Cash, Checks, Visa, Mastercard, Discover, Paypal</h5>
                    <h5>This item will open on <?php echo date('g a  l, F j ',strtotime($auc->Begins)); ?></h5>
                    <?php
                        if (($auc->Closed) || (!isset($_SESSION["username"]))) {
                            echo '<button id="btnBidNow" type="button" class="btn btm-lg btn-success disabled no-modal">';
                        }
                         else
                         {
                             echo '<button id="btnBidNow" type="button" class="btn btm-lg btn-success" data-toggle="modal" data-target="#bidModal">';
                        }
                        ?>
                        Bid</button>
                    <button type="button" class="btn btm-lg btn-success <?php if ($auc->Closed) { echo " disabled";} ?>">Watch Item</button>
                    <a id="lnkViewBids" href="auction_bids.php?id=<?php echo $_GET["id"]; ?>"  class="btn btm-lg btn-danger <?php if ($auc->Number_Of_Bids == 0 ) { echo " disabled";} ?>" >View Bids</a>

                    <div>
                        <br />
                        <?php echo $auc->Description; ?>
                    </div>
                    <?php
                        if ($auc->Advertiser != "")
                        {
                    ?>
                            <br />
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Offered By</h3>
                                </div>
                                <div class="panel-body"><?=$auc->Advertiser;?></div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info">
                If you have any questions concerning this item, please feel free to contact the merchant for more information on the product.
                You may also visit the merchant at the location listed above to see the item or talk with them in person.
                Pictures or images of items/services may not be exactly as offered and are for representative purposes only.
            </div>

        </div>
    </div>
</div> <!-- /container -->
    <!-- Modal -->
    <div id="bidModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form name="bidNow" id="bidNow" action="#" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bid on Item</h4>
                </div>
                <div class="modal-body">
                    <h4><?php echo $auc->Title; ?></h4>
                    <div class="form-group">
                        <label for="bid_amount">Bid Amount:</label>
                        <input name="bid_amount" type="number" step="any" min="<?php echo $minBidAmount ?>" value="<?php echo $minBidAmount ?>" required />
                        <div class="help-block"><span class="text-danger">Your bid must be at least <?php echo $auc->Minimum_Bid; ?></span></div>
                    </div>
                    <strong>Please Note:</strong> By submitting your bid you commit to buy this item if you are the winner.
                    Submitting your bid does not guarantee you will be the winner.  You may still be outbid.

                </div>
                <div class="modal-footer bg-white">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" value="Bid Now" />
                        <input type="hidden" name="hdnBNUserID" value="<?php echo  $_SESSION["user_id"]; ?>" />
                        <input type="hidden" name="hdnBNAuctionID" value="<?php echo  $auc->Auction_ID; ?>" />
                        <input type="hidden" name="hdnBNCurrentBid" value="<?php echo $minBidAmount; ?>" />
                        <input type="hidden" name="hdnBNIncrement" value="<?php echo $auc->Increment; ?>" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- View BidsModal -->
    <div id="ModalViewBids" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form name="bidNow" action="#" method="POST">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">View Bids on Item</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-header text-center">

                                    <?php
                                    print $auc->Title;
                                ?>
                                </h4>

                                <?php
                                echo "<strong>" .$results->total . "</strong> total auctions found, showing <strong>" .  $startRec . " - " . $endRec . "</strong> <br />";
                                if ($results->total > $limit)
                                {
                                echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
                                }
                                else
                                {
                                print "<br />";
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div id="msgBidNow" class="throw_error text-danger small" style="display: none;"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-white">
                        <div class="text-center">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- BEGIN - Share Auction Modal Window -->
    <div id="ModalShareAuction" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form id="sendFriend" role="form">
                <!-- Modal content-->
                <input type="hidden" name="hdnAuctionTitle" value="<?php echo $auc->Title; ?>" />
                <input type="hidden" name="hdnAuctionID" value="<?php echo $auc->Auction_ID; ?>" />
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Share Item</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-header text-center">

                                    <?php
                                    print $auc->Title;
                                    ?>
                                </h4>

                            </div>

                        </div>
                        <div class="row form-group">
                            <label for="si_friendsName" class="col-sm-4 control-label text-right">Your friend's name</label>
                            <div class="col-sm-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input name="si_friendsName" placeholder="Name" class="form-control" autofocus="" type="text" data-error="Please enter your friends name" required  />
                                </div>
                                <div class="help-block with-errors"></div>

                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="si_friendsEmail" class="col-sm-4 control-label text-right">Your friends e-mail</label>
                            <div class="col-sm-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input name="si_friendsEmail" placeholder="E-Mail Address" class="form-control" autofocus="" type="email" data-error="Please enter your friend's email address" required  />
                                </div>
                                <div class="help-block with-errors"></div>

                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="si_yourName" class="col-sm-4 control-label text-right">Your name</label>
                            <div class="col-sm-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input name="si_yourName" placeholder="Name" class="form-control" autofocus="" type="text" data-error="Please enter your name" required  />
                                </div>
                                <div class="help-block with-errors"></div>

                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="yourEmail" class="col-sm-4 control-label text-right">Your e-mail</label>
                            <div class="col-sm-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input name="si_yourEmail" placeholder="E-Mail Address" class="form-control" autofocus="" type="email" data-error="Please enter your email address" required  />
                                </div>
                                <div class="help-block with-errors"></div>

                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="comments" class="col-sm-4 control-label text-right">Add a comment</label>
                            <div class="col-sm-8 inputGroupContainer">
                                    <textarea name="si_comments" placeholder="Add a comment" class="form-control" rows=5></textarea>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-11">
                                <div id="sendEmail" class="throw_error text-danger small" style="display: none;"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-white">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" value="Share" />
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END - Share Auction Modal Window -->



<script type="text/javascript">

        jQuery(document).ready(function($) {

        $('#myCarousel').carousel({
        interval: 5000
        });

        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click(function () {
        var id_selector = $(this).attr("id");
        try {
        var id = /-(\d+)$/.exec(id_selector)[1];
        console.log(id_selector, id);
        jQuery('#myCarousel').carousel(parseInt(id));
        } catch (e) {
        console.log('Regex failed!', e);
        }
        });
        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid.bs.carousel', function (e) {
        var id = $('.item.active').data('slide-number');
        $('#carousel-text').html($('#slide-content-'+id).html());
        });
        });
        $('#ModalViewBids').on('hidden.bs.modal', function() {
            this.modal('show');
        });

        $("#lnkViewBids").click(function() {
            $(this).attr('target', '_blank');
            var left  = ($(window).width()/2)-(900/2),
                top   = ($(window).height()/2)-(600/2),
                popup = window.open ($(this).attr("href"), "popup", "width=900, height=600, top="+top+", left="+left);
            return false;
        });

</script>



    <script type="text/javascript">
        function CloseModalWindow()
        {
            window.opener.location.reload();
            window.close();
        }

        $('#bidModal').on('show.bs.modal', function(e){
            console.log("event is " + e);
            $('#bidNow')[0].reset();
            $('#bidNow .throw_error').removeClass('throw_error');
            $('#bidNow .help-block').remove();
            if($("#btnBidNow").hasClass('no-modal')) {
                e.stopPropagation();
            }
           // $("#sendEmail").hide();
        });
        $('#ModalShareAuction').on('show.bs.modal', function(){

            $('#sendFriend')[0].reset();
            $('#sendFriend .throw_error').removeClass('throw_error');
            $('#sendFriend .help-block').remove();
            $("#sendEmail").hide();
        });

        $('#sendFriend').submit(function(e){
            var postForm = { //Fetch form data
                'friendName'     : $('input[name=si_friendsName]').val(), //Store name fields value
                'friendEmail'     : $('input[name=si_friendsEmail]').val(), //Store name fields value
                'yourName'     : $('input[name=si_yourName]').val(),
                'yourEmail'     : $('input[name=si_yourEmail]').val(),
                'auctionTitle' : $('input[name=hdnAuctionTitle').val(),
                'auctionID' : $('input[name=hdnAuctionID').val(),
                'comments'     : $('textarea[name=si_comments]').val()

            };
//do some verification
            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL;?>/includes/widgets/share_friend_email.php',
                data: postForm,
                dataType: 'json',
                success   : function(data) {
                    if (!data.success) { //If fails
                        var failMsgs = "";
                        if (data.errors.friendName) { //Returned if any error from process.php
                            failMsgs = data.errors.friendName + "<br />"; //Throw relevant error
                        }
                        if (data.errors.friendEmail) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.friendEmail + "<br />"; //Throw relevant error
                        }
                        if (data.errors.yourName) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.yourName + "<br />"; //Throw relevant error
                        }
                        if (data.errors.yourEmail) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.yourEmail + "<br />"; //Throw relevant error
                        }
                        if (data.errors.comments) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.comments + "<br />"; //Throw relevant error
                        }
                        $('#sendEmail').fadeIn(1000).html(failMsgs); //Throw relevant error

                        //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                    }
                    else {
                        $('#sendEmail').fadeIn(1000).html("Email Sent"); //Throw relevant error
                        setTimeout(function(){

                            $('#ModalShareAuction').modal('hide');
                            $(this).removeData('bs.modal');

                        },3000);
                        window.opener.location.reload(true);
                        return false;
                     //   location.reload();
                    }
                }
            });
            e.preventDefault(); //Prevent the default submit
        });

        /* Bid Now handler */
        $('#bidNow').submit(function(e){
            var postForm = { //Fetch form data
                'userID'     : $('input[name=hdnBNUserID]').val(), //Store name fields value
                'auctionID' : $('input[name=hdnBNAuctionID').val(),
                'bidAmount'     : $('input[name=bid_amount]').val(),
                'minBidAmount' : $('input[name=hdnBNCurrentBid]').val(),
                'bidIncrement' : $('input[name=hdnBNIncrement]').val(),
                'actualBid' : $('input[name=bid_amount').val()
            };
//do some verification
            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL;?>/includes/widgets/ajax_bidNow.php',
                data: $('#bidNow').serialize(),
                dataType: 'json',
                success   : function(data) {
                    if (!data.success) { //If fails
                        var failMsgs = "";
                        if (data.errors.userID) { //Returned if any error from process.php
                            failMsgs = data.errors.userID + "<br />"; //Throw relevant error
                        }
                        if (data.errors.auctionID) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.auctionID + "<br />"; //Throw relevant error
                        }
                        if (data.errors.bidAmount) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.bidAmount + "<br />"; //Throw relevant error
                        }
                        $('#msgBidNow').fadeIn(1000).html(failMsgs); //Throw relevant error

                        //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                    }
                    else {
                        $('#msgBidNow').fadeIn(1000).html("Bid Placed Successfully"); //Throw relevant error
                        setTimeout(function(){
                            $('#bidModal').modal('hide');
                            $(this).removeData('bs.modal');
                        },3000);
                        location.reload();
                        return false;
                    }
                }
            });
            e.preventDefault(); //Prevent the default submit
        });
    </script>

<?php require_once($basePath . "includes/footer.php"); ?>