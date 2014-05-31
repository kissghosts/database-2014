<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#base-nav-bar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo "$path"; ?>index.php">SiipiLomat Oy</a>
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
            <form method="post" action="<?php echo "$path"; ?>login.php" accept-charset="UTF-8">
              <input style="margin-bottom: 15px;" type="email" placeholder="Email" id="email" name="email">
              <input style="margin-bottom: 15px;" type="password" placeholder="Password" id="password" name="password">
              <input style="float: left; margin-right: 10px;" type="checkbox" name="remember-me" id="remember-me" value="1">
              <label class="string optional" for="user_remember_me"> Remember me</label>
              <input class="btn btn-primary btn-block" type="button" id="sign-in" name="sign-in" value="Sign In" onclick="signin_form_hash(this.form, this.form.password);" />
              <br>
            </form>
          </div>
        </li>
        <li><a href="<?php echo "$path";?>signup.php">Sign Up</a></li>
        <?php }?>
       
      </ul>
      <form class="navbar-form navbar-right">
        <input type="text" class="form-control" placeholder="Search...">
      </form>
    </div>
  </div>
</div>