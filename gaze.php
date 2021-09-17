<?php
require 'vendor/autoload.php';
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

$userAgent = $_SERVER['HTTP_USER_AGENT']??null; // change this to the useragent you want to parse
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$ip = '';


//Deice detection
$detector = new DeviceDetector($userAgent);
$detector->parse();
if ($detector->isBot()) {
  // handle bots,spiders,crawlers,...
$botInfo = $detector->getBot();
$bot = implode(", " ,$botInfo);
echo "<p> Oh you are using a bot? nice, a <span> {$bot} </span> </p>";
} else {
$clientInfo = $detector->getClient(); // holds information about browser, feed reader, media player, ...
$client = implode(" " ,$clientInfo);
$osInfo = $detector->getOs();
$os = implode(" " ,$osInfo);

$device = $detector->getDeviceName();
$brand = $detector->getBrandName();
$model = $detector->getModel();
echo "<p> You came at me with a <span> {$client} </span>  
installed on a <span> {$device} </span> with <span> {$os} </span>  </p>";
echo "<p> a good old <span> {$brand} </span> <span> {$model} </span>  </p>";
}


//IP address detection
function getIPAddress() {  
//whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP']; 
                echo "<p> a share Ip address..your ISP must be the loving and caring one </p>"; 
        } 
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
                echo "<p> oh a proxy...that's cute.</p>"; 
    }  
//whether ip is from the remote address  
    else{  
    $ip = $_SERVER['REMOTE_ADDR']; 
    echo "<p> you came at me raw...a simple Ip address for a simple mortal  </p>";
    }  
    return $ip;  
}  
$ip = getIPAddress();
echo "<p> Here you are: <span> {$ip}</p>";  


if(!empty($host) or !($host==$ip)){
echo "<p> may I call your machine <span> {$host} </span>? what a weird name? </p>";
}
else{echo "<p> hmm...I can't see your machine name..pesky DNS meddling with my affairs </p>"; }




//IP Geolocation
/*Get user ip address details with geoplugin.net*/
$ip_info = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));  
if($ip_info && $ip_info->geoplugin_countryName != null){

/*Get City name by return array*/
$city = isset($addrDetailsArr['geoplugin_city'])?$addrDetailsArr['geoplugin_city']:'Not defined'; 
/*Get Country name by return array*/
$country = isset($addrDetailsArr['geoplugin_countryName'])?$addrDetailsArr['geoplugin_countryName']:'Not defined';
/*Get Country name by return array*/
$latitude = isset($addrDetailsArr['geoplugin_latitude'])?$addrDetailsArr['geoplugin_latitude']:'Not defined';
/*Get Country name by return array*/
$longitude = isset($addrDetailsArr['geoplugin_longitude'])?$addrDetailsArr['geoplugin_longitude']:'Not defined';
/*Get Country name by return array*/
$currencyCode = isset($addrDetailsArr['geoplugin_currencyCode'])?$addrDetailsArr['geoplugin_currencyCode']:'Not defined';
/*Get Country name by return array*/
$currencySymbol = isset($addrDetailsArr['geoplugin_currencySymbol'])?$addrDetailsArr['geoplugin_currencySymbol']:'Not defined';
/*Get Continent name by return array*/
$continent = isset($addrDetailsArr['geoplugin_continentName'])?$addrDetailsArr['geoplugin_continentName']:'Not defined';
/*Get Timezone by return array*/
$continent = isset($addrDetailsArr['geoplugin_timezone'])?$addrDetailsArr['geoplugin_timezone']:'Not defined';

echo "<p> So...you are from <span> {$city}, {$country}... </span> </p>";



}
else
{
echo "<p> I cannot geolocate you...WHY CAN I NOT LOCATE YOU? are you hiding under a rock? </p>";
}


?>

