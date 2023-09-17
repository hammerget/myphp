  if(!$ts) {
  $burl = preg_split("/tv_channel/",$str)[0];
  print_r(preg_replace("/(.*?.ts)/i","http://".$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF]."?ts=$burl$1",get($m3u8)));
  } else {
    $data = get($ts);
    echo $data;
    }
}

function get($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER,"https://web.guangdianyun.tv/");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
