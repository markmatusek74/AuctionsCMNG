<?php

class auctions {

    public $Auction_ID;
    public $User;
    public $Title;
    public $Advertiser;
    public $Starts;
    public $Description;
    public $Picture_URL;
    public $Category;
    public $CategoryID;
    public $Minimum_Bid;
    public $Reserve_Price;
    public $Value;
    public $Buy_Now;
    public $Auction_Type;
    public $Duration;
    public $Increment;
    public $Location;
    public $Location_Zip;
    public $Shipping;
    public $Payment;
    public $International;
    public $Ends;
    public $Begins;
    public $Current_Bid;
    public $Closed;
    public $Photo_Uploaded;
    public $Quantity;
    public $Suspended;
    public $Short_Desc;
    public $Lowest_Bid;
    public $Highest_Bid;
    public $Number_Of_Bids;
    public $Auction_Views;
    public $Country;

    public $Active_Auctions;
    private $DB_Conn;

    function __construct()
    {
        $this->DB_Conn = self::connnectToDB();
        self::getTotalActiveAuctions();
    }

    public  function connnectToDB()
    {
        $mysqli = new mysqli("DB2.ludington.com", "wwwldn_ldndb", "ldn01pass2");
        $mysqli->select_db("wwwldn_phpauctionpro_beta2017");
        if($mysqli->errno)
        {
            printf("Unable to connect to database:</br /> %s", $mysqli->error);
            exit();
        }
        //print_r($mysqli);
        return $mysqli;

    }

