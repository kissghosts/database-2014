<?php

/* 
 * php func to generate common view components
 * 
 * NOTE: most of the view components are put in folder "views"
 */

function gen_simple_context($header, $paragraph) {
  require dirname(__FILE__) . '/../views/simple_context_body.php';
}

function gen_html_redirect_header($path, $url, $time) {
  require dirname(__FILE__).'/../views/html_redirect_header.php';
}

function html_alert_info($title, $msg) {
  require dirname(__FILE__).'/../views/html_alert_info.php';
}

function gen_login_form($email, $path) {
  require dirname(__FILE__).'/../views/login_form.php';
}
