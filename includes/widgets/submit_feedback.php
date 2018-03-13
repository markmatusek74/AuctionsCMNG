<!-- BEGIN - Share Auction Modal Window -->
<div id="mdlSubmitFeedback" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="frmSubmitFeedback" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Submit Feedback</h4>
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
                        <label for="yourName" class="col-sm-4 control-label text-right">Your name</label>
                        <div class="col-sm-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="yourName" placeholder="Name" class="form-control" autofocus="" type="text" data-error="Please enter your name" required  />
                            </div>
                            <div class="help-block with-errors"></div>

                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="yourEmail" class="col-sm-4 control-label text-right">Your e-mail</label>
                        <div class="col-sm-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input name="yourEmail" placeholder="E-Mail Address" class="form-control" autofocus="" type="email" data-error="Please enter your email address" required  />
                            </div>
                            <div class="help-block with-errors"></div>

                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="comments" class="col-sm-4 control-label text-right">Add a comment</label>
                        <div class="col-sm-8 inputGroupContainer">
                            <textarea name="comments" placeholder="Add a comment" class="form-control" rows=5></textarea>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-11">
                            <div id="dspSubFeedStatus" class="throw_error text-danger small" style="display: none;"></div>
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

    $('#mdlSubmitFeedback').on('show.bs.modal', function(){

        $('#frmSubmitFeedback')[0].reset();
        $('#frmSubmitFeedback .throw_error').removeClass('throw_error');
        $('#frmSubmitFeedback .help-block').remove();
        $("#dspSubFeedStatus").hide();
    });

    $('#frmSubmitFeedback').submit(function(e){
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
