<?php

class DB
{
  private static $link;

  static function l()
  {
    if (!self::$link) {

      if ($_SERVER['HTTP_HOST'] == "utv3.dev" || $_SERVER['HTTP_HOST'] == "localhost") {
        $sql_host = "localhost";
        $sql_user = "root";
        $sql_pw = "root";
        $sql_db = "umfragetool";
      } else {
        $sql_host = "rdbms.strato.de";
        $sql_user = "U2418813";
        $sql_pw = "umfragetool1";
        $sql_db = "DB2418813";
      }

      self::$link = new mysqli($sql_host, $sql_user, $sql_pw, $sql_db);
      self::$link->set_charset("utf8");
      self::$link->query("SET CHARACTER SET utf8");
      self::$link->query("SET NAMES utf8");
    }
    return self::$link;
  }
}