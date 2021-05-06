<?php 


class ErrorHandler
{
  public function __construct($settings,$config){
    $this->settings = $settings;
    $this->config = $config;
    if($settings['DEBUG_MODE']){
      error_reporting(-1);
    }else{
      error_reporting(0);
    }
    set_error_handler([$this, 'errorHandler']);
    ob_start();
    register_shutdown_function([$this, 'fatalErrorHandler']);
    set_exception_handler([$this, 'exceptionHandler']);
  }

  public function errorHandler($errno, $errstr, $errfile, $errline){
    $this->logErrors($errstr, $errfile, $errline);
    $this->displayError($errno, $errstr, $errfile, $errline);
    return true;
  }

  public function fatalErrorHandler(){
    $error = error_get_last();
    if( !empty($error) && $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR) ){
      $this->logErrors($error['message'], $error['file'], $error['line']);
      ob_end_clean();
      $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
    }else{
      ob_end_flush();
    }
  }

  public function exceptionHandler($e){
    $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
    $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
  }

  protected function logErrors($message = '', $file_error = '', $line = ''){
    $date_log =  date('Y-m-d');
    $time_log = date('H.i.s');
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $dir = 'backend/logs/ip-'.$ip.'/'.$date_log.'/';
    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }
    $file_name = "$dir/$time_log.log";
    
    $file = fopen($file_name,'w');
    
    error_log("User-Agent:$user_agent\nОшибка: {$message} | Файл: {$file_error}, | Строка: {$line}\n=============\n", 3,$file_name);
    fclose($file);
  }
  protected function displayError($errno,$errstr,$errfile,$errline,$response = 500)
  {
    http_response_code($response);
    $page = 'prod';
    $title = $this->config['PROJECT_NAME'];
    $style = "";
    
    if ($this->settings['DEBUG_MODE']) {
      $page = 'dev';
      $style = '/frontend/css/dev_errors.css';
    } else {
      $style = '/frontend/css/prod_errors.css';
    }
    
    ob_start();
    require "backend/views/templates/php_errors/$page.php";
    $view = ob_get_clean();
    require 'backend/views/layouts/error.php';
    die;
  }
}
?>