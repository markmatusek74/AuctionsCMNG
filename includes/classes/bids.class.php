<?php

class bids {

    public $Auction_ID;
    public $Bid_Amount;
    public $Bidder;
    public $Bid_Date;
    public $Bidder_First_Name;
    public $Bid_ID;
    public $Bidder_Last_Name;
    public $Bidder_Phone;
    public $Phone_Bid;
    public $Quantity;

    private $DB_Conn;

    function __construct()
    {
        $this->DB_Conn = self::connnectToDB();
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


    public function getFeaturedRecentBids($bids)
    {
        $sql = "SELECT b.id, b.auction, b.bid, a.id 'Auction_ID', a.title FROM PHPAUCTIONPROPLUS_bids b
                JOIN PHPAUCTIONPROPLUS_auctions a on a.id = b.auction
                GROUP BY a.id
                ORDER BY bidwhen DESC
                LIMIT $bids;";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrBids = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrBids[$counter]["Aucction_ID"] = $row["auction"];
            $arrBids[$counter]["Bid_ID"] = $row["id"];
            $arrBids[$counter]["Auction_ID"] = $row["Auction_ID"];
            $arrBids[$counter]["Bid_Amount"] = $row["bid"];
            $arrBids[$counter]["Auction_Title"] = $row["title"];
            $counter++;
        }
    return $arrBids;
    }

    public function getHighestBidItems($minBid, $items)
    {

//                and a.ends >= '" . date('Ymd') . "'

        $sql = "SELECT b.id, b.auction, MAX(b.bid)  Max_bid ,
                a.id 'Auction_ID', a.title, a.pict_url, a.ends
                FROM  PHPAUCTIONPROPLUS_auctions a
                JOIN PHPAUCTIONPROPLUS_bids b  on a.id = b.auction
                WHERE a.pict_url <> ''

                GROUP BY b.id
                HAVING MAX(b.bid) > $minBid
                ORDER BY RAND()
                LIMIT $items";
       // print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrBids = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrBids[$counter]["Bid_ID"] = $row["id"];
            $arrBids[$counter]["Auction_ID"] = $row["Auction_ID"];
            $arrBids[$counter]["Bid_Amount"] = $row["Max_bid"];
            $arrBids[$counter]["Auction_Title"] = $row["title"];
            $arrBids[$counter]["Auction_Picture"] = $row["pict_url"];
            $arrBids[$counter]["Auction_Ends"] = $row["ends"];
            $counter++;
        }
        return $arrBids;
    }
    public function getAllBidsForAuction()
    {

//                and a.ends >= '" . date('Ymd') . "'

        $sql = "SELECT b . * , u.nick
                FROM PHPAUCTIONPROPLUS_bids b
                JOIN PHPAUCTIONPROPLUS_users u ON u.id = b.bidder
                WHERE b.auction = " . $this->Auction_ID . "
                GROUP BY b.id
                ORDER BY bid DESC
                ";
        // print $sql . "<br />";
        return $sql;
    }

    public function getHighestBidAndBidderForAuction()
    {

//                and a.ends >= '" . date('Ymd') . "'

        $sql = "SELECT b.bidder,  b.bid  Highest_Bid
                FROM PHPAUCTIONPROPLUS_bids b
                WHERE b.auction = '" . $this->Auction_ID . "'
                ORDER BY bid DESC
                LIMIT 1
                ";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrBids = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrBids[$counter]["Bidder"] = $row["bidder"];
            $arrBids[$counter]["Highest_Bid"] = $row["Highest_Bid"];
            $counter++;
        }
        return $arrBids;
    }
    public function getHighestProxyBidAndBidderForAuction()
    {

//                and a.ends >= '" . date('Ymd') . "'
        $sql = "SELECT b.userid,  b.bid Highest_Bid
                FROM PHPAUCTIONPROPLUS_proxybid b
                WHERE b.itemid = '" . $this->Auction_ID . "'
                ORDER BY bid DESC
                LIMIT 1
                ";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrBids = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrBids[$counter]["Bidder"] = $row["userid"];
            $arrBids[$counter]["Highest_Bid"] = $row["Highest_Bid"];
            $counter++;
        }
        return $arrBids;

    }

    public function getUsersBids($userID)
    {
        $sql = "SELECT b.id, b.auction, b.bid, b.bidwhen, a.id 'Auction_ID', a.title, a.ends  FROM PHPAUCTIONPROPLUS_bids b
                JOIN PHPAUCTIONPROPLUS_auctions a on a.id = b.auction
                WHERE bidder = '" . $userID . "'  ORDER BY bidwhen DESC ";
        return $sql;
    }

    public function AddProxyBid()
    {
        $sql = "SELECT proxy_id FROM PHPAUCTIONPROPLUS_proxybid WHERE itemid='" . $this->Auction_ID . "' and userid ='" . $this->Bidder .  "'";
        // print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        //print_r($result);
        //print "num rows: " . $result->num_rows . "<br />";
    }

    public function AddUserBid()
    {
        // Create new bid
        $sql = "INSERT INTO  PHPAUCTIONPROPLUS_bids (auction, bidder, bid) VALUES ('" . $this->Auction_ID . "','" . $this->Bidder .  "','" . $this->Bid_Amount . "')";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());

        // Update bid on the auctions table
        $sql = "UPDATE PHPAUCTIONPROPLUS_auctions SET current_bid = '" . $this->Bid_Amount . "' WHERE id = '" . $this->Auction_ID . "'";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());

    }

}