<?php
$arrCats = $cat->getCategoryList();
?>
<div class="col-sm-3">
    <div class="row">
        <div class="col-sm-12 text-center">

            <div id="clock" style="color: #336699 !important; height: 40px; font-weight: bold;"></div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Browse by Category</h3>
                </div>
                <div class="panel-body">
                    <?php
                    //print_r($arrCats);
                    foreach ($arrCats as $k) {
                        print '<a href="categories.php?id=' . $k["CategoryID"] . '">' . $k["CategoryName"] . ' ('. $k["CategoryCount"] . ')</a><br />';
                        // $arr[3] will be updated with each value from $arr...

                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
