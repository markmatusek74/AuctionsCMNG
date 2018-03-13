<!-- BEGIN - Share Auction Modal Window -->
<script src='<?php echo BASE_URL;?>js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: 'textarea',
        force_br_newlines : false,
        force_p_newlines : false,
        forced_root_block : ''
    });
</script>
<div id="mdlHelpDetails" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="frmEditHelp" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Help Topic</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-sm-12 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="helpTopic" placeholder="Help Topic" class="form-control" autofocus="" type="text" data-error="Please enter a Help Topic" required  />
                            </div>
                            <div class="help-block with-errors"></div>

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12 inputGroupContainer">
                            <textarea name="helpText" placeholder="Add a Description" class="form-control" rows=30 style="width: 100% !important;"></textarea>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-11">
                            <div id="dspHelpStatus" class="throw_error text-danger small" style="display: none;"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-white">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" value="Update Topic" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>


                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END - Share Auction Modal Window -->


<script type="text/javascript">
    $(document).on("click", ".edit-help-topic", function () {
        var helpTopic = $(this).data('id');
        var postAuctForm = { //Fetch form data
            'topic'     : helpTopic,
            'text': 'help text'

        };
        //$(".modal-body #hdnAuctionID").val( auctionID );

        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>admin/includes/ajax/get_help_topic.php',
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
                    $("input[name=helpTopic]").val(data.topic);
                    $("textarea[name=helpText]").html(data.text);
                    tinyMCE.activeEditor.setContent(data.text);
                    return false;
                    //   location.reload();
                }
            }
        });
       // e.preventDefault(); //Prevent the default submit

    });

    $(document).on('click','.delbutton',function(){
        var del_id = $(this).data('id');
        var del_title = $(this).data('title');
        var element = $(this);
        var info = 'id=' + del_id;
        if(confirm("Are you sure you want to news item '" + del_title + "'?")){
            $.ajax({
                type: "GET",
                url: '<?php echo BASE_URL;?>/admin/includes/ajax/delete_help_topic.php',
                data: info,
                success: function(){
                    location.reload();
                }
            });
        }
        return false;
    });
    $('#mdlHelpDetails').on('show.bs.modal', function(){

        $('#frmEditHelp')[0].reset();
        $('#frmEditHelp .throw_error').removeClass('throw_error');
        $('#frmEditHelp .help-block').remove();
        $("#dspHelpStatus").hide();
    });

    $('#frmEditHelp').submit(function(e){

        var postForm = { //Fetch form data
            'topic'     : $('input[name=helpTopic]').val(),
            'text'     : tinyMCE.activeEditor.getContent()
        };
//do some verification
        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>admin/includes/ajax/update_help_topic.php',
            data: postForm,
            dataType: 'json',
            success   : function(data) {
                if (!data.success) { //If fails
                    var failMsgs = "";
                    if (data.errors.helpText) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.helpText + "<br />"; //Throw relevant error
                    }
                    if (data.errors.helpTopic) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.helpTopic + "<br />"; //Throw relevant error
                    }
                    $('.throw_error').fadeIn(1000).html(failMsgs); //Throw relevant error

                    //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                    location.reload();
                }
                else {
                    $('.throw_error').fadeIn(1000).html("Help Topic Saved"); //Throw relevant error
                    setTimeout(function(){
                        $('#mdlHelpDetails').modal('hide');
                        $(this).removeData('bs.modal');
                    },1000);
                    location.reload();
                    return false;

                }
            }
        });
        e.preventDefault(); //Prevent the default submit
    });
</script>
