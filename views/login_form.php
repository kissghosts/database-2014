<div class="container col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
  <form method="post" action="<?php echo "$path"; ?>login.php" accept-charset="UTF-8">
    <h2 class="form-signin-heading">Please sign in</h2>
    <input required type="email" placeholder="Email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
    <input type="password" placeholder="Password" id="password" name="password" class="form-control" required>
    <label class="checkbox">
      <input type="checkbox" name="remember-me" id="remember-me" value="1"> Remember me
    </label>
    <input class="btn btn-primary btn-block" type="button" id="sign-in" name="sign-in" value="Sign In" onclick="signin_form_hash(this.form, this.form.password);" />
    <br>
  </form>
  <p><strong>testing account</strong><br>staff: </p>
  <div class="alert alert-info">
    Email: staff@test.com, Passwd: 123456
  </div>
  <p>customer: </p>
  <div class="alert alert-info">
    Email: customer@test.com, Passwd: 123456
  </div>
</div> <!-- /container -->
