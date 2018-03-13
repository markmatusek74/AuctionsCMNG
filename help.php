<?php
session_start();

$basePath =  str_replace("help.php","",$_SERVER["SCRIPT_FILENAME"]);
//print_r($_SERVER);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once($basePath . "includes/header.php");
$topic = urldecode($_GET["topic"]);
$hlp->getHelpTopic($topic);
?>

<br clear="all" />
<br clear="all" />
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="http://67.227.134.122/~todayswheels/ldn_new_site/">Home</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9">

                <h1 class="page-header text-center"><?php echo $hlp->HelpTopic ?></h1>
                <div>
                    <?php echo stripslashes($hlp->HelpText); ?>
                </div>
            </div>
            <?php
                require_once("includes/right_rail.php");

            ?>
        </div>
    </div>
</div> <!-- /container -->

<?php require_once($basePath . "includes/footer.php"); ?>
