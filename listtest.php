<?php

require_once "lib/db.php";
require_once "lib/classes/user.php";

function get_all_users() {
  $sql = "SELECT fname, email FROM users";
  $query = get_database_connection()->prepare($sql);
  $query->execute();
    
  $results = array();
  foreach($query->fetchAll(PDO::FETCH_OBJ) as $r) {
    $user = new User();
    $user->set_fname($r->fname);
    $user->set_email($r->email);

    $results[] = $user;
  }
  return $results;
}

  $users = get_all_users();

?><!DOCTYPE HTML>
<html>
  <head><title>Title</title></head>
  <body>
    <h1>list element test</h1>
    <ul>
    <?php foreach($users as $user) {
      $fname = $user->get_fname();
      $email = $user->get_email(); ?>
      <li><?php echo "First name: $fname, Email: $email"; ?></li>
      <?php } ?>
    </ul>
  </body>
</html>
