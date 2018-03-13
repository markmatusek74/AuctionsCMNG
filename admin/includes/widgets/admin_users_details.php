<!-- BEGIN - Share Auction Modal Window -->
<div id="mdlAdminUserDetails" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="frmEditAdminUser" role="form">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Admin User</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-sm-12 inputGroupContainer">
                            <div id="saveSuccess" class="alert alert-success">Admin User was successfully saved.</div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="frmUsername" placeholder="Username" class="form-control" autofocus="" type="text" data-error="Please enter a Help Topic" required  />
                            </div>
                            <div class="help-block with-errors"></div>

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input name="frmPassword" placeholder="Enter a password" class="form-control" autofocus="" type="password" data-error="Please enter a password" required  />
                            </div>
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
                        <input type="hidden" name="hdnID" />
                        <input type="submit" class="btn btn-success" value="Update User" />
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>


                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END - Share Auction Modal Window -->


<script type="text/javascript">
    $(document).on("click", ".edit-admin-user", function () {
        var adminID = $(this).data('id');
        var postAuctForm = { //Fetch form data
            'id'     : adminID

        };
        //$(".modal-body #hdnAuctionID").val( auctionID );

        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>admin/includes/ajax/get_admin_user.php',
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
                    $("input[name=hdnID").val(adminID);
                    $("input[name=frmUsername]").val(data.username);
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
        if(confirm("Are you sure you want to admin user '" + del_title + "'?")){
            $.ajax({
                type: "GET",
                url: '<?php echo BASE_URL;?>admin/includes/ajax/delete_admin_user.php',
                data: info,
                success: function(){
                    location.reload();
                }
            });
        }
        return false;
    });


    $('#mdlAdminUserDetails').on('show.bs.modal', function(){

        $('#frmEditAdminUser')[0].reset();
        $('#frmEditAdminUser .throw_error').removeClass('throw_error');
        $('#frmEditAdminUser .help-block').remove();
        $("#dspHelpStatus").hide();
        $('#saveSuccess').addClass("hidden");

    });



    $('#frmEditAdminUser').submit(function(e){
        var postForm = { //Fetch form data
            'id'           : $('input[name=hdnID').val(),
            'username'     : $('input[name=frmUsername]').val(),
            'password'     : $('input[name=frmPassword]').val()
        };
//do some verification
        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL;?>admin/includes/ajax/update_admin_user.php',
            data: postForm,
            dataType: 'json',
            success   : function(data) {
                if (!data.success) { //If fails
                    var failMsgs = "";
                    if (data.errors.username) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.username + "<br />"; //Throw relevant error
                    }
                    if (data.errors.password) { //Returned if any error from process.php
                        failMsgs = failMsgs +data.errors.password + "<br />"; //Throw relevant error
                    }
                    $('.throw_error').fadeIn(1000).html(failMsgs); //Throw relevant error

                    //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
                }
                else {
                    $('#saveSuccess').removeClass("hidden");
                    setTimeout(function(){
                        $('#mdlAdminUserDetails').modal('hide');
                        $(this).removeData('bs.modal');
                    },3000);
                    return false;
                    //   location.reload();
                }
            }
        });
        e.preventDefault(); //Prevent the default submit
    });
</script>
