<?php

namespace backend\controllers\site;

use backend\core\Controller;


class MerchantController extends Controller
{
  public function donateAction()
  {
    $title = $this->config['PROJECT_NAME'];
    $this->view->render($title);
  }
  public function payeerAction()
  {
    $title = $this->config['PROJECT_NAME'];
    $this->view->render($title);
  }
  public function requisitesAction()
  {
    $title = $this->config['PROJECT_NAME'];
    $this->view->render($title);
  }
}
