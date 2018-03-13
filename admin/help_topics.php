<?php
session_start();
$currSection = "help_topics";
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
    $query = $help->HelpTopicsSQL;
//print $query . "<br />";
    $Paginator  = new Paginator( $dbConn, $help->HelpTopicsSQL );

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
         <h4 class="text-center">Help Topics</h4>
     </div>
</div>
<div class="row">
    <div class="col-md-12 ">

         <?php echo $results->total . " total news items found, showing " .  $startRec . " - " . $endRec . " <br />"; ?>
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
                    <th>Date</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th></th>
                </tr>
             <?php
             for( $i = 0; $i < count( $results->data ); $i++ )
             {

                 ?>
                     <?php
                         print "<tr>";
                        print '<td>';
                        print '<a class="btn btn-success btn-xs edit-help-topic" data-toggle="modal" data-id="'. $results->data[$i]['topic'] .'" title="" href="#mdlHelpDetails"><span class="glyphicon glyphicon-edit"></span></a>';
                        //print '<a class="open-AddBookDialog btn btn-success btn-xs" data-toggle="modal" data-id="' . $results->data[$i]['topic'] . '"  title="Edit this item" href="#editModal"><span class="glyphicon glyphicon-edit"></span></a>';
                        print "</td>";

                        print "<td>";
                         print '<a class="edit-help-topic" data-toggle="modal" data-id="'. $results->data[$i]['topic'] .'" title="" href="#mdlHelpDetails">';
//                         print "<a href=\"" .  BASE_URL. "/admin/help_topics.php?id=" . $results->data[$i]['topic'] ."\">";
                         print $results->data[$i]['topic'] . "<br />";
                         print "</a>";
                         print "</td>";
                         print "<td>" . substr(strip_tags($results->data[$i]["helptext"]),0,100) . "</td>";
                     print "<td>";
                     print '<a class="btn btn-danger btn-xs delbutton" data-id="' . $results->data[$i]['topic'] . '" data-title="' . $results->data[$i]['topic'] . '"><span class="glyphicon glyphicon-trash"></span></a>';

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
    require_once("includes/widgets/help_topics_details.php");

}
else
{
    header("Location:index.php");
}

?>