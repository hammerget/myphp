a012',//北京新闻高清
   'kkse' => 'b928229e615248d7a2c6f9ea047f25cf37a3a0af',//北京卡酷少儿
   'shjsrw' => '98a578339579ce91ec2443bfbd1fc3af10ee02bd',//上海纪实人文高清
   ];
if($u=='lzjtu'){ $m3u8 = "http://video.lzjtu.edu.cn/liverespath/{$n[$id]}/index.m3u8";}
if($u=='luas'){ $m3u8 = "https://iptv.luas.edu.cn/liverespath/{$n[$id]}/index.m3u8";}
if($u=='xxvtc'){ $m3u8 = "http://tv.xxvtc.edu.cn/liverespath/{$n[$id]}/index.m3u8";}
header("Content-Type: application/vnd.apple.mpegurl");
header("location:$m3u8");
//echo $m3u8;
?>
