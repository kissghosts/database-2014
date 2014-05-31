<?php

/* 
 * php func to generate common view components
 * 
 * NOTE: most of the view components are put in folder "views"
 */

require_once "db.php";

function get_all_categories() {
  $sql = "SELECT DISTINCT category FROM products ORDER BY category";
  $query = get_db_connection()->prepare($sql);
  $query->execute();
    
  $rows = $query->fetchAll();
  foreach($rows as $row) {
    echo "<li><a href=\"#\">$row</a></li>";
  }
}

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

function gen_html_redirect_header($title, $path, $url, $time) {
?>

<!DOCTYPE html>

<!-- // the following html header includes refresh meta -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="<?php echo "$time; url=$url"; ?>">
    <link rel="shortcut icon" href="ico/favicon.ico">
    <title>Shopping Cart</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>

<?php
}

function html_alert_info($title, $msg) { ?>
<br>
<div class="alert alert-danger col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
  <strong><?php echo "$title"; ?></strong> <?php echo "$msg"; ?>
</div>

<?php
}

function gen_login_form($emial, $path) { ?>

<div class="container col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
  <form method="post" action="<?php echo "$path"; ?>login.php" accept-charset="UTF-8">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="email" class="form-control" id="email" name="email" value="<?php echo "$email"; ?>">
    <input type="password" id="password" name="password" class="form-control" required>
    <label class="checkbox">
      <input type="checkbox" name="remember-me" id="remember-me" value="1"> Remember me
    </label>
    <input class="btn btn-primary btn-block" type="button" id="sign-in" name="sign-in" value="Sign In" onclick="signin_form_hash(this.form, this.form.password);" />
    <br>
  </form>
</div> <!-- /container -->
<?php
}
