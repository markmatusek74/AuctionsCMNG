<?php

class settings {

    public $SiteName;
    public $SiteURL;
    public $CookiesPrefix;
    public $LoginBox;
    public $NewsBox;
    public $NewsToShow;
    public $MoneyFormat;
    public $MoneyDecimals;
    public $MoneySymbol;
    public $Currency;
    public $ShowAcceptanceText;
    public $AcceptanceText;
    public $AdminEmail;
    public $SupportEmail;

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

    public function getSiteSettings()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_settings;";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->SiteName = $row["sitename"];
            $this->SiteURL = $row["siteurl"];
            $this->AdminEmail = $row["adminmail"];
            $this->AcceptanceText = $row["acceptancetext"];
            $this->CookiesPrefix = $row["cookiesprefix"];
            $this->Currency  = $row["currency"];
        }

    }



}