<!DOCTYPE html>
<html>
  <head><title>Login Test</title></head>
  <body>
    <h1>display login input post</h1>
    <p>
      <?php
        if (isset($_POST['email'], $_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            echo "Email: $email, Password: $password";
        } else {
            // The correct POST variables were not sent to this page. 
            echo 'Invalid Request';
        }
      ?>
    </p>
  </body>
</html>



