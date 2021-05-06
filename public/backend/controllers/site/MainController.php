<?php 

namespace backend\controllers\site;
use backend\core\Controller;


class MainController extends Controller {
  public function indexAction()
  {

    $title = $this->config['PROJECT_NAME'];
    $this->view->render($title);
  }
  public function helpAction()
  {
    $title = $this->config['PROJECT_NAME'];
    $this->view->render($title);
  }
}
