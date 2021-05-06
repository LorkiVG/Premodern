<?php 

namespace backend\core;
use backend\lib\Settings;


class View {
  
  public $path;
  

  public function __construct($params,$config) {
    $this->params = $params; 
    $this->config = $config;
    $this->path = 'templates/'.$params['app'].'/'.$params['controller'].'/'.$params['action'];    
  }

  public function render($title , $vars = [], $layout = 'default')
  {
    extract($vars);
    if (file_exists('backend/views/'.$this->path.'.php')) {
      ob_start();
      require 'backend/views/'.$this->path.'.php';
      $view = ob_get_clean();
      $style_general = '/frontend/css/'.$this->params['app'].'/'.$this->params['controller'].'/'.'gl_'.$this->params['controller'].'_style.min.css';
      $style = '/frontend/css/'.$this->params['app'].'/'.$this->params['controller'].'/'.$this->params['action'].'.min.css';
      $js = '/frontend/js/'.$this->params['app'].'/'.$this->params['controller'].'/'.$this->params['action'].'.min.js';
      require 'backend/views/layouts/'.$layout.'.php';
      

    } else {
      View::renderErrors(404,'Не найдена view '.$this->params['action'].',возможно ее нужно создать в '.'backend/views/'.$this->path.'.php' ,'Страница не найдена',$this->config['PROJECT_NAME']);

    }
    
  }


  public function redirect($url)
  {
    header("location: $url");
    exit;
  }

  public static function renderErrors($status_error, $messageDev, $messageProd ,$title)
  {
    $page = 'prod';
    $message = $messageProd;
    $style = '/frontend/css/prod_errors.css';
    if (Settings::Loader('DEBUG_MODE')) {
      $message = $messageDev;
      $page = 'dev';
      $style = '/frontend/css/dev_errors.css';
    }
    http_response_code($status_error);
    ob_start();
    require "backend/views/templates/error/$page.php";
    $view = ob_get_clean();
    require 'backend/views/layouts/error.php';
  }

  public function message($status, $message) 
  {
		exit(json_encode(['status' => $status, 'message' => $message]));
  }
  public function jsonDecode($array)
  {
    exit(json_encode($array));
  }
  public static function messageStatic ($status, $message) {
    exit(json_encode(['status' => $status, 'message' => $message]));
  }
	public function location($url) {
		exit(json_encode(['url' => $url]));
	}
}
?>