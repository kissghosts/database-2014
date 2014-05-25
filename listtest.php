<?php

require_once "lib/database-connection.php";
require_once "lib/classes/client.php";

function get_all_client() {
  $sql = "SELECT fname, email FROM client";
  $query = get_database_connection()->prepare($sql);
  $query->execute();
    
  $results = array();
  foreach($query->fetchAll(PDO::FETCH_OBJ) as $r) {
    $client = new Client();
    $client->set_fname($r->fname);
    $client->set_email($r->email);

    $results[] = $client;
  }
  return $results;
}

  $clients = get_all_client();

?><!DOCTYPE HTML>
<html>
  <head><title>Title</title></head>
  <body>
    <h1>list element test</h1>
    <ul>
    <?php foreach($clients as $client) {
      $fname = $client->get_fname();
      $email = $client->get_email(); ?>
      <li><?php echo "First name: $fname, Email: $email"; ?></li>
      <?php } ?>
    </ul>
  </body>
</html>
