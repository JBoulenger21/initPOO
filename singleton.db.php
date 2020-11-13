<?php

class SPDO
{
  private $PDOInstance = null;
  private static $_instance = null;

  const DEFAULT_SQL_USER = 'root';
  const DEFAULT_SQL_HOST = 'localhost';
  const DEFAULT_SQL_PASS = '';
  const DEFAULT_SQL_DTB = 'personnage';

  private function __construct(){
    $this->PDOInstance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);
  }

  public static function getInstance()
  {
    if(is_null(self::$_instance))
    {
      self::$_instance = new SPDO();
    }
    return self::$_instance;
  }
  public function prepare($query)
  {
    $ret = $this->PDOInstance->prepare($query);
    if ($ret == false)
    {
      print_r($this->PDOInstance->errorInfo());
    }
    return $ret;
  }
}

 ?>
