<?php

/* 
 * php func to generate common view components
 * 
 * NOTE: all the html view template are put in folder "views"
 *       here are some generic wrappers of them with args required
 */

// a simple html paragraph
function gen_simple_context($header, $paragraph) {
  require dirname(__FILE__) . '/../views/simple_context_body.php';
}

// html header with automatically redirection
function gen_html_redirect_header($path, $url, $time) {
  require dirname(__FILE__).'/../views/html_redirect_header.php';
}

// simple bootstrap alert message
// mainly for error message display
function html_alert_info($title, $msg) {
  require dirname(__FILE__).'/../views/html_alert_info.php';
}

// html form for user login
function gen_login_form($email, $path) {
  require dirname(__FILE__).'/../views/login_form.php';
}

/* generate a page to show simple message, and automatically redirect
 * input: $path will be used with in some html template
 *        $page is the redirecting destination page
 *        $time is the time before redirecting
 *        $msg is the message to show (mainly for error message before redirection)
 *        $title is head sentence for this page
 * 
 */
function redirect_page($path, $page, $time, $msg, $title) {
  gen_html_redirect_header($path, $page, $time);
  require dirname(__FILE__).'/../views/simple_navbar.php';
  gen_simple_context($title, $msg);
  require dirname(__FILE__).'/../views/html_footer.php';
}