<?php
session_start();
$currSection = "auctions";



require_once("includes/header.php");
require_once("includes/config.inc.php");
require_once("../includes/helpers/auctionHelpers.class.php");
require_once("../includes/classes/auctions.class.php");
$ahlp = new auctionHelpers();
$auctionID = $_GET["id"];
$auc = new auctions();
$auc->getSingleAuctionInfo($auctionID);

if(isset($_SESSION['user']))   // Checking whether the session is already there or not if
    // true then header redirect it to the home page directly
{

 //   echo "page name: " . basename($_SERVER['PHP_SELF']) . "<br />";
//print_r($_SERVER);
?>
    <script src='<?php echo BASE_URL;?>js/tinymce/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            force_br_newlines : false,
            force_p_newlines : false,
            forced_root_block : ''
        });

    </script>
    <script type="text/javascript" src="<?php echo BASE_URL;?>/js/moment.js" charset="UTF-8"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />


    <style type="text/css">
        form div.form-group { margin: 20px 0 !important; display: block;}
    </style>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header text-center">Edit Auction</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div id="regForm" class="row">
                    <div class="col-sm-12">

                        <div id="success_message"></div>
                        <form id="auction_form" method="post" action="includes/ajax/update_auction_info.php" data-toggle="validator" role="form" enctype="multipart/form-data">

                            <div class="row form-group">
                                <label for="auctionTitle" class="col-sm-3 control-label text-right">Title</label>
                                <div class="col-sm-9 inputGroupContainer">
                                        <input name="auctionTitle" placeholder="Auction Title" class="form-control" autofocus="" type="text" required value="<?php print $auc->Title; ?>" />
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="startDate" class="col-sm-3 control-label text-right">Start Date</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input id="startDate" name="startDate" placeholder="Start Date" class="form-control" data-date-format="mm/dd/yyyy" autofocus="" type="text" value="<?php print substr($auc->Starts,4,2) . "/" . substr($auc->Starts,6,2) . "/" .  substr($auc->Starts,0,4); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="endDate" class="col-sm-3 control-label text-right">End Date/Time</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input id="endDate" name="endDate" placeholder="End Date" class="form-control" autofocus="" type="text" value="<?php print substr($auc->Ends,4,2) . "/" . substr($auc->Ends,6,2) . "/" .  substr($auc->Ends,0,4); ?>" />
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    $('#startDate,#endDate').datetimepicker();
                                });
                            </script>
                            <div class="row form-group">
                                <label for="username" class="col-sm-3 control-label text-right">Description</label>
                                <div class="col-sm-9 inputGroupContainer">
                                        <textarea name="auctionDescription" placeholder="Add a Description" class="form-control" rows="5"><?php print $auc->Description; ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="email" class="col-sm-3 control-label text-right">Auction Type</label>
                                <div class="col-sm-9 inputGroupContainer">
                                        <select name="auctionType" placeholder="-- Select One --" class="form-control"  data-error="Please select an auction type" required>
                                            <?php
                                            foreach ($auction_types as $key=>$val) {
                                                $selected = ($auc->Auction_Type == $key ) ? " selected='selected' " : "";

                                                print "<option value='" . $key . "' $selected >" . $val . "</option>";

                                            }
                                            ?>

                                        </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="quantity" class="col-sm-3 control-label text-right">Quantity</label>
                                <div class="col-sm-9 inputGroupContainer">
                                        <input id="quantity" name="auctionQuantity" placeholder="1" class="form-control" autofocus="" type="number" value="<?php print $auc->Quantity; ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="startingBid" class="col-sm-3 control-label text-right">Starting Bid</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <input name="startingBid" placeholder="0.00" class="form-control" autofocus="" type="text" value="<?php print $ahlp->returnAmount($auc->Minimum_Bid); ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="reservePrice" class="col-sm-3 control-label text-right">Reserve Price</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <input name="reservePrice" placeholder="0.00" class="form-control" autofocus="" type="text" value="<?php print $ahlp->returnAmount($auc->Reserve_Price); ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="bidIncrement" class="col-sm-3 control-label text-right">Increment</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <input name="bidIncrement" placeholder="0.00" class="form-control" autofocus="" type="text" value="<?php print $ahlp->returnAmount($auc->Increment); ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="bidIncrement" class="col-sm-3 control-label text-right">Duration</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <input name="bidIncrement" placeholder="0" class="form-control" autofocus="" type="number" value="<?php print $auc->Duration; ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="email" class="col-sm-3 control-label text-right">Country</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <select name="auctionType" placeholder="-- Select One --" class="form-control"  data-error="Please select an auction type" required>
                                        <?php
                                        foreach ($countries as $key=>$val) {
                                            $selected = ($auc->Country == $key ) ? " selected='selected' " : "";

                                            print "<option value='" . $key . "' $selected >" . $val . "</option>";

                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="zipCode" class="col-sm-3 control-label text-right">Zip</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <input name="zipCode" placeholder="Enter Zip Code" class="form-control" autofocus="" type="text" required value="<?php print $auc->Location_Zip; ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="pictUrl" class="col-sm-3 control-label text-right">Zip</label>
                                <div class="col-sm-9 inputGroupContainer">
                                    <input name="pictUrl" class="form-control" autofocus="" type="file"  />
                                </div>
                            </div>

                            <div class="form-group">
                                &nbsp;
                            </div>
                            <div class="form-group text-center">
                                <input type="hidden" name="id" value="<?php print $auc->Auction_ID; ?>" />
                                <input type="submit" name="register" value="Update Info" class="btn btn-success" />
                                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-danger">Cancel</a>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>



<?php
}
else
{
    header("Location:index.php");
}

?>