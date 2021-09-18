<?php
require 'vendor/autoload.php';
include ('Keys.php'); //KEY FILE THAT IS OBVIOUSLY GITIGNORED
require_once('geoplugin/geoplugin.class.php');
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
echo "<p> You came at me with a <span> {$client} </span>  
installed on a <span> {$device} </span> with <span> {$os} </span> 
<span>, {$brand} </span> <span> {$model} </span>  </p>";
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

// USE YOUR OWN API KEYS BELOW (FOR OBVIOUS REASONS I GITIGNORED MY KEY FILE)
// Fetch VPNAPI.IO API 
// Check if IP Address is VPN
if($response->security->vpn) {
    echo "<p> Oh wow a <i>VPN</i>..so original..you came with that yourself?
    how would I ever get your IP address now? <span> {$response['query']} </span></p>";
} 
// Check if IP Address is Proxy
elseif($response->security->proxy) {
	echo "<p> A <i>Proxy</i>...yeah ok those are everywhere nowadays but
    hey, nice try...now get your IP address and go away: <span> {$response['query']} </span></p>";
} 
// Check if IP Address is TOR Exit Node
elseif($response->security->tor) {
	echo "<p> Oh a <i>Tor node</i>? you seem to be a dangerous person..are you in the mafia 
    or anything? are you a criminal? even hackers fear you...I do not know if 
    <span> {$response->query} </span> is even you IP address</p>";
} else {
	// IP Address that is not obscured
	echo "<p> you came at me <i> RAW </i>... like a simple mortal... you are neither very challenging 
    nor very orignal... Here have your IP address and go away <span> {$response['query']} </span></p>";
}




//Geolocation
// API URL
$IP_API_URL = 'http://ip-api.com/json/'.urlencode($IP_ADDRESS).'?fields=66846719';
// Fetch IP-API 
$response = file_get_contents($IP_API_URL);
// Decode JSON response
$response = json_decode($response, true);
if (!empty($response)){
echo "<p> So...you are from <span> {$response['city']} {$response['country']} {$response['regionName']} {$response['continent']}</span>... 
its in the timezone of <span>{$response['timezone']}</span>, I see you precisely at 
<span> latitude: {$response['lat']}, longitude: {$response['lon']}</span> with an
<span> accuracy radius of: {$response['offset']}</span>. seems like you
still pay with <span> {$response['currency']} </span> there..
that's poor people currency...we use shellfish in Atlantis.  </p>";

if ($response['mobile']){echo "<p> you are on your mobile phone right now </p>";}

echo "<p> yo get your internet from <span> {$response['as']} {$response['isp']} </span>
your ISP doesn't really care abot your privacy to be honest.
its in the timezone of <span>{$response['timezone']}</span>, I see you precisely at 
<span> latitude: {$response['lat']}, longitude: {$response['lon']}</span> with an
<span> accuracy radius of: {$response['offset']}</span>. seems like you
still pay with <span> {$response['currency']} </span> there..
that's poor people currency...we use shellfish in Atlantis.  </p>";

}else { echo "<p> I cannot Geolocate you..WHY CAN I NOT GEOLOCatE YOU? are you hiding under a rock? </p>";}

?>

