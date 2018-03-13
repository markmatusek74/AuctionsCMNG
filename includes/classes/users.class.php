<?php

class users {

    public $Admin_Users;
    public $ID;
    public $Username;
    public $Password;
    public $Name;
    public $Address;
    public $City;
    public $State;
    public $Country;
    public $Zip;
    public $Phone;
    public $Email;
    public $Registration_Date;
    public $Rate_Summary;
    public $Rate_Number;
    public $Birthday;
    public $Suspended;
    public $Newsletter;
    public $Balance;
    public $Auction_Watch;
    public $Item_Watch;



    private $DB_Conn;

    function __construct()
    {
        $this->DB_Conn = self::connnectToDB();
        self::getTotalAdminUsers();
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


    public function getTotalAdminUsers()
    {
        $sql = "SELECT COUNT(*) num_users FROM `PHPAUCTIONPROPLUS_users`";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->Admin_Users = $row["num_users"];
        }
    }

    public function getUsernamePasswordFromDB()
    {
        $sql = "SELECT id, nick as 'username', password FROM PHPAUCTIONPROPLUS_users where nick = '" . $this->Username . "'";
      //  print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrUsers = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrUsers[$counter]["id"] = $row["id"];
            $arrUsers[$counter]["username"] = $row["username"];
            $arrUsers[$counter]["password"] = $row["password"];
            $counter++;
        }
        return $arrUsers;

    }

    public function checkForUsernameByEmail()
    {
        $sql = "SELECT id, nick as 'username', email FROM PHPAUCTIONPROPLUS_users where email = '" . $this->Email . "'";
        //  print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrUsers = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrUsers[$counter]["id"] = $row["id"];
            $arrUsers[$counter]["username"] = $row["username"];
            $arrUsers[$counter]["email"] = $row["email"];
            $counter++;
        }
        return $arrUsers;

    }

    public function updatePasswordForUser()
    {
        $sql = "UPDATE PHPAUCTIONPROPLUS_users SET password = '" . $this->Password . "' where id = '" . $this->ID . "'";
        //  print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        return $result;

    }

    public function getUserInfoByID()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_users where id = '" . $this->ID . "';";
       // print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->ID = $row["id"];
            $this->Username = $row["nick"];
            $this->Name = $row["name"];
            $this->Address = $row["address"];
            $this->City = $row["city"];
            $this->State = $row["prov"];
            $this->Zip = $row["zip"];
            $this->Phone = $row["phone"];
            $this->Email = $row["email"];
            $this->Country = $row["country"];
            $this->Birthday = $row["birthdate"];

        }
    }

    public function createNewUser()
    {
        $sql = "INSERT INTO PHPAUCTIONPROPLUS_users
                (
                    id, nick, password, name, address, city, prov,
                    country, zip, phone, email, reg_date,
                    rate_sum, rate_num, birthdate, suspended, nletter,
                    balance, auc_watch, item_watch
                )
                VALUES
                (
                    '" . $this->ID . "','" . $this->Username . "','" . $this->Password . "','" . $this->Name . "','" . $this->Address . "','" . $this->City . "','" . $this->State . "',
                    '" . $this->Country . "','" . $this->Zip . "','" . $this->Phone . "','" . $this->Email . "','" . $this->Registration_Date . "',
                    '" . $this->Rate_Summary . "','" . $this->Rate_Number . "','" . $this->Birthday . "','" . $this->Suspended . "','" . $this->Newsletter . "',
                    '" . $this->Balance . "','" . $this->Auction_Watch . "','" . $this->Item_Watch . "'
                )";
//        print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        return $result;

    }
    public function UpdateUserInfo()
    {
        $sql = "UPDATE PHPAUCTIONPROPLUS_users
                SET
                    nick= '" . $this->Username . "', password = '" . $this->Password . "', name = '" . $this->Name . "', address = '" . $this->Address . "',
                    city = '" . $this->City . "', prov = '" . $this->State . "', country = '" . $this->Country . "', zip = '" . $this->Zip . "', phone = '" . $this->Phone . "',
                    email = '" . $this->Email . "', birthdate = '" . $this->Birthday . "'
                WHERE id = '" . $this->ID . "'
                ";
        //print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        return $result;

    }

}