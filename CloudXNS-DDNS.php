<?php
// 配置区
$config = [
    'api_key' => '',
    'secret_key' => '',
    'ddns_domain' => '',
    'check_url' => 'https://myip.ipip.net/',
];
// 配置区结束



/**
 * cURL get || post
 * @param string $url 请求的目标url
 * @param null|array post发送的数据。为null时get
 * @return string
 */
function curl($url, $data = null, $config = null){
    $ch = curl_init($url);
    if($data !== null){
        $date = date(DATE_RFC2822);
        $hmac = md5($config['api_key'] . $url . json_encode($data) . $date . $config['secret_key']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'API-KEY: ' . $config['api_key'],
            'API-REQUEST-DATE: ' . $date,
            'API-HMAC: ' . $hmac,
            'API-FORMAT: json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

/**
 * 从字符串中获取IP
 * @param string $str 含有IP地址的字符串
 * @return string|bool
 */
function getIpFromString($str){
    preg_match('|(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})|', $str, $result);
    return count($result) == 2 ? $result[0] : false;
}

echo date('Y-m-d H:i:s') . "\n";

$local_ip = gethostbyname($config['ddns_domain']);
echo "本地解析IP：{$local_ip}\n";
$check_ip = getIpFromString(curl($config['check_url']));
echo "远程解析IP：{$check_ip}\n";

if($local_ip == $check_ip){
    echo "解析结果一致，跳过更新";
} else {
    $result = curl('https://www.cloudxns.net/api2/ddns', ['domain' => $config['ddns_domain']], $config);
    $result = json_decode($result, true);
    if(isset($result['message']) && $result['message'] === 'success'){
        echo "解析更新成功";
    } else {
        echo "【解析更新失败】{$result['message']}";
    }
}