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
    $query      = "SELECT *
                    FROM PHPAUCTIONPROPLUS_users ORDER BY nick";
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
         <h4 class="text-center">User Information</h4>
         <?php echo $results->total . " total auctions found, showing " .  $startRec . " - " . $endRec . " <br />"; ?>
         <?php
         if ($results->total > $limit)
         {
             echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
         }

         ?>

         <table class="table table-responsive table-striped">
                <tr>
                    <th>&nbsp;</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Email</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
             <?php
             for( $i = 0; $i < count( $results->data ); $i++ )
             {
                print '<tr>';
                print "<td>";
                 print '<a class="btn btn-success btn-xs" href="edit_reg_user.php?id=' . $results->data[$i]['id'] . '"><span class="glyphicon glyphicon-edit"></span></a>';
                print "</td>";
                 print "<td>" . $results->data[$i]['nick'] . "</td>";
                 print "<td>" . $results->data[$i]['name'] . "</td>";
                 print "<td>";
                 $country =  ($results->data[$i]['country'] == 1) ? "United States" : $results->data[$i]['country'];
                 print $country . "</td>";
                 print "<td><a href='mailto:"  . $results->data[$i]['email'] . "'>" . $results->data[$i]['email'] . "</a></td>";
                 print "<td>";
                 print '<a class="btn btn-warning btn-xs delbutton" title="Suspend User" data-id="' . $results->data[$i]['id'] . '"><span class="glyphicon glyphicon-flag"></span></a>';

                 print "</td>";

                    print "<td>";
                 print '<a class="btn btn-danger btn-xs delbutton" data-id="' . $results->data[$i]['id'] . '"><span class="glyphicon glyphicon-trash"></span></a>';

                 print "</td>";
                 print "</tr>";
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
    header("Location:index.php");
}

?>