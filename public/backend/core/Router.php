<?php 
namespace backend\core;

class Router 
{
  
  protected $params = [];
  protected $apps = [];
  protected $config = [];


  public static function cutGetParamUrl($url)
  {
    return urldecode(preg_replace('/\?.*/iu','',$url));
  }

  public function __construct($apps,$config) {
    $this->apps = $apps;
    $this->config = $config;
    $this->run();
  }

  private function urlsConnected () {
    $total_urls = [];
    foreach ($this->apps as $app) {
      $urls = require 'backend/routes/'.$app.'/urls.php';
      foreach ($urls as $url) {
        array_push($url,$app);
        array_push($total_urls,$url);
      }
      
    }
    return $total_urls;
  }  
  


  private function run()
  {
    $total_urls = $this->urlsConnected();
    $urls_and_apps = [];
    
    
    if ($this->matchUrl($total_urls)) {
      
      
      $controller = 'backend\controllers\\'.$this->params['app'].'\\'.ucfirst($this->params['controller']).'Controller';
      

      if (class_exists($controller)) {
        
        $action = $this->params['action'].'Action';
        
        
        if (method_exists($controller,$action)) {
          
          $params = $this->params;
          
          $controller = new $controller($params,$this->config);
        
          $controller->$action();
        } else {
          View::renderErrors(404,'Не найден action '.$this->params['action'].',в контроллере '.$this->params['controller'],'Страница не найдена',$this->config['PROJECT_NAME']);
        }
      } else {
        View::renderErrors(404,'Не найден controller '.$this->params['controller'].',возможно нужно создать в app '.$this->params['app'],'Страница не найдена',$this->config['PROJECT_NAME']);
      }      
    } else {
      View::renderErrors(404,'Не найдена url ','Страница не найдена',$this->config['PROJECT_NAME']);
    }
  }

  protected function matchUrl($routes) {
    $url = trim($_SERVER['REQUEST_URI'],'/');

    foreach ($routes as $route) {
      $url = self::cutGetParamUrl($url);
      $route[0] = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route[0]);
      $route[0] = '#^'.$route[0].'$#';
      
      if (preg_match($route[0] ,$url)) {
          $params = ['controller' => $route[1],'action' => $route[2],'app' => $route[3]];        
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

}















