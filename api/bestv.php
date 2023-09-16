
<?php
error_reporting(0);
date_default_timezone_set("Asia/Shanghai");
$date = date('YmdH');
$t = substr(time(), 0, 9)-5;

//内置默认参数
$id = isset($_GET['id'])?$_GET['id']:'cctv1hd8m';
$ips = isset($_GET['ip'])?$_GET['ip']:'';
$key = isset($_GET['key'])?$_GET['key']:'';
$domain = isset($_GET['dn'])?$_GET['dn']:'liveplay-kk.rtxapp.com';

//实现自动识别id对应的码率
if(strpos($id,'4k')){$rate='15000000';}
else if(strstr($id,'8m')){$rate='8000000';}
else if(strstr($id,'setvhd')){$rate='8000000';}
else if(strstr($id,'scwshd')){$rate='8000000';}
else if(strstr($id,'4m')){$rate='4000000';}
else if(strstr($id,'hd')){$rate='4000000';}
else if(strstr($id,'ssty')){$rate='4000000';}
else if(strstr($id,'zgjy1ott')){$rate='4000000';}
else if(strstr($id,'cetv2')){$rate='2500000';}
else if(strstr($id,'ottcctvnews')){$rate='1300000';}
else if(strstr($id,'cctvnews')){$rate='2500000';}
else if(strstr($id,'cctv17')){$rate='2500000';}
else if(strstr($id,'hhse')){$rate='2500000';}
else if(strstr($id,'xzwszy')){$rate='2500000';}
else if(strstr($id,'xzws')){$rate='2500000';}
else if(strstr($id,'kbws')){$rate='2500000';}
else if(strstr($id,'cftx')){$rate='2500000';}
else{$rate='1300000';}

//内置IP，可以自行修改
$arr = [
'111.31.238.14',
'111.31.238.69',
'111.31.238.95',
'111.31.238.237',
'115.56.76.27',
'115.56.76.65',
'115.56.76.81',
'116.136.171.37',
'116.136.171.41',
'116.136.171.50',
'116.136.171.61',
'116.136.171.79',
'116.136.171.83',
'116.136.171.41',
'116.136.171.102',
'123.247.80.97',
'150.138.173.14',
'150.138.173.15',
'150.138.173.24',
'150.138.173.36',
'150.138.173.45',
'150.138.173.46',
'150.138.173.85',
'150.138.173.210',
'183.246.208.102',
'183.246.208.126',
];

//对各种参数的处理
if($key == null){
$path = 'live/program/live';
}else{
$path = $key.'/live/program/live';
}

if($ips == null){
$ip = $arr[array_rand($arr)];
}else{
$ip = $arr[$ips];
}

if(strpos($id,'/')){
$ids = $id;
}else{
$ids = "{$id}/{$rate}";
}        

if(strpos($ips,'.')){$ip = $ips;}
if(strpos($ips,'.com')){
$stream = "http://{$ip}/{$path}/{$ids}/{$date}/";
}else{
$stream = "http://{$ip}/{$domain}/{$path}/{$ids}/{$date}/";
}
$current = "#EXTM3U\r\n#EXT-X-VERSION:3\r\n#EXT-X-TARGETDURATION:5\r\n#EXT-X-MEDIA-SEQUENCE:{$t}\r\n";
for ($i=0; $i<3; $i++) {
$current.= "#EXTINF:5.000,"."\r\n";
$current.= $stream.$t.".ts"."\r\n";
$t = $t + 1;
}
header("Content-Type: application/vnd.apple.mpegurl");
header("Content-Disposition: inline; filename=mnf.m3u8");
print_r($current);
?>
