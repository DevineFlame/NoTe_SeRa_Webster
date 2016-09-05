<?php

function get_ip($as_integer = false) {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (CONFIG_TRUST_HTTP_X_FORWARDED_FOR_IP && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // in almost all cases, there will only be one IP in this header
        if (is_valid_ip($_SERVER['HTTP_X_FORWARDED_FOR'], true)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // in the rare case where several IPs are listed
        else {
            $forwarded_for_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($forwarded_for_list as $forwarded_for) {
                $forwarded_for = trim($forwarded_for);
                if (is_valid_ip($forwarded_for, true)) {
                    $ip = $forwarded_for;
                    break;
                }
            }
        }
    }

    if ($as_integer) {
        return inet_aton($ip);
    } else {
        return $ip;
    }
}

function requested_file_name () {
    $pathinfo = pathinfo($_SERVER['SCRIPT_NAME']);
    return $pathinfo['filename'];
}

function referer_name () {
    $pathinfo = pathinfo($_SERVER['HTTP_REFERER']);
    return $pathinfo['filename'];
}


function inet_aton ($ip) {
    return sprintf('%u', ip2long($ip));
}

function inet_ntoa ($num) {
    return long2ip(sprintf('%d', $num));
}

function is_valid_ip($ip, $public_only = false) {
    // we only want public, non-reserved IPs
    if ($public_only) {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return true;
        } else {
            return false;
        }
    }

    // allow non-public and reserved IPs
    else {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        } else {
            return false;
        }
    }
}

function validate_url ($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        log_exception(new Exception('Invalid URL in redirect: ' . $url));
        message_error('Invalid redirect URL. This has been reported.');
    }
}

function date_time($timestamp = false, $specific = 6) {

    if($timestamp === false) {
        $timestamp = time();
    }

    $specific = substr('Y-m-d H:i:s', 0, ($specific*2)-1);

    return date($specific, $timestamp);
}

function button_link($text, $url) {
    return '<a href="'.htmlspecialchars($url).'" class="btn btn-xs btn-primary">'.htmlspecialchars($text).'</a>';
}

function array_get ($array, $key, $default = null) {
    return isset($array[$key]) ? $array[$key] : $default;
}

function array_search_matching_key ($needle, $haystack, $key) {
    foreach ($haystack as $element) {
        if (array_get($element, $key) === $needle) {
            return $element;
        }
    }

    return false;
}
//_________________________________________

function check_session($var){
	return isset($_SESSION["$var"]);
}

function redirect($url){
	header("location:$url");
}

function br(){
	echo "<br/>";
}
function get_sess_var($var){
	if(check_session($var))
		return $_SESSION["$var"];
	return "[$var not set]";
}
function get_file_name(){
	$uri=explode('/',$_SERVER['PHP_SELF']);
	return $uri[sizeof($uri)-1];
}
?>