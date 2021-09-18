<?php
require 'vendor/autoload.php';
include_once ('Keys.php'); //KEY FILE THAT IS OBVIOUSLY GITIGNORED
require_once('geoplugin/geoplugin.class.php');
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

$userAgent = $_SERVER['HTTP_USER_AGENT']??null; // change this to the useragent you want to parse
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
installed on a <span> {$device} </span> with <span> {$os} </span> 
<span>, {$brand} </span> <span> {$model} </span>  </p>";
}


//simple Proxy detection
// Get IP Address
$IP_ADDRESS = $_SERVER['REMOTE_ADDR']; # Automatically get IP Address
// USE YOUR OWN API KEY BELOW (FOR OBVIOUS REASONS I GITIGNORED MY KEY FILE)
// API URL
$API_URL = 'http://ip-api.com/php/'.urlencode($IP_ADDRESS);
// Fetch VPNAPI.IO API 
$response = file_get_contents($API_URL);
// Decode JSON response
$response = json_decode($response, true);


if (!empty($response)){
echo "<p> {$response} </p>";
implode(" " ,$response);
// Check if IP Address is VPN
if($response->security->vpn) {
    echo "<p> Oh wow a <i>VPN</i>..so original..you came with that yourself?
    how would I ever get your IP address now? <span> {$response->ip} </span></p>";
} 
// Check if IP Address is Proxy
elseif($response->security->proxy) {
	echo "<p> A <i>Proxy</i>...yeah ok those are everywhere nowadays but
    hey, nice try...now get your IP address and go away: <span> {$response->ip} </span></p>";
} 
// Check if IP Address is TOR Exit Node
elseif($response->security->tor) {
	echo "<p> Oh a <i>Tor node</i>? you seem to be a dangerous person..are you in the mafia 
    or anything? are you a criminal? even hackers fear you...I do not know if 
    <span> {$response->ip} </span> is even you IP address</p>";
} else {
	// IP Address that is not obscured
	echo "<p> you came at me <i> RAW </i>... like a simple mortal... you are neither very challenging 
    nor very orignal... Here have your IP address and go away <span> {$response->ip} </span></p>";
}
}else { echo "<p> sorry I cannot get your Ip data </p>";}




//Geolocation
echo "<p> So...you are from <span> {$response->city} {$response->country}  {$response->continent}</span>... 
its in the timezone of <span>{$response->timezone}</span>, I see you precisely at 
<span> latitude: {$response->latitude}, longitude: {$response->longitude}</span> with an
<span> accuracy radius of: {$response->locationAccuracyRadius}</span>. seems like you
still pay with <span> {$response->currencySymbol}/{$response->currencyCode} </span> there..
that's poor people currency..we use shellfish in Atlantis. </p>";





?>

