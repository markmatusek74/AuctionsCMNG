<footer class="text-center">
    <div class="row">
        <div class="col-md-12 bg-bright-blue">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <form action="#" method="post">
                        <div class="col-md-6 text-right">
                            <label>Sign up for the latest auction news</label>
                        </div>
                        <div class="col-md-3 text-left">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="EMAIL ADDRESS" name="fcEmail" id="fcEmail">
                                <div class="input-group-btn">
                                    <input id="btnSubscribeEmail" class="btn btn-success" type="submit" value="SUBCRIBE" />
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                    <div class="row">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-md-2 text-left">
            <?php require_once($basePath . "includes/widgets/footer_featured_auctions.php"); ?>
        </div>
        <div class=" col-md-offset-1 col-md-2 text-left">
            <?php require_once($basePath . "includes/widgets/footer_account_help.php"); ?>
        </div>
        <div class=" col-md-offset-1 col-md-2 text-left">
            <?php require_once($basePath . "includes/widgets/footer_contact_us.php"); ?>
        </div>
    </div>
</footer>
<script  type="text/javascript" src="<?php echo BASE_URL; ?>/js/page_scripts.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        setInterval('updateClock()', 1000);
    });

    function updateClock (){

        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var currentTime = new Date ( );
        var currentMonth = currentTime.getMonth();
        var currentDay = currentTime.getDate();
        var currentYear = currentTime.getFullYear();
        var currentHours = currentTime.getHours ( );
        var currentMinutes = currentTime.getMinutes ( );
        var currentSeconds = currentTime.getSeconds ( );

        // Pad the minutes and seconds with leading zeros, if required
        currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
        currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
        currentDay = ( currentDay < 10 ? "0" : "" ) + currentDay;
        // Choose either "AM" or "PM" as appropriate
        var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
        var dayName = days[currentTime.getDay()];

        // Convert the hours component to 12-hour format if needed
        currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

        // Convert an hours component of "0" to "12"
        currentHours = ( currentHours == 0 ) ? 12 : currentHours;

        // Compose the string for display
        var currentTimeString = monthNames[currentMonth] + " " + currentDay + ", " + currentYear + " "  + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;


        $("#clock").html(currentTimeString);
    }
</script>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo BASE_URL; ?>js/ie10-viewport-bug-workaround.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="birthdate"]'); //our date input has the name "date"
        var container=$('#regForm form').length>0 ? $('#regForm form').parent() : "body";
        date_input.datepicker({
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true
        })
    })
</script>
</body>
</html>
