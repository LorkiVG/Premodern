<?php 

namespace backend\core;



abstract class Controller {
  

  public $params;
  public $view;
  public $config;
  public $app;
  public function __construct($params,$config) {
    $this->params = $params;
    $this->app = $params['app'];
    $this->config = $config;
    if (!$this->checkAcl()) {
      View::renderErrors(403,'Нет доступа ','Страница не найдена',$this->config['PROJECT_NAME']);
      die;
    }
    $this->view = new View($params,$config);
    $this->model = $this->loadModel($params['controller']);
  
  }
  public function loadModel($name)
  {
    $path = 'backend\models\\'.$this->app.'\\'.ucfirst($name);
    if (class_exists($path)) {
      return new $path;
    }
  }
  public function checkAcl() {
    //!CONFIGS ACL require!!!
    //!PAGINATOR КАК У ХАУДИ ИЛИ ВИДЕОУРОКИ PHP
    //!ПОСМОТРИ БЛОКНОТ И ПЛАНЫ
		$this->acl = require 'backend/acl/'.$this->app.'/'.$this->params['controller'].'.php';
		if ((isset($_SESSION['authorize']['id']) or !isset($_SESSION['authorize']['id'])) and $this->isAcl('all')) {
			return true;
		}
		elseif (isset($_SESSION['authorize']['id']) and $this->isAcl('authorize')) {
			return true;
		}
		elseif (!isset($_SESSION['authorize']['id']) and $this->isAcl('guest')) {
			return true;
		}
		elseif ($this->isAcl('admin')) {
      if (isset($_SESSION['authorize']['is_admin'])) {
        if ($_SESSION['authorize']['is_admin'] == 1) {
          return true;
        }
      }
    }
    elseif ($this->isAcl('admin_active')) {
      if (isset($_SESSION['admin_active'])) {
        if ($_SESSION['admin_active'] == 1) {
          return true;
        }
      }
      if (isset($_SESSION['authorize']['is_admin'])) {
        if ($_SESSION['authorize']['is_admin'] == 1) {
          return true;
        }
      }
    }
		return false;
	}

	public function isAcl($key) {
		return in_array($this->params['action'], $this->acl[$key]);
	}
}

?>