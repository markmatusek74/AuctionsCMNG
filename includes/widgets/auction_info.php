<?php

$arrTopics = $hlp->getHelpTopics();

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Auction Info</h3>
            </div>
            <div class="panel-body">
                <?php
                print "<strong>" . $auc->Active_Auctions . "</strong> Total Auctions<br />";
                print "<strong>" . $users->Admin_Users . "</strong> Total Users";//print_r($arrCats);
                ?>

            </div>
        </div>

    </div>
</div>
