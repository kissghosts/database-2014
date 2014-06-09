<div class="container col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
  <h1>Sign Up</h1>
  <form method="post" action="<?php echo "$path"; ?>process_signup.php" accept-charset="UTF-8" class="form-horizontal" role="form">
    <fieldset>
      <!-- Form Name -->
      <legend></legend>

      <div class="form-group row">
        <label class="col-sm-2 control-label" for="textinput">First Name</label>
        <div class="col-sm-4">
          <input type="name" class="form-control" id="fname" name="fname" value="<?php if (isset($fname)) {echo $fname;} ?>">
        </div>

        <label class="col-sm-2 control-label" for="textinput">Sur Name</label>
        <div class="col-sm-4">
          <input type="name" class="form-control" id="lname" name="lname" value="<?php if (isset($lname)) {echo $lname;} ?>">
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-sm-2 control-label" for="textinput">Email</label>
        <div class="col-sm-4">
          <input type="email" placeholder="example@abc.com" class="form-control" id="email" name="email" value="<?php if (isset($email)) {echo $email;} ?>">
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group row">
        <label class="col-sm-2 control-label" for="textinput">Password</label>
        <div class="col-sm-4">
          <input type="password" placeholder="max 20 chars" class="form-control" id="passwd" name="passwd">
        </div>
      </div>

      <div class="form-group row">                
        <label class="col-sm-2 control-label" for="textinput">Confirm Password</label>
        <div class="col-sm-4">
          <input type="password" placeholder="your password again" class="form-control" id="passwd2" name="passwd2">
        </div>
      </div>

      <div>
        <div class="col-xs-3 pull-right">
          <input type="button" value="Submit" class="btn btn-primary btn-block" onclick="signup_form_hash(this.form, this.form.email, this.form.fname, this.form.lname, this.form.passwd, this.form.passwd2);" /> 
        </div>
      </div>

    </fieldset>
  </form>
</div> <!-- /container -->
