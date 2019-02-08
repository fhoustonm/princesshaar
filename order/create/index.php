<?php
ini_set('error_reporting', 0);

const API_URL = 'https://api.adcombo.com/api/v2/order/create/';
const API_KEY = 'ced7700b8125ebd1e1be8b557db0acf5';
const COUNTRIES = array('BE', 'NL');
const ORDERS_FILENAME = 'orders_f45a87bc4d3009c49061db2353613c66.txt';


function get_real_ip_addr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}


function log_order($request_url, $response)
{
    $ip = get_real_ip_addr();
    $date_now = date('Y-m-d H:i:s');
    $fp = fopen(ORDERS_FILENAME, 'a');
    fwrite($fp, "Offer id: 12623\nIP: {$ip}\nDate: {$date_now}\nRequest url: {$request_url}\nResponse: {$response}\n\n\n=====================\n\n\n");
    fclose($fp);
    chmod(ORDERS_FILENAME, 222);
}

function is_mobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function redirect($path) {
    header('Location: ' . $path);
    echo '<meta http-equiv="refresh" content="0;url=' . $path . '">';
    exit();
}

if (file_exists('mobile') && is_mobile()) {
    redirect('mobile');
}

if (isset($_REQUEST['price']))
{
    $params = $_REQUEST;

    if (!isset($params['country_code'])) {
        $params['country_code'] = COUNTRIES[array_rand(COUNTRIES)];
    }

    $params['api_key'] = API_KEY;
    $params['offer_id'] = '12623';
    $params['base_url'] = $_SERVER['REQUEST_URI'];
    $params['referrer'] = $_SERVER['HTTP_REFERER'];
    $params['ip'] = $_SERVER['REMOTE_ADDR'];
    $parsed_referer = parse_url($_SERVER['HTTP_REFERER']);
    parse_str($parsed_referer['query'], $land_params);

    $request_url = API_URL . '?' . http_build_query($params + $land_params);

    $resp = file_get_contents($request_url);
    log_order($request_url, $resp);
    $data = json_decode($resp, true);

    if ($data['code'] == 'ok' && !$data['is_double']) {
        $order_data = base64_encode($params['name'] . '|' . $params['phone']);
        redirect('success.php?order_data=' . $order_data);
    } else {
        $order_data = base64_encode($params['name'] . '|' . $params['phone']);
        redirect('success_invalid.php?order_data=' . $order_data);
    }
}
?>