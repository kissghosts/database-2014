<?php

/* 
 * php func to generate common view components
 */

require_once "db.php";

function gen_html_header($title, $path) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<?php
    echo "<link rel=\"shortcut icon\" href=\"".$path."ico/favicon.ico\">";
?>
    <title>Shopping Cart</title>

    <!-- Bootstrap core CSS -->
<?php
    echo "<link href=\"".$path."css/bootstrap.css\" rel=\"stylesheet\">";
    echo "<link href=\"".$path."css/style.css\" rel=\"stylesheet\">";
?>
  </head>
<body>
<?php
}

function get_all_categories() {
  $sql = "SELECT DISTINCT category FROM products ORDER BY category";
  $query = get_db_connection()->prepare($sql);
  $query->execute();
    
  $rows = $query->fetchAll();
  foreach($rows as $row) {
    echo "<li><a href=\"#\">$row</a></li>";
  }
}

function gen_product_sidebar() {
?>
<div class="col-sm-3 col-md-2 sidebar">
  <div class="well nav-sidebar">
    <ul class="nav nav-list">
      <li class="nav-header">Product Categories</li>
      <?php get_all_categories()?>
    </ul>
  </div>
</div>
<?php
}

function gen_navbar($path) {
?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#base-nav-bar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo "$path"; ?>views/home.php">SiipiLomat Oy</a>
    </div>
    <div class="navbar-collapse collapse" id="base-nav-bar">
      <ul class="nav navbar-nav navbar-right">
      <?php if (isset($_SESSION['valid_user'])) { ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">User Info</a></li>
            <li><a href="#">Orders</a></li>
          </ul>
        </li>
        <li><a href="#">Shopping Cart </a></li>
        <li><a href="<?php echo "$path"; ?>logout.php">Log Out</a></li>
      <?php } else { ?>
        <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <b class="caret"></b></a>
          <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
            <form method="post" action="<?php echo "$path"; ?>process_login.php" accept-charset="UTF-8">
              <input style="margin-bottom: 15px;" type="email" placeholder="Email" id="email" name="email">
              <input style="margin-bottom: 15px;" type="password" placeholder="Password" id="password" name="password">
              <input style="float: left; margin-right: 10px;" type="checkbox" name="remember-me" id="remember-me" value="1">
              <label class="string optional" for="user_remember_me"> Remember me</label>
              <input class="btn btn-primary btn-block" type="button" id="sign-in" name="sign-in" value="Sign In" onclick="signin_form_hash(this.form, this.form.password);" />
              <br>
            </form>
          </div>
        </li>
        <li><a href="<?php echo "$path";?>views/signup.php">Sign Up</a></li>
        <?php }?>
       
      </ul>
      <form class="navbar-form navbar-right">
        <input type="text" class="form-control" placeholder="Search...">
      </form>
    </div>
  </div>
</div>
  
<?php
}

function gen_footer($path) {
?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo "$path"; ?>js/bootstrap.min.js"></script>
  </body>
</html>
<?php
}

function gen_footer_with_form_hash($path) {
?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo "$path"; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo "$path"; ?>js/sha256.js"></script>
    <script src="<?php echo "$path"; ?>js/common.js"></script>
  </body>
</html>
<?php
}

function gen_simple_navbar($path) { ?>
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#base-nav-bar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo "$path"; ?>views/home.php">SiipiLomat Oy</a>
      </div>
    </div>
  </div>
<?php
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
