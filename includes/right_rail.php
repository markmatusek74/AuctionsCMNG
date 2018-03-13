<?php
    $currentPage = strtolower(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));

    switch($currentPage)
    {
        case "index":
            echo "<div class=\"col-sm-2\">";
            require_once($basePath . "includes/widgets/login_widget.php");
            require_once($basePath . "includes/widgets/auction_info.php");
            require_once($basePath . "includes/widgets/help_topicswidget.php");
            echo "</div>";
            break;
        case "categories":
        case "edit_profile":
        case "my_bids":
            echo "<div class=\"col-sm-3\">";
            require_once($basePath . "includes/widgets/highest_bid_items.php");
            require_once($basePath . "includes/widgets/login_widget.php");
            require_once($basePath . "includes/widgets/help_topicswidget.php");
            echo "</div>";
            break;
        case "help":
            echo "<div class=\"col-sm-3\">";
            require_once($basePath . "includes/widgets/help_topicswidget.php");
            require_once($basePath . "includes/widgets/highest_bid_items.php");
            echo "</div>";
            break;

    }

?>

