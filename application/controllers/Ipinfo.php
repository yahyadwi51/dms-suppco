<?php 
$ip = file_get_contents('https://ipapi.co/ip/');
$TOKEN = '78896b4e8ecdb5';
$url = 'http://ipinfo.io/'.$ip.'?token='.$TOKEN;

$ch = curl_init($url);

curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);

print "<pre>";
print_r($ip);
print "</pre>";


?>