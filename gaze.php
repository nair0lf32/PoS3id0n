<?php
require 'vendor/autoload.php';
include ('Keys.php'); //KEY FILE THAT IS OBVIOUSLY GITIGNORED

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

$userAgent = $_SERVER['HTTP_USER_AGENT']??null; // change this to the useragent you want to parse


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
echo "<p> You came at me </span> with a <span> {$client} </span>  
installed on a <span> {$device} </span> with <span> {$os} </span> 
<span> {$brand} </span> <span> {$model} </span>  </p>";
}


//GET IP Address
function getIPAddress() {  
 //whether ip is from the share internet  
if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
    $ip = $_SERVER['HTTP_CLIENT_IP'];  
} 
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
//whether ip is from the remote address  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
return $ip;  
}  
$IP_ADDRESS = getIPAddress();  


//Geolocation
// API URL
$IP_API_URL = 'http://ip-api.com/json/'.urlencode($IP_ADDRESS).'?fields=66846719';
// Fetch IP-API 
$response = file_get_contents($IP_API_URL);
// Decode JSON response
$response = json_decode($response, true);
if (!empty($response)){
echo "<p> So...you are from <span> {$response['city']} {$response['country']} {$response['regionName']} {$response['continent']}</span>... 
its in the timezone of <span>{$response['timezone']}</span> </br> I see you precisely at 
<span> latitude: {$response['lat']}, longitude: {$response['lon']}</span> with an
<span> accuracy radius of: {$response['offset']}</span>. </br> seems like you
still pay with <span> {$response['currency']} </span> there..
that's poor people currency...we use shellfish in Atlantis.  </p>";

if ($response['mobile']){echo "<p> you are using a <span> mobile connection </span> ...maybe a modem with a Sim-card </p>";}

echo "<p> you get your internet from <span> {$response['as']} with {$response['isp']} </span>
and your ISP doesn't really care about your privacy to be honest. </p>";



if(!empty($_SERVER['HTTP_REFERER'])) {echo "<p> did you just visit <span> {$_SERVER['HTTP_REFERER']} </span>? </p>";}


//Obfuscation Detection

if ($response['proxy']){echo "<p> I sense obfuscation on your IP address you are trying to hide from 
    me with either <i> vpn/proxy or Tor </i>...for legal reasons I have to ask..are you a criminal?
    or a hacker? your Ip...its <span> {$response['query']} </span>
    ...hmm no someting is wrong...you won I cannot see you through that without violating
    at least 32 laws...all the data above is biased
    But I know it and I will get you someday (maybe when I own the internet) </p>";}
    else
    {echo "<p> A simple mortal with <i> no vpn, no proxy, no Tor...nothing </i>
        you are not very challenging...nor original...here have your IP address <span> {$response['query']}</span> and go away 
</p>";
}
}else { echo "<p> I cannot Geolocate you..WHY CAN I NOT GEOLOCatE YOU? are you hiding under a rock? </p>";}


$today = new DateTime("now", new DateTimeZone($response['timezone']));
echo "<p> You came at me today <span> {$today -> format('d-m-Y H:i:s')} </span> and there is nothing special about this day.. </p>";
echo "<p> I could store our encounter in my database (If I had any) or give you a cookie but you and your data are not that
important to me...so...just leave now!</p>";
?>

