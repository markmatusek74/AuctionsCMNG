<?php
$arrTopics = $hlp->getHelpTopics();

?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <h3>Account & Help</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                <?php
                //print_r($arrCats);
                foreach ($arrTopics as $k) {
                    print '<a href="help.php?topic=' . urlencode($k["HelpTopic"]) . '">' . $k["HelpTopic"] . '</a><br />';
                    // $arr[3] will be updated with each value from $arr...

                }
                ?>

            </div>
        </div>
    </div>
</div>
