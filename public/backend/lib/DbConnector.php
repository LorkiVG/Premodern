<?php 
  namespace backend\lib;
  use PDO;
  use backend\core\View;


  class DbConnector
  {
    public $db;


    public function __construct()
    {
      $config = Config::DbLoaderConfig();
      $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['db_name'],$config['username'].'', $config['password']);
      

    }

    public function query($sql,$params = [])
    {
      
      
      $stmt = $this->db->prepare($sql);
      if (!empty($params)) {
        foreach ($params as $key => $val) {
          $stmt->bindValue(':'.$key ,$val);
        }
      }
      $stmt->execute();
      return $stmt;
    }
    public function row($sql,$params = [])
    {
      $result = $this->query($sql,$params);
      return $result->fetchAll(Settings::Loader('PDO_FETCH_METHOD'));
    }
    public function column($sql,$params = [])
    {
      $result = $this->query($sql,$params);
      return $result->fetchColumn();
    }
    
  }
  
?>