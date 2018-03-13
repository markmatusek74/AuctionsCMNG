<!-- BEGIN - Share Auction Modal Window -->
<script src='<?php echo BASE_URL;?>js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: '#auctionDescription'
    });
</script><div id="mdlAuctDetails" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="frmEditAuction" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Auction Info</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="hdnAuctionID" id="hdnAuctionID" />
                    <div class="row form-group">
                        <label for="auctionTitle" class="col-sm-4 control-label text-right">Title</label>
                        <div class="col-sm-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="auctionTitle" placeholder="Auction Title" class="form-control" autofocus="" type="text" data-error="Please enter a Title" required  />
                            </div>
                            <div class="help-block with-errors"></div>

                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="auctionDescription" class="col-sm-4 control-label text-right">Add a comment</label>
                        <div class="col-sm-8 inputGroupContainer">
                            <textarea id="auctionDescription" name="auctionDescription" placeholder="Add a Description" class="form-control" rows=5 style="width: 100% !important;"></textarea>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-11">
                            <div id="dspAuctionStatus" class="throw_error text-danger small" style="display: none;"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-white">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" value="Send Feedback" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>


                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END - Share Auction Modal Window -->


<script type="text/javascript">
    $(document).on("click", ".edit-auction", function () {
        var auctionID = $(this).data('id');
        var postAuctForm = { //Fetch form data
            'id'     : auctionID

        };
        $(".modal-body #hdnAuctionID").val( auctionID );

        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>admin/includes/ajax/get_auction.php',
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
                    $("input[name=auctionTitle]").val(data.auctionTitle);
                    $("textarea[name=auctionDescription]").html(data.auctionDescription);
                    tinyMCE.activeEditor.setContent(data.auctionDescription);
                    return false;
                    //   location.reload();
                }
            }
        });
       // e.preventDefault(); //Prevent the default submit

    });


    $('#mdlAuctDetails').on('show.bs.modal', function(){

        $('#frmEditAuction')[0].reset();
        $('#frmEditAuction .throw_error').removeClass('throw_error');
        $('#frmEditAuction .help-block').remove();
        $("#dspAuctionStatus").hide();
    });

    $('#frmEditAuction').submit(function(e){
        var postForm = { //Fetch form data
            'yourName'     : $('input[name=yourName]').val(),
            'yourEmail'     : $('input[name=yourEmail]').val(),
            'comments'     : $('textarea[name=comments]').val()

        };
//do some verification
        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>/includes/widgets/submit_feedback_email.php',
            data: postForm,
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
                    $('.throw_error').fadeIn(1000).html("Email Sent"); //Throw relevant error
                    setTimeout(function(){
                        $('#mdlSubmitFeedback').modal('hide');
                        $(this).removeData('bs.modal');
                    },5000);
                    return false;
                    //   location.reload();
                }
            }
        });
        e.preventDefault(); //Prevent the default submit
    });
</script>
