<?php
session_start();
$currSection = "home";

if(isset($_SESSION['user']))   // Checking whether the session is already there or not if
    // true then header redirect it to the home page directly
{
    require_once("includes/header.php");
 //   echo "Logged in as: " .$_SESSION['user'];

?>
 <div class="row">
     <div class="col-md-3 col-md-offset-1">
         <h4 class="text-center">User Information</h4>
         <table class="table table-bordered table-responsive table-striped">
             <tr>
                 <td>Active Users</td>
                 <td>217</td>
             </tr>
             <tr>
                 <td>Inactive Users</td>
                 <td>2</td>
             </tr>
             <tr>
                 <td>Registered Users</td>
                 <td>219</td>
             </tr>
         </table>

     </div>
     <div class="col-md-5 col-md-offset-1">
         <h4 class="text-center">Auction Information</h4>
         <table class="table table-bordered table-responsive table-striped">
             <tr>
                 <th>Description</th>
                 <th># of Auctions </th>
                 <th># of Bids</th>
             </tr>
             <tr>
                 <td>Active Auctions</td>
                 <td>71</td>
                 <td>249</td>
             </tr>
             <tr>
                 <td>Closed Auctions</td>
                 <td>29</td>
                 <td>158</td>
             </tr>
         </table>
     </div>
 </div>
<?php
}
else
{
    header("Location:index.php");
}

?>