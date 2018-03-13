<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

require_once("database.class.php");

class imports {

    public $ImportID;
    public $Filename;
    public $StartTime;
    public $EndTime;
    public $TotalRecords;
    public $SelfDupes;
    public $BadZips;
    public $AlreadyThere;
    public $NewRecords;
    public $ProcessTime;
    public $IPAddress;



    function __construct()
    {
        $this->db = database::connnectToDB();
    }

    public function SetNewRecords($NewRecords)
    {
        $this->NewRecords = $NewRecords;
    }

    public function GetNewRecords()
    {
        return $this->NewRecords;
    }

    public function SetProcessTime($ProcessTime)
    {
        $this->ProcessTime = $ProcessTime;
    }

    public function GetProcessTime()
    {
        return $this->ProcessTime;
    }

    public function SetIPAddress($IPAddress)
    {
        $this->IPAddress = $IPAddress;
    }

    public function GetIPAddress()
    {
        return $this->IPAddress;
    }

    public function SetImportID($ImportID)
    {
        $this->ImportID = $ImportID;
    }

    public function GetImportID()
    {
        return $this->ImportID;
    }

    public function SetFilename($Filename)
    {
        $this->Filename = $Filename;
    }

    public function GetFilename()
    {
        return $this->Filename;
    }
    public function SetStartTime($StartTime)
    {
        $this->StartTime = $StartTime;
    }

    public function GetStartTime()
    {
        return $this->StartTime;
    }

    public function SetEndTime($EndTime)
    {
        $this->EndTime = $EndTime;
    }

    public function GetEndTime()
    {
        return $this->EndTime;
    }

    public function SetTotalRecords($TotalRecords)
    {
        $this->TotalRecords = $TotalRecords;
    }

    public function GetTotalRecords()
    {
        return $this->TotalRecords;
    }

    public function SetSelfDupes($SelfDupes)
    {
        $this->SelfDupes = $SelfDupes;
    }

    public function GetSelfDupes()
    {
        return $this->SelfDupes;
    }

    public function SetBadZips($BadZips)
    {
        $this->BadZips = $BadZips;
    }

    public function GetBadZips()
    {
        return $this->BadZips;
    }

    public function SetAlreadyThere($AlreadyThere)
    {
        $this->AlreadyThere = $AlreadyThere;
    }

    public function GetAlreadyThere()
    {
        return $this->AlreadyThere;
    }

    public function getRealUserIp(){
        switch(true){
            case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default : return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function AddZipImportInfo()
    {
        $conn = $this->db;
        $this->IPAddress = self::getRealUserIp();
        $sql = "INSERT INTO ZipCodeImports
                (Filename, StartTime, EndTime, TotalRecords, SelfDupes, BadZips,
                AlreadyThere, NewRecords, ProcessTime, IPAddress)
                VALUES
                ('" . $this->Filename . "','" . $this->StartTime  . "','" . $this->EndTime . "','" . $this->TotalRecords  . "','". $this->SelfDupes  . "','"
                    . $this->BadZips . "','" . $this->AlreadyThere . "','" . $this->NewRecords . "','" . $this->ProcessTime . "','" . $this->IPAddress . "'
                );";
       // print $sql . "<br />";
        $result = $conn->query($sql) or die(mysqli_error());
        return $conn->insert_id;
    }

    public function UpdateZipImportInfo()
    {
        $conn = $this->db;
        $this->IPAddress = self::getRealUserIp();
        $sql = "UPDATE ZipCodeImports
                SET Filename = '" . $this->Filename . "',
                StartTime = '" . $this->StartTime . "',
                EndTime = '" . $this->EndTime . "',
                TotalRecords = '" . $this->TotalRecords . "',
                SelfDupes = '" . $this->SelfDupes . "',
                BadZips = '" . $this->BadZips . "',
                AlreadyThere = '" . $this->AlreadyThere . "',
                NewRecords = '" . $this->NewRecords . "',
                ProcessTime = '" . $this->ProcessTime . "',
                IPAddress = '" . $this->IPAddress . "'

                WHERE ImportID = " . $this->ImportID ;
        // print $sql . "<br />";
        $result = $conn->query($sql) or die(mysqli_error());
        return $result;
    }


}