<?php
    if($_GET['submit'] && isset($_GET['airport']) && $_GET['airport'] != '' && isset($_GET['group']) && $_GET['group'] != '') {

            $airportID = $_GET['airport'];

            $type = $_GET['group'];

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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
   <title>Turning a web folder with data into an API using YQL Execute</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <style type="text/css">
    html,body{font-family: calibri "arial rounded mt bold","lucida grande",arial,sans-serif;background: #6387B3}
    #doc2{background:#f8f8f8;border:1em solid #f8f8f8;-moz-border-radius:10px;-webkit-border-radius: 10px;border-radius: 10px}
    h1{font-size:200%;margin:10px 0;color: #fff;text-transform:capitalize;text-align: left;margin-left:20px}
    label[for=airport]{font-size: 40px}
    input{border: 1px solid #ccc;color: #000;font-size: 40px;padding: 10px;margin: 10px;text-align: center;-moz-border-radius:10px;-webkit-border-radius: 10px;border-radius: 10px}
    input:focus{background: #D2E5FF}
    .valid{color: lightgreen;font-size: 20px}
    .invalid{color: red;font-size: 20px}
    #results{width: 400px;margin-left: 120px}
    #ft {margin:3em 0 1em 0;color:#ccc;}
    #ft a{color:#ccc;}
   </style>
</head>
<body>
<div id="hd" role="banner"><h1>Gets the weather forecast for airports in taf or metar format</h1></div>
<div id="doc2" class="yui-t7">
   <div id="bd" role="main">
	<div class="yui-g">

      <form method="get" action="index.php">
        <p><label for="airport">airport</label><input type="text" id="airport" name="airport" value="<?php if(isset($_GET['airport'])){echo$_GET['airport'];}?>"/>
            <input type="submit" name="submit" id="submit" value="submit"></p>
        <p><label for="taf">taf</label><input id="taf" type="radio" name="group" value="taf" <?php if($_GET['group'] === 'taf'){echo'checked';}?>/>
        <label for="metar">metar</label><input id="metar" type="radio" name="group" value="metar" <?php if($_GET['group'] === 'metar'){echo'checked';}?>/></p>
        <p><div id="results"><?php if(isset($out)) {echo$out;}?></div></p>
      </form>

       </div>
</div>
<div id="ft" role="contentinfo"><p>Written By Adrian Statescu using <a href="http://weather.noaa.gov/pub/data/forecasts/taf/stations/">taf</a> | <a href="http://weather.noaa.gov/pub/data/observations/metar/stations/">metar</a> | <a href="http://www.alaska.faa.gov/fai/afss/metar%20taf/metintro.htm">Abbreviations</a> | <a href="../airportweather.xml">Open Data Table</a></p></div>
</div>
</body>
</html>
