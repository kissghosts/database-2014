<?php

/* Func that returns a connection to a database PDO structure */
function get_database_connection() {
  static $connection = null; 
  
  if ($connection == null) { 
    $connection = new PDO('pgsql:');
    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }

  return $connection;
}