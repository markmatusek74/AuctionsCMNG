<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */


class AdminLogin
{

    public $ID;
    public $Username;
    public $Password;
    public $Created;
    public $LastLogin;
    public $Status;

    private $DB_Conn;

    function __construct()
    {
        $this->DB_Conn = self::connnectToDB();
    }

    public function connnectToDB()
    {
        $mysqli = new mysqli("DB2.ludington.com", "wwwldn_ldndb", "ldn01pass2");
        $mysqli->select_db("wwwldn_phpauctionpro_beta2017");
        if ($mysqli->errno) {
            printf("Unable to connect to database:</br /> %s", $mysqli->error);
            exit();
        }
        //print_r($mysqli);
        return $mysqli;

    }


    public function checkAdminUserLoginInfo($username, $password)
    {
        $lastID = 0;
        $sql = "SELECT id FROM PHPAUCTIONPROPLUS_adminusers WHERE username='" . $username . "' AND password = '" . $password . "'  LIMIT 1";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while ($row = $result->fetch_assoc()) {
            $lastID = (int)$row['id'];
        //    $this->ID = $lastID;
          //  self::updateLastLoginInfo();

        }
        return $lastID;
    }

    public function getAdminUserInfo()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_adminusers WHERE id='" . $this->ID . "'";
        // print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while ($row = $result->fetch_assoc()) {
            $this->ID = $row["id"];
            $this->Username = $row["username"];
            $this->Password = $row["password"];
            $this->Created = $row["created"];
            $this->LastLogin = $row["lastlogin"];
            $this->Status = $row["status"];
        }
    }

    public function getUserData($RecordId = NULL)
    {
        if ($RecordId) {
            $qWhere = " WHERE id = '" . $RecordId . "' ";
        }
        $conn = $this->db;
        $sql = "SELECT id, user_id, first_name, last_name, email_address, organization_name, create_date, ip_address
                FROM chr_users $qWhere ORDER BY last_name, first_name, email_address";
        $result = $conn->query($sql) or die(mysqli_error());
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
            $chrItem[$counter]["id"] = $row['id'];
            $chrItem[$counter]["UserID"] = $row['user_id'];
            $chrItem[$counter]["FirstName"] = $row['first_name'];
            $chrItem[$counter]["LastName"] = $row['last_name'];
            $chrItem[$counter]["EmailAddress"] = $row['email_address'];
            $chrItem[$counter]["OrganizationName"] = $row['organization_name'];

            $sql = "UPDATE  PHPAUCTIONPROPLUS_adminusers
                    SET 
                        lastlogin = '" . date("YmdHis") . "'
                        WHERE id=" . $this->ID . ";";
            $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        }
    }

}