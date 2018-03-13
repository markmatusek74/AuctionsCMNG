<?php

class news {

    public $ID;
    public $Title;
    public $Content;
    public $NewsDate;
    public $Suspended;
    public $GetItemsSQL;
    private $DB_Conn;

    function __construct($id=null)
    {
        if (!empty($id))
        {
            $this->DB_Conn = self::connnectToDB();
            self::getNewsTopic($id);
        }
        else
        {
            $this->GetItemsSQL = self::getNewsItems();
        }

    }
    private function connnectToDB()
    {
        $mysqli = new mysqli("DB2.ludington.com", "wwwldn_ldndb", "ldn01pass2");
        $mysqli->select_db("wwwldn_phpauctionpro");
        if($mysqli->errno)
        {
            printf("Unable to connect to database:</br /> %s", $mysqli->error);
            exit();
        }
        //print_r($mysqli);
        return $mysqli;

    }

    private function getNewsItems()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_news
                ORDER BY new_date";
        return $sql;
    }

    private function getNewsTopic($id)
    {
        //
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_news
                    WHERE id='" . $id . "';";
     //   print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->ID = $row["id"];
            $this->Title = $row["title"];
            $this->Content = $row["content"];
            $this->NewsDate = $row["new_date"];
            $this->Suspended = $row["suspended"];
        }

    }

    public function updateNewsTopic()
    {
        $sql = "UPDATE PHPAUCTIONPROPLUS_news SET title = '" . addslashes($this->Title) . "' 
                , content = '" . addslashes($this->Content) . "' , new_date = '" . $this->NewsDate . "' 
                WHERE id = '" . $this->ID . "'";
       // print $sql . "\n";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
    }

    public function deleteNewsTopic()
    {
        $sql = "DELETE FROM  PHPAUCTIONPROPLUS_news  
                WHERE id = '" . $this->ID . "'";
        // print $sql . "\n";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        return $result;
       // print_r($result);
    }


    /* SELECT MIN( bid ) AS Min_Bid, MAX( bid ) AS Max_Bid, COUNT( id ) Num_Bids, auction
FROM `PHPAUCTIONPROPLUS_bids`
WHERE auction =2137
GROUP BY auction */


}