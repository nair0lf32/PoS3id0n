<?php
require 'vendor/autoload.php';
require_once('geoplugin/geoplugin.class.php');
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
installed on a <span> {$device} </span> with <span> {$os} </span> 
<span>, {$brand} </span> <span> {$model} </span>  </p>";
}




//simple Proxy detection
$test_HTTP_proxy_headers = array(
	'HTTP_VIA',
	'VIA',
	'Proxy-Connection',
	'HTTP_X_FORWARDED_FOR',  
	'HTTP_FORWARDED_FOR',
	'HTTP_X_FORWARDED',
	'HTTP_FORWARDED',
	'HTTP_CLIENT_IP',
	'HTTP_FORWARDED_FOR_IP',
	'X-PROXY-ID',
	'MT-PROXY-ID',
	'X-TINYPROXY',
	'X_FORWARDED_FOR',
	'FORWARDED_FOR',
	'X_FORWARDED',
	'FORWARDED',
	'CLIENT-IP',
	'CLIENT_IP',
	'PROXY-AGENT',
	'HTTP_X_CLUSTER_CLIENT_IP',
	'FORWARDED_FOR_IP',
	'HTTP_PROXY_CONNECTION');
	
	foreach($test_HTTP_proxy_headers as $header){
		if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
			echo "<p> oh a <i>Proxy</i>...that's cute, I will allow that.</p>"; 
		}
	}



//IP address detection
function getIPAddress() {  
//whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP']; 
                echo "<p> a <i> Shared IP addresss</i>...your ISP must be the loving and caring one </p>"; 
        } 
//whether ip is from the remote address  
    else{  
    $ip = $_SERVER['REMOTE_ADDR']; 
    echo "<p> you came at me <i>Raw</i>...a simple remote Ip address for a simple mortal  </p>";
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
$geoplugin = new geoPlugin();
$geoplugin->locate();
if($geoplugin->locate() != null){

echo "<p> So...you are from <span> {$geoplugin->city}, {$geoplugin->countryName} </span>... 
its in the timezone of <span>{$geoplugin->timezone}</span>, I see you precisely at 
<span> latitude: {$geoplugin->latitude}, longitude: {$geoplugin->longitude}</span> with an
<span> accuracy radius of: {$geoplugin->locationAccuracyRadius}</span>. seems like you
still pay with <span> {$geoplugin->currencySymbol}/{$geoplugin->currencyCode} </span> there..
that's poor people currency..we use shellfish in Atlantis. </p>";
}
else
{
echo "<p> I cannot geolocate you...WHY CAN I NOT LOCATE YOU? are you hiding under a rock? </p>";
}


?>

