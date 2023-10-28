  case 'ts':
    header("Content-type: video/mp2t");
    ts($_GET['ts']);
    exit;
}

function m3u8($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: 0151']);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function ts($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: 0151']);
  $result = curl_exec($ch);
  curl_close($ch);
}
?>
