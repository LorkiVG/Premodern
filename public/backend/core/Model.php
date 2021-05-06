<?php 

namespace backend\core;

use backend\lib\DbConnector;



abstract class Model {
  public $db;

  public function __construct() {
    $this->db = new DbConnector;
    
  }
}