<?php
require 'vendor/autoload.php';
include('Keys.php');

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

//Device detection
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null; // user agent to parse
$detector = new DeviceDetector($userAgent);
$detector->parse();
if ($detector->isBot()) {
    //Handle bots,spiders,crawlers...
    $botInfo = $detector->getBot();
    $bot = implode(", ", $botInfo);
    echo "<p> Bot detected: <span> {$bot} </span> </p>";
} else {
    $clientInfo = $detector->getClient(); //Holds information about browser,feed reader, media player...
    $client = implode(" ", $clientInfo);
    $osInfo = $detector->getOs();
    $os = implode(" ", $osInfo);

    $device = $detector->getDeviceName();
    $brand = $detector->getBrandName();
    $model = $detector->getModel();
    echo "<p> Browser used: <span> {$client} </span> <br> 
Machine: <span> {$device} ,</span> <span> {$os} ,</span> 
<span> {$brand} ,</span> <span> {$model} </span>  </p>";
}

//GET IP Address
function getIPAddress()
{
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //proxy check
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //remote ip check
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$IP_ADDRESS = getIPAddress();

//Geolocation using ip-api
$IP_API_URL = 'http://ip-api.com/json/' . urlencode($IP_ADDRESS) . '?fields=66846719';
$response = file_get_contents($IP_API_URL);
$response = json_decode($response, true);
if (!empty($response)) {
    echo "<p> Location: <span> {$response['city']} {$response['country']} {$response['regionName']} {$response['continent']}</span>. <br>
    Timezone: <span>{$response['timezone']}</span>. <br> 
    Precisely at: <span> latitude: {$response['lat']}, longitude: {$response['lon']}</span> <br>
    Accuracy radius: <span> {$response['offset']}</span>. </br> Common currency: <span> {$response['currency']} </span> </p> <br>";

    if ($response['mobile']) {
        echo "<p> <span> mobile connection detected </span> or maybe a modem with a Sim-card...</p> <br>";
    }
    echo "<p> ISP: <span> {$response['as']} {$response['isp']} </span> </p> <br>";

    if (!empty($_SERVER['HTTP_REFERER'])) {
        echo "<p> Last referer page: <span> {$_SERVER['HTTP_REFERER']} </span>? </p> <br>";
    }

    //Obfuscation Detection
    if ($response['proxy']) {
        echo "<p> I sense obfuscation on your IP address. <br> you are trying to hide from 
        the gaze with either a <i> vpn/proxy or Tor </i>. <br> For legal reasons I have to ask: are you a criminal? <br>
        your Ip address is: <span> {$response['query']} </span> <br>
        I cannot see you through that without violating at least 32 laws...<br>
        therefore the data above might be biased </p>";
    } else {
        echo "<p> No obfuscation detected: <br>
        <i> no vpn </i>, <i> no proxy </i>, <i> no Tor</i> <br>
        you are not very challenging, nor original... <br>
        Your IP address is: <span> {$response['query']}</span> <br> 
        </p>";
    }
} else {
    echo "<p> I cannot Geolocate you..WHY CAN I NOT GEOLOCATE YOU? are you living under a rock? </p> <br>";
}

$today = new DateTime("now", new DateTimeZone($response['timezone']));
echo "<p> Encounter date and time: <span> {$today->format('d-m-Y H:i:s')} </span> </p>";

echo "<p> Interresting data... I could store it but it's not that important to me. <br>
Be gone mortal! </p>";