    public function getTotalActiveAuctions()
    {
        $sql = "SELECT COUNT(*) auct_count FROM PHPAUCTIONPROPLUS_auctions
                    WHERE closed = 0 ;";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->Active_Auctions = $row["auct_count"];
        }

    }

    public function getFeaturedAuction()
    {
        $sql = "SELECT auc.*, cat.cat_name FROM PHPAUCTIONPROPLUS_auctions auc
                    JOIN PHPAUCTIONPROPLUS_categories cat on cat.cat_id = auc.category
                    WHERE id='2021' ORDER BY RAND() LIMIT 1;";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->Auction_ID = $row["id"];
            $this->Advertiser = $row["advertiser"];
            $this->Title = $row["title"];
            $this->Description = $row["description"];
            $this->Picture_URL =  $row["pict_url"];
            $this->Current_Bid = $row["current_bid"];
            $this->Value = $row["value"];
            $this->Quantity = $row["quantity"];
            $this->Category = $row["cat_name"];
        }

    }

    public function getFeaturedAuctions($numItems)
    {
        $sql = $sql = "SELECT auc.*, cat.cat_name FROM PHPAUCTIONPROPLUS_auctions auc
                    JOIN PHPAUCTIONPROPLUS_categories cat on cat.cat_id = auc.category
                    WHERE pict_url <> '' ORDER BY RAND() LIMIT $numItems;";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrAucts = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrAucts[$counter]["Auction_ID"] = $row["id"];
            $arrAucts[$counter]["Picture_URL"] = $row["pict_url"];
            $arrAucts[$counter]["Title"] = $row["title"];
            $arrAucts[$counter]["Description"] = $row["description"];
            $counter++;
        }
        return $arrAucts;
    }

    public function getAuctionsByCategory($catID)
    {
        $sql = $sql = "SELECT auc.*, cat.cat_name,COUNT(bid.bid) num_bids FROM PHPAUCTIONPROPLUS_auctions auc
                    JOIN PHPAUCTIONPROPLUS_categories cat on cat.cat_id = auc.category
                    left JOIN PHPAUCTIONPROPLUS_bids bid on bid.auction = auc.id
                    WHERE category = '" . $catID . "'
                    GROUP BY auc.ID";
        print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrAucts = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrAucts[$counter]["Auction_ID"] = $row["id"];
            $arrAucts[$counter]["Advertiser"] = $row["advertiser"];
            $arrAucts[$counter]["Title"] = $row["title"];
            $arrAucts[$counter]["Description"] = $row["description"];
            $arrAucts[$counter]["Picture_URL"] = $row["pict_url"];
            $arrAucts[$counter]["Current_Bid"] = $row["current_bid"];
            $arrAucts[$counter]["Value"] = $row["value"];
            $arrAucts[$counter]["Quantity"] = $row["quantity"];
            $arrAucts[$counter]["Closed"] = $row["closed"];
            $arrAucts[$counter]["Category"] = $row["category"];
            $arrAucts[$counter]["Total_Bids"] = $row["num_bids"];

            $counter++;
        }
        return $arrAucts;
    }


    public function getSingleAuctionInfo($id)
    {
        //
        $sql = "SELECT auc.*, cat.cat_name, cat.cat_id, ifNull(MIN(bid.bid),'0.00') Min_Bid, ifNull(MAX(bid.bid),'0.00') Max_Bid,
        (SELECT COUNT(*) FROM PHPAUCTIONPROPLUS_bids bid WHERE bid.auction=auc.id) Num_Bids,
        (SELECT COUNT(*) FROM PHPAUCTIONPROPLUS_auction_views av WHERE av.auction_id = auc.id) Auction_Views
                    FROM PHPAUCTIONPROPLUS_auctions auc
                    JOIN PHPAUCTIONPROPLUS_categories cat on cat.cat_id = auc.category
                    LEFT JOIN PHPAUCTIONPROPLUS_bids bid ON bid.auction = auc.id
                    WHERE auc.id='" . $id . "'
                    GROUP BY auc.id;";
       // print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->Auction_ID = $row["id"];
            $this->Advertiser = $row["advertiser"];
            $this->Title = $row["title"];
            $this->Description = $row["description"];
            $this->Picture_URL =  $row["pict_url"];
            $this->Current_Bid = $row["current_bid"];
            $this->Value = $row["value"];
            $this->Quantity = $row["quantity"];
            $this->Closed = $row["closed"];
            $this->Category = $row["cat_name"];
            $this->CategoryID = $row["cat_id"];
            $this->Lowest_Bid = $row["Min_Bid"];
            $this->Highest_Bid = $row["Max_Bid"];
            $this->Number_Of_Bids = $row["Num_Bids"];
            $this->Increment = $row["increment"];
            $this->Minimum_Bid =  $row["minimum_bid"] ;
            $this->Starts = $row["starts"];
            $this->Ends = $row["ends"];
            $this->Begins = $row["starts"];
            $this->Auction_Views = $row["Auction_Views"];
            $this->Auction_Type = $row["auction_type"];
            $this->Reserve_Price =  $row["reserve_price"] ;
            $this->Duration = $row["duration"];
            $this->Country = 1;  // Hard-coded to United States
            $this->Location_Zip = $row["location_zip"];
        }

    }

    public function editAuctionInfo()
    {

        $sql="UPDATE PHPAUCTIONPROPLUS_auctions
            SET
                title=\"".AddSlashes($title)."\",
                user=\"".AddSlashes($nick)."\",
                starts=\"".AddSlashes($date)."\",
                ends=\"".AddSlashes($FORMATTED_ENDS)."\",
                duration=\"".AddSlashes($duration)."\",
                category=\"".AddSlashes($category)."\",
                description=\"".AddSlashes($description)."\",
                current_bid=\"".AddSlashes($current_bid)."\",
                location=\"".AddSlashes($country)."\",
                quantity=\"".AddSlashes($quantity)."\",
                minimum_bid=\"".AddSlashes($min_bid)."\",
                buy_now=\"".AddSlashes($buy_now)."\",
                reserve_price=\"". AddSlashes($reserve_price)."\"
            WHERE id='".AddSlashes($id)."'";
     //   $result = $this->DB_Conn->query($sql) or die(mysqli_error());
       // return $result;
    }

    public function addAuctionView()
    {
        $sql = "INSERT INTO PHPAUCTIONPROPLUS_auction_views
                (
                    auction_ID, ip_address
                )
                VALUES
                (
                    '" . $this->Auction_ID . "','" . $_SERVER['REMOTE_ADDR'] . "'
                )";
       // print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        return $result;

    }


    public function updateAuction()
    {
        $sql = "UPDATE PHPAUCTIONPROPLUS_auctions 
                  SET title = '" . addslashes($this->Title) . "' 
                    , description  = '" . addslashes($this->Description) . "' 
                    , starts = '" . $this->Starts . "'
                    , ends = '" . $this->Ends . "' 
                    , auction_type = '" . $this->Auction_Type . "' 
                    , quantity = '" . $this->Quantity . "' 
                    , minimum_bid = '" . $this->Minimum_Bid . "' 
                    , reserve_price = '" . $this->Reserve_Price . "' 
                    , increment = '" . $this->Increment . "' 
                    , location_zip = '" . $this->Location_Zip . "'" ;
                 if ($this->Picture_URL <> "") {
                     $sql .= ", pict_url = '" . $this->Picture_URL . "' ";
                 }
                $sql .= "WHERE id = '" . $this->Auction_ID . "'";

        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
       // print_r($result);
       return $result;
    }


}