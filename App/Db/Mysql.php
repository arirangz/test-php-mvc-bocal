<?php


namespace App\Db;


class Mysql
{
    private static $_instance = null;
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $db_port;
    private $pdo;

    public function __construct() {
        $conf = require _ROOTPATH_.'/config.php';

        if (isset($conf['db_name'])) {
            $this->db_name = $conf['db_name'];
        }
        if (isset($conf['db_user'])) {
            $this->db_user = $conf['db_user'];
        }
        if (isset($conf['db_pass'])) {
            $this->db_pass = $conf['db_pass'];
        }
        if (isset($conf['db_host'])) {
            $this->db_host = $conf['db_host'];
        }
        if (isset($conf['db_port'])) {
            $this->db_port = $conf['db_port'];
        }

  /*
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
  */
    }

    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Mysql();
        }

        return self::$_instance;
    }

    public function getPDO(){
        if($this->pdo === null){
            $pdo = new \PDO('mysql:dbname=' . $this->db_name . ';charset=utf8;host=' . $this->db_host.':'.$this->db_port, $this->db_user, $this->db_pass);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

}