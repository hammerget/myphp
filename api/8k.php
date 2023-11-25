<?php

function mk_dir($newdir)
{
    $dir = $newdir;
    if (is_dir('./' . $dir)) {
        return $dir;
    } else {
        mkdir('./' . $dir, 0777, true);
        return $dir;
    }
}

mk_dir('./cache/');

$cache = new Cache(3600, "cache/");
$playUrl = $cache->get('cctv8k_cache');
$headers = [
    "User-Agent: cctv_app_tv",
    "Referer: api.cctv.cn",
    "UID: 1234123122"
];
if (!$playUrl) {
    $bstrURL = "https://ytpvdn.cctv.cn/cctvmobileinf/rest/cctv/videoliveUrl/getstream";
    $postData = 'appcommon={"ap":"cctv_app_tv","an":"央视投屏助手","adid":"1234123122","av":"1.1.7"}&url=http://liveten-tp4k.cctv.cn/live/4K36M/playlist.m3u8';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $bstrURL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $data = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($data);
    $playUrl = $obj->url;
    $cache->put('cctv8k_cache', $playUrl);
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_URL, $playUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data = curl_exec($ch);
curl_close($ch);
$data = preg_replace('/(.*?.ts)/i', "http://liveten-tp4k.cctv.cn/live/4K36M/$1", $data);
header("Content-Type: application/vnd.apple.mpegurl");
echo $data;
exit;

class Cache
{
    private $cache_path;
    private $cache_expire;

    public function __construct($exp_time = 3600, $path = "cache/")
    {
        $this->cache_expire = $exp_time;
        $this->cache_path = $path;
    }

    private function fileName($key)
    {
        return $this->cache_path . md5($key);
    }

    public function put($key, $data)
    {
        $values = serialize($data);
        $filename = $this->fileName($key);
        $file = fopen($filename, 'w');
        if ($file) {
            fwrite($file, $values);
            fclose($file);
        } else return false;
    }

    public function get($key)
    {
        $filename = $this->fileName($key);
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }
        if (time() < (filemtime($filename) + $this->cache_expire)) {
            $file = fopen($filename, "r");
            if ($file) {
                $data = fread($file, filesize($filename));
                fclose($file);
                return unserialize($data);
            } else return false;
        } else return false;
    }
}
?>
