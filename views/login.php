<?php
  require_once('../lib/view_components.php');

  gen_html_header('Shopping Cart', '../');
  gen_simple_navbar('../');
?>

<div class="container col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
  <form method="post" action="../process_login.php" accept-charset="UTF-8">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input type="email" class="form-control" placeholder="Email" required autofocus id="email" name="email">
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
    <label class="checkbox">
      <input type="checkbox" name="remember-me" id="remember-me" value="1"> Remember me
    </label>
    <input class="btn btn-primary btn-block" type="button" id="sign-in" name="sign-in" value="Sign In" onclick="signin_form_hash(this.form, this.form.password);" />
    <br>
  </form>
</div> <!-- /container -->

<?php 
gen_footer_with_form_hash('../');
?>