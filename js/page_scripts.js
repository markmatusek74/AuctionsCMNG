

$("#lnkSignOut,#mnuSignout").click(function(e)
{
    $.ajax({
        url: 'http://67.227.134.122/~todayswheels/ldn_new_site/includes/widgets/ajax_logout.php',
        context: document.body,
        dataType: 'json',
        success   : function(data) {
            if (!data.success) { //If fails
            }
            else {
                location.reload();
            }
        }
    });
    return false;


});

$('#mnulogin_form').submit(function(e){

    var postForm = { //Fetch form data
        'username'     : $('input[name=mnuUsername]').val(), //Store name fields value
        'password'     : $('input[name=mnuPassword]').val() //Store name fields value
    };
//do some verification
    $.ajax({
        type: 'POST',
        url: 'http://67.227.134.122/~todayswheels/ldn_new_site/includes/widgets/ajax_login.php',
        data: postForm,
        dataType: 'json',
        success   : function(data) {
            if (!data.success) { //If fails
                var failMsgs = "";
                if (data.errors.username) { //Returned if any error from process.php
                    failMsgs = data.errors.username + "<br />"; //Throw relevant error
                }
                if (data.errors.password) { //Returned if any error from process.php
                    failMsgs = failMsgs +data.errors.password + "<br />"; //Throw relevant error
                }
                if (data.errors.un_check) { //Returned if any error from process.php
                    failMsgs = failMsgs +data.errors.un_check + "<br />"; //Throw relevant error
                }
                if (data.errors.pwd_check) { //Returned if any error from process.php
                    failMsgs = failMsgs +data.errors.pwd_check + "<br />"; //Throw relevant error
                }
                $('.throw_error').fadeIn(1000).html(failMsgs); //Throw relevant error

                //   $('#loginStatus').fadeIn(1000).append('<p>' + data.errors + '</p>'); //If successful, than throw a success message
            }
            else {
                location.reload();
            }
        }
    });
    e.preventDefault(); //Prevent the default submit
});
