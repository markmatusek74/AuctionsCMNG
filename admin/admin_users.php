<?php
session_start();
$currSection = "admin_users";
require_once("includes/header.php");
require_once("includes/config.inc.php");
require_once("../includes/classes/Paginator.class.php");
require_once("../includes/classes/help.class.php");

if ($_GET["id"])
{
    $help = new help($_GET["id"]);

}
else
{
    $help = new help();

}
if(isset($_SESSION['user']))   // Checking whether the session is already there or not if
    // true then header redirect it to the home page directly
{

    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    $query = "SELECT * FROM PHPAUCTIONPROPLUS_adminusers";
//print $query . "<br />";
    $Paginator  = new Paginator( $dbConn, $query );

    $results    = $Paginator->getData( $limit, $page );

    $startRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? ($_GET['page']-1)*25 + 1 : 1;
    $endRec = ( isset( $_GET['page'] ) && $_GET["page"] > 1 ) ? $_GET['page']*$limit : $limit;

    if ($endRec > $results->total) { $endRec = $results->total;}
    //   echo "Logged in as: " .$_SESSION['user'];

    /*
     *
     *             $this->ID = $row["id"];
            $this->Title = $row["title"];
            $this->Content = $row["content"];
            $this->NewsDate = $row["new_date"];
            $this->Suspended = $row["suspended"];

     */
?>
 <div class="row">
     <div class="col-md-12 ">
         <h4 class="text-center">Admin Users</h4>
     </div>
</div>
<div class="row">
    <div class="col-md-12 ">

         <?php echo $results->total . " total admin users found, showing " .  $startRec . " - " . $endRec . " <br />"; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 ">

         <?php
            if ($results->total > $limit)
            {
              echo $Paginator->createLinks( $links, 'pagination pagination-sm',$pageName );
            }
         ?>
        <br />
         <table class="table table-responsive table-striped">
                <tr>
                    <th></th>
                    <th>Username</th>
                    <th>Created</th>
                    <th>Last Login</th>
                    <th></th>
                </tr>
             <?php
             for( $i = 0; $i < count( $results->data ); $i++ )
             {

                 ?>
                     <?php
                         print "<tr>";
                        print '<td>';
                        print '<a class="edit-admin-user btn btn-success btn-xs" data-toggle="modal" data-id="' . $results->data[$i]['id'] . '"  title="Edit this item" href="#mdlAdminUserDetails"><span class="glyphicon glyphicon-edit"></span></a>';
                        print "</td>";

                        print "<td>";
                         print "<a href=\"" .  BASE_URL. "/admin/help_topics.php?id=" . $results->data[$i]['id'] ."\">";
                         print $results->data[$i]['username'] . "<br />";
                         print "</a>";
                         print "</td>";
                         $retrieved = $results->data[$i]["created"];
                         $createDate = DateTime::createFromFormat('Ymd', $retrieved);
                         print "<td>" . $createDate->format('m/d/Y') . "</td>";
                         $retrieved = $results->data[$i]["lastlogin"];
                        if ($retrieved != "")
                        {
                         $lastLogin = DateTime::createFromFormat('Ymdhis', $retrieved);
                         print "<td>" . $lastLogin->format("m/d/Y h:i:s A") . "</td>";
                        }
                        else
                        {
                            print "<td>&nbsp;</td>";
                        }
                     print "<td>";
                     print '<a class="btn btn-danger btn-xs delbutton" data-id="' . $results->data[$i]['id'] . '" data-title="' . $results->data[$i]['username'] . '"><span class="glyphicon glyphicon-trash"></span></a>';
                     print "</td>";

                         ?>
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
    require_once("includes/widgets/admin_users_details.php");

}
else
{
    header("Location:index.php");
}

?>