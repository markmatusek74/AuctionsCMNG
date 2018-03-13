<?php
session_start();
$currSection = "news";
require_once("includes/header.php");
require_once("includes/config.inc.php");
require_once("../includes/classes/Paginator.class.php");
require_once("../includes/classes/news.class.php");

if ($_GET["id"])
{
    $news = new news($_GET["id"]);

}
else
{
    $news = new news();

}
if(isset($_SESSION['user']))   // Checking whether the session is already there or not if
    // true then header redirect it to the home page directly
{

    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    $query = $news->GetItemsSQL;
//print $query . "<br />";
    $Paginator  = new Paginator( $dbConn, $news->GetItemsSQL );

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
         <h4 class="text-center">News Information</h4>
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
                 $retrieved = $results->data[$i]["new_date"];
                 $date = DateTime::createFromFormat('Ydm', $retrieved);

                 ?>
                     <?php
                         print "<tr>";
                    print '<td>';
                    print '<a class="edit-news-item btn btn-success btn-xs" data-toggle="modal" data-id="' . $results->data[$i]['id'] . '" data-title="' . $results->data[$i]["title"] . '" data-date="' . $date->format('m/d/Y') . '"  title="Edit this item" href="#newsModal"><span class="glyphicon glyphicon-edit"></span></a>';
                print "</td>";

                         print "<td>" . $date->format('m/d/Y') . "</td>";
                        print "<td>";
                       //  print "<a href=\"" .  BASE_URL. "/admin/news.php?id=" . $results->data[$i]['id'] ."\">";
                         print $results->data[$i]['title'] . "<br />";
                         //print "</a>";
                         print "</td>";
                         print "<td>" . substr(strip_tags($results->data[$i]["content"]),0,100) . "</td>";
                     print "<td>";
                    print '<a class="btn btn-danger btn-xs delbutton" data-id="' . $results->data[$i]['id'] . '" data-title="' . $results->data[$i]['title'] . '"><span class="glyphicon glyphicon-trash"></span></a>';
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
    <div id="newsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <form name="editNews" id="editNews" role="form">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit News Item</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-sm-3 text-right">
                                <label class="vcenter" for="newsDate">Date:</label>
                            </div>
                            <div class="col-sm-9">
                                <input name="newsDate" type="text" class="form-control datepicker"  value="<?php echo $date->format('m/d/Y'); ?>" required />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3 text-right">
                                <label class="vcenter" for="newsTitle">Title:</label>
                            </div>
                            <div class="col-sm-9">
                                <input id="newsTitle" name="newsTitle" type="text" class="form-control"  value="<?php echo $results->data[$i]['title']; ?>" required />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3 text-right">
                                <label class="vcenter" for="newsContent">Content:</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="newsContent" rows=10 class="form-control"><?php echo $results->data[$i]["content"]; ?></textarea>
                                <input id="newsId" name="newsId" type="hidden" class="form-control" />

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-white">
                        <div class="text-center">

                            <input type="submit" class="btn btn-success" value="Update" />
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BASE_URL;?>/js/bootstrap-datepicker.js" charset="UTF-8"></script>
    <script type="text/javascript">


        $(document).on("click", ".edit-news-item", function () {

            var myDate = $(this).data('date');
            var myTitle = $(this).data('title');
            var myContent = $(this).data('content');

            var newsID = $(this).data('id');
            var postAuctForm = { //Fetch form data
                'id'     : newsID

            };

            $(".modal-body input[name=newsDate").val( myDate );
        //    $(".modal-body #newsTitle").val(myTitle);
          //  $(".modal-body textarea[name=newsContent]").val(myContent);


            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL;?>admin/includes/ajax/get_news_item.php',
                data: postAuctForm,
                dataType: 'json',
                success   : function(data) {
                    if (!data.success) { //If fails
                        var failMsgs = "";
                        if (data.errors.yourName) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.yourName + "<br />"; //Throw relevant error
                        }
                        if (data.errors.yourEmail) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.yourEmail + "<br />"; //Throw relevant error
                        }
                        if (data.errors.comments) { //Returned if any error from process.php
                            failMsgs = failMsgs +data.errors.comments + "<br />"; //Throw relevant error
                        }
                        $('.throw_error').fadeIn(1000).html(failMsgs); //Throw relevant error

                        //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                    }
                    else {
                        // Set the values for the modal window input fields.
                        $("input[name=newsTitle]").val(data.title);
                        $("textarea[name=newsContent]").html(data.content);
                        $("input[name=newsId").val(data.id);
                        tinyMCE.activeEditor.setContent(data.content);
                        return false;
                        //   location.reload();
                    }
                }
            });

        });

        $(document).on('click','.delbutton',function(){
            var del_id = $(this).data('id');
            var del_title = $(this).data('title');
            var element = $(this);
            var info = 'id=' + del_id;
            if(confirm("Are you sure you want to news item '" + del_title + "'?")){
                $.ajax({
                    type: "GET",
                    url: '<?php echo BASE_URL;?>/admin/includes/ajax/delete_news_item.php',
                    data: info,
                    success: function(){
                        location.reload();
                    }
                });
            }
            return false;
        });

        $('#editNews').submit(function(e){



            var postForm = { //Fetch form data
                'newsId'     : $('input[name=newsId]').val(), //Store name fields value
                'newsDate' : $('input[name=newsDate').val(),
                'newsTitle'     : $('input[name=newsTitle]').val(),
                'newsContent' :  $('input[name=newsContent]').val()
            };
//do some verification
            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL;?>/admin/includes/ajax/update_news_item.php',
                data: $("#editNews").serialize(),
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

                        location.reload();
                        return false;
                        //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                    }
                    else {

                        window.setTimeout(function() {
                           // alert(ed.getContent());
                            $('#editNews').modal('hide');
                            $(this).removeData('bs.modal');
                        }, 3000);
                       // $('#msgBidNow').fadeIn(1000).html("Bid Placed Successfully"); //Throw relevant error

                        location.reload();
                        return false;
                    }
                }
            });
            e.preventDefault(); //Prevent the default submit
        });

    </script>

<?php
}
else
{
    header("Location:index.php");
}

?>