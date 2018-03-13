<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

require_once("database.class.php");

class mapping {

    function __construct()
    {
        $this->db = database::connnectToDB();
    }


    public function getMappingInfoByID($id)
    {
        if (($id) && ($id > 0 ))
        {

            $qWhere = " WHERE mappingID = '" . $id . "' ";
              $conn = $this->db;
            $sql = "SELECT dtz.ZipCode, dm.DomainName, dtz.mappingID  FROM DomainToZipMapping dtz
              JOIN DomainMapping dm ON dm.domainID = dtz.DomainID $qWhere ";
        //print $sql . "<br />";
            $result = $conn->query($sql) or die(mysqli_error());
            while($row = $result->fetch_assoc())
            {
                $chrItem["ZipCode"] = $row['ZipCode'];
                $chrItem["DomainName"] = $row['DomainName'];
                $chrItem["mappingID"] = $row['mappingID'];
            }
        }
        return $chrItem;
    }

    public function checkForDuplicateZip($id)
    {
        if (($id) && ($id > 0 ))
        {

            $qWhere = " WHERE ZipCode = '" . $id . "' ";
            $conn = $this->db;
            $sql = "SELECT dtz.ZipCode, dm.DomainName, dtz.mappingID, dm.DomainID  FROM DomainToZipMapping_conv dtz
              JOIN DomainMapping dm ON dm.domainID = dtz.DomainID $qWhere ";
           // print $sql . "<br />";
            $result = $conn->query($sql) or die(mysqli_error());
           // print_r($result);
            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $chrItem["ZipCode"] = $row['ZipCode'];
                    $chrItem["DomainName"] = $row['DomainName'];
                    $chrItem["mappingID"] = $row['mappingID'];
                    $chrItem["DomainID"] = $row['DomainID'];
                }
            }
            else
            {
                $chrItem["ZipCode"] = 0;
            }
        }
        return $chrItem;
    }

    public function AddMappingInfo( $zip, $domainID)
    {
        $conn = $this->db;
        $sql = "INSERT INTO DomainToZipMapping_conv
                (ZipCode, DomainID)
                VALUES ('" . $zip . "','" . $domainID . "');";
        //print $sql . "<br />";
        $result = $conn->query($sql) or die(mysqli_error());
        return $result;
    }

    public function SaveMappingInfoByID($id, $zip, $domainID)
    {
        if ($id)
        {
            $qWhere = " WHERE mappingID = '" . $id . "' ";
        }
        $conn = $this->db;
        $sql = "UPDATE DomainToZipMapping
                SET ZipCode = '" . $zip . "', DomainID = '" . $domainID . "'
                 $qWhere ";
        //print $sql . "<br />";
        $result = $conn->query($sql) or die(mysqli_error());
        return $result;
    }

    public function DeleteMappingInfoByID($id)
    {
        if ($id)
        {
            $qWhere = " WHERE mappingID = '" . $id . "' ";
        }
        $conn = $this->db;
        $sql = "DELETE FROM  DomainToZipMapping
                 $qWhere ";
        //print $sql;
        $result = $conn->query($sql) or die(mysqli_error());
        return $result;
    }

    public function getDomainInfo()
    {
        $conn = $this->db;
        $sql = "SELECT dm.domainID, dm.DomainName  FROM  DomainMapping dm ORDER BY DomainName ";
        $result = $conn->query($sql) or die(mysqli_error());
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $domains[$counter]["domainID"] = $row['domainID'];
            $domains[$counter]["DomainName"] = $row['DomainName'];
            $counter++;
        }
       // print_r($domains);
        return $domains;
    }

}