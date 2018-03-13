<?php

class adminUsers {

    public $ID;
    public $Username;
    public $Password;
    public $CreateDate;
    public $LastLogin;
    public $Status;

    private $DB_Conn;

    function __construct()
    {
        $this->DB_Conn = self::connnectToDB();
    }

    public  function connnectToDB()
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


    public function getAdminUsersSQL()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_adminusers
                ORDER BY username";
        return $sql;

    }

    public function getAdminUsers()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_adminusers
                ORDER BY username";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrHelp = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrHelp[$counter]["id"] = $row["id"];
            $arrHelp[$counter]["username"] = $row["username"];
            $arrHelp[$counter]["password"] = $row["password"];
            $arrHelp[$counter]["createDate"] = $row["created"];
            $arrHelp[$counter]["lastLogin"] = $row["lastlogin"];
            $arrHelp[$counter]["status"] = $row["status"];
            $counter++;
        }
        return $arrHelp;

    }

    public function getAdminUser($username)
    {
        //
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_adminusers
                    WHERE username='" . $username . "';";
        //print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->ID = $row["id"];
            $this->Username = $row["username"];
            $this->Password = $row["password"];
            $this->CreateDate = $row["created"];
            $this->LastLogin = $row["lastlogin"];
            $this->Status = $row["status"];
        }

    }


    public function updateAdminUser()
    {
        //
        $sql = "UPDATE  PHPAUCTIONPROPLUS_adminusers
                SET 
                    username = '" . trim($this->Username) . "', 
                    password = '" . trim($this->Password) . "'                    
                    WHERE id=" . $this->ID . ";";
//        print $sql . "\n";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
       // print_r($result);
        return $result;

    }
    public function deleteAdminUser()
    {
        //
        $sql = "DELETE FROM PHPAUCTIONPROPLUS_adminusers
                WHERE id='" . $this->ID . "';";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        return $result;

    }

    /* SELECT MIN( bid ) AS Min_Bid, MAX( bid ) AS Max_Bid, COUNT( id ) Num_Bids, auction
FROM `PHPAUCTIONPROPLUS_bids`
WHERE auction =2137
GROUP BY auction */


}