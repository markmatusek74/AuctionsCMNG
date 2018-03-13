<?php

class auctionHelpers {


    function __construct()
    {
    }


    public function displayAmounts($amount)
    {
       if ($amount <> '')
        {
            print "&nbsp;&nbsp;$";
            print money_format('%i', $amount);
        }
    }

    public function returnAmount($amount)
    {
        $formatted = "";
        if ($amount > 0)
        {
            $formatted =  money_format('%i', $amount);
        }
        return $formatted;
    }

    function getEndsInDays($date)
    {
        $now = time();
        $datediff = $now -  strtotime($date);
        return  floor($datediff / (60 * 60 * 24)) . " day(s)";
    }

    function formatDateTime($date)
    {
        return  date('m/d/y - h:i A',strtotime($date));
    }

    function is_url_exist($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

}