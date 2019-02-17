<?php
class Database
{
  public static function connect()
  {
    $dsn = 'mysql:dbname=main;host=localhost';
    $user = 'root';
    $password = '';
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
