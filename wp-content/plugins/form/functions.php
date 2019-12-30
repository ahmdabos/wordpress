<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}
// create from email header
function form_from_header()
{
    if (!isset($from_email)) {
        $sitename = strtolower($_SERVER['SERVER_NAME']);
        if (substr($sitename, 0, 4) == 'www.') {
            $sitename = substr($sitename, 4);
        }
        return 'info@' . $sitename;
    }
}
// redirect if sending succeeded
function form_redirect_success()
{
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '?') == true) {
        $url_with_param = $current_url . "&formsp=success";
    } else {
        if (substr($current_url, -1) == '/') {
            $url_with_param = $current_url . "?formsp=success";
        } else {
            $url_with_param = $current_url . "/?formsp=success";
        }
    }
    return $url_with_param;
}
// redirect if sending failed
function form_redirect_error()
{
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '?') == true) {
        $url_with_param = $current_url . "&formsp=fail";
    } else {
        if (substr($current_url, -1) == '/') {
            $url_with_param = $current_url . "?formsp=fail";
        } else {
            $url_with_param = $current_url . "/?formsp=fail";
        }
    }
    return $url_with_param;
}
