<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2017/8/29
 * Time: 11:18
 */

#系统调试方法
function debug($text)
{
    if ($_REQUEST["debug"]) {
        if (is_string($text)) {
            echo $text;
        } else {
            var_dump($text);
        }
    }
}


//过滤请求
function filter_request(&$request)
{
    foreach ($request as $k => $v) {
        if (is_array($v)) {
            filter_request($v);
        } else {
            $request[$k] = stripslashes(trim($v));
        }
    }
}

//获取GMTime
function get_gmtime()
{
    return time();
}

function getMillisecond() {
    list($s1, $s2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}

function get_curr_time_section($start, $end)
{
    $checkDayStr = date('Y-m-d ', time());
    $timeBegin1 = strtotime($checkDayStr . $start);
    $timeEnd1 = strtotime($checkDayStr . $end);

    $curr_time = time();

    if ($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1) {
        return 1;
    }

    return -1;
}

//获取客户端IP
function get_client_ip()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset ($_SERVER ['REMOTE_ADDR']) && $_SERVER ['REMOTE_ADDR'] && strcasecmp($_SERVER ['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER ['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return ($ip);
}

function get_domain()
{
    /* 协议 */
    $protocol = get_http();

    /* 域名或IP地址 */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    } elseif (isset($_SERVER['HTTP_HOST'])) {
        $host = $_SERVER['HTTP_HOST'];
    } else {
        /* 端口 */
        if (isset($_SERVER['SERVER_PORT'])) {
            $port = ':' . $_SERVER['SERVER_PORT'];

            if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol)) {
                $port = '';
            }
        } else {
            $port = '';
        }

        if (isset($_SERVER['SERVER_NAME'])) {
            $host = $_SERVER['SERVER_NAME'] . $port;
        } elseif (isset($_SERVER['SERVER_ADDR'])) {
            $host = $_SERVER['SERVER_ADDR'] . $port;
        }
    }

    return $protocol . $host;
}

function get_http()
{
    return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
}

function filter_ma_request_mapi(&$str)
{
    $search = array("../", "\n", "\r", "\t", "\r\n", "'", "<", ">", "\"", "%", "\\", ".", "/");
    return str_replace($search, "", $str);
}

function strim_mapi($str)
{
    return quotes_mapi(htmlspecialchars(trim($str)));
}

function quotes_mapi($content)
{
    //if $content is an array
    if (is_array($content)) {
        foreach ($content as $key => $value) {
            //$content[$key] = mysql_real_escape_string($value);
            $content[$key] = addslashes($value);
        }
    } else {
        //if $content is not an array
        //$content=mysql_real_escape_string($content);
        $content = addslashes($content);
    }
    return $content;
}


//过滤null 把null改为空;
function filter_null(&$request)
{
    foreach ($request as $k => $v) {

        if (is_array($v)) {
            filter_null($request[$k]);
        } else {
            if (is_null($v)) {
                $request[$k] = '';
            }
        }
    }
}

function strim($str)
{
    return quotes(htmlspecialchars(trim($str)));
}

function quotes($content)
{
    //if $content is an array
    if (is_array($content)) {
        foreach ($content as $key => $value) {
            //$content[$key] = mysql_real_escape_string($value);
            $content[$key] = addslashes($value);
        }
    } else {
        //if $content is not an array
        //$content=mysql_real_escape_string($content);
        $content = addslashes($content);
    }
    return $content;
}


