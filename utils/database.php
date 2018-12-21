<?php
class Database
{
  public static function connect()
  {
    $dsn = 'mysql:dbname=main;host=127.0.0.1';
    $user = 'root';
    $password = 'modal';
    $dbh = null;
    try {
      $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Connection failed :' . $e->getMessage();
      exit(0);
    }
    return $dbh;
  }
}
?>
