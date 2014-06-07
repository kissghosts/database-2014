<?php

/* 
 * php func to generate common view components
 * 
 * NOTE: most of the view components are put in folder "views"
 */

function gen_simple_context($header, $paragraph) {
?>
<div class="container col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
  <?php 
    echo "<h1>$header</h1>";
    echo "<p class=\"lead\"><br>$paragraph</p>";
  ?>
</div><!-- /.container -->
<?php
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
