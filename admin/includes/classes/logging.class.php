<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MarkMatusek74
 * Date: 7/9/16
 * Time: 10:21 PM
 * To change this template use File | Settings | File Templates.
 */

require_once("database.class.php");

class logging {

    function __construct()
    {
        $this->db = database::connnectToDB();
    }

    public function AddZipConversionLogging($filename, $mapID, $zip, $domainID, $csvLine)
    {
        $conn = $this->db;
        $sql = "INSERT INTO Conversion_Logging
                (Filename, mappingID, ZipCode, DomainID, CSV_Line)
                VALUES ('" . $filename . "','" . $mapID  . "','" . $zip . "','" . $domainID  . "','". $csvLine  . "');";
       // print $sql . "<br />";
        $result = $conn->query($sql) or die(mysqli_error());
        return $result;
    }



}