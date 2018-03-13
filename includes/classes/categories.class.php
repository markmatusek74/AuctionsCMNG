<?php

class categories {

    public $CategoryID;
    public $ParentID;
    public $CategoryName;
    public $Deleted;
    public $SubCounter;
    public $Counter;
    public $CategoryColor;
    public $CategoryImage;

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


    public function getCategoryList()
    {
        $sql = "SELECT cat . * , COUNT( auc.id ) category_count
              FROM PHPAUCTIONPROPLUS_categories cat
              JOIN PHPAUCTIONPROPLUS_auctions auc ON auc.category = cat.cat_id
              WHERE Deleted =0
              AND Parent_ID =0
              GROUP BY cat.cat_name;";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $arrCats = array();
        $counter = 0;
        while($row = $result->fetch_assoc())
        {
            $arrCats[$counter]["CategoryID"] = $row["cat_id"];
            $arrCats[$counter]["ParentID"] = $row["parent_id"];
            $arrCats[$counter]["CategoryName"] = $row["cat_name"];
            $arrCats[$counter]["Deleted"] = $row["deleted"];
            $arrCats[$counter]["SubCounter"] = $row["sub_counter"];
            $arrCats[$counter]["Counter"] = $row["counter"];
            $arrCats[$counter]["CategoryColor"] = $row["cat_colour"];
            $arrCats[$counter]["CategoryImage"] = $row["cat_image"];
            $arrCats[$counter]["CategoryCount"] = $row["category_count"];
            $counter++;
        }
    return $arrCats;
    }

    public function getCategoryNameByID($id)
    {
        $sql = "SELECT cat.cat_name
              FROM PHPAUCTIONPROPLUS_categories cat
              WHERE cat_id = " . $id . "
              AND Deleted =0
              AND Parent_ID =0
              ";
        $result = $this->DB_Conn->query($sql) or die(mysqli_error());
        $catName = "";
        while($row = $result->fetch_assoc())
        {
            $catName = $row["cat_name"];
        }
        return $catName;
    }

}