<?php

class help {

    public $HelpTopic;
    public $HelpText;
    public $HelpTopicsSQL;

    private $DB_Conn;

    function __construct($topic=null)
    {
        $this->DB_Conn = self::connnectToDB();

        if (!empty($topic))
        {
            self::getHelpTopic($topic);
        }
        else
        {
            $this->HelpTopicsSQL = self::getHelpTopicsSQL();
        }
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


    public function getHelpTopicsSQL()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_help
                ORDER BY topic";
        return $sql;

    }

    public function getHelpTopics()
    {
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_help
                ORDER BY topic";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrHelp = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrHelp[$counter]["HelpTopic"] = $row["topic"];
            $arrHelp[$counter]["HelpText"] = $row["helptext"];
            $counter++;
        }
        return $arrHelp;

    }

    public function getHelpTopic($topic)
    {
        //
        $sql = "SELECT * FROM PHPAUCTIONPROPLUS_help
                    WHERE topic='" . $topic . "';";
        //print $sql . "<br />";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        while($row = $result->fetch_assoc())
        {
            $this->HelpTopic = $row["topic"];
            $this->HelpText = $row["helptext"];
        }

    }


    public function updateHelpTopic()
    {
        //
        $sql = "UPDATE  PHPAUCTIONPROPLUS_help
                SET helptext = '" . addslashes(trim($this->HelpText)) . "' 
                    WHERE topic='" . addslashes($this->HelpTopic) . "';";
       // print $sql . "\n";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());

    }
    public function deleteHelpTopic()
    {
        //
        $sql = "DELETE FROM PHPAUCTIONPROPLUS_help
                WHERE topic='" . addslashes($this->HelpTopic) . "';";
         print $sql . "\n";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        return $result;

    }

    /* SELECT MIN( bid ) AS Min_Bid, MAX( bid ) AS Max_Bid, COUNT( id ) Num_Bids, auction
FROM `PHPAUCTIONPROPLUS_bids`
WHERE auction =2137
GROUP BY auction */


}