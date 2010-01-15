<?php
sleep(1);

    if(isset($_GET['airport']) && $_GET['airport'] != '' && isset($_GET['type']) && $_GET['type'] != '') {

            $airportID = $_GET['airport'];

            $type = $_GET['type'];

            $out = '';

            $root = 'http://query.yahooapis.com/v1/public/yql?q=';

            $yql = 'use "http://thinkphp.ro/apps/YQL/airportweather/airportweather.xml" as aw; select * from aw where airportid="'.$airportID.'" and datatype="'.$type.'";';

            $url = $root . urlencode($yql) . '&format=json&diagnostics=false';
  
            $content = get($url);

            $json = json_decode($content);
 
            if($json->query->results->error) {

                 $out = $json->query->results->error;

            } else {

                 $out = $json->query->results->airportweather;
            }

         echo$out;
 
    }//endif

    //@description get a resource from URL
    //@param url String
    //@return JSON
    function get($url) {

            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL,$url); 

            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 

            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2); 

            $data = curl_exec($ch);

            curl_close($ch);

            if(empty($data)) {return 'Error retrieve. Please try again.';}

                         else

                             {return $data;}
    }//end function get


?>