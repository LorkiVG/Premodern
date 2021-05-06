<?php 

namespace backend\controllers\admin;
use backend\core\Controller;
use backend\lib\TimeManager;


class AdminController extends Controller {
  public function playersAction()
  {
    if (isset($_SESSION['admin_active'])) {
      if ($_SESSION['admin_active'] != 1) {
        $this->view->redirect("/admin/login");
      }
    } else {
      $this->view->redirect("/admin/login");
    }
    $params = [];
    if(!empty($_GET['player'])) {
      
      $players = $this->model->getPlayerByNick($_GET['player']);
      if (!empty($players)) {
        $params = [
          'players' => $players
        ];
      }
      
    } else {
      $players = $this->model->getPlayers();
      $params = [
        'players' => $players
      ];
    } 
    
    $title = $this->config['PROJECT_NAME'] . ' Игроки';
    $this->view->render($title,$params);
  }
  public function indexAction()
  {
    if (isset($_SESSION['admin_active'])) {
      if ($_SESSION['admin_active'] != 1) {
        $this->view->redirect("/admin/login");
      }
    } else {
      $this->view->redirect("/admin/login");
    }

    $title = $this->config['PROJECT_NAME'] . ' ADMIN';
    $this->view->render($title);
  }
  public function othersAction()
  {
    if (isset($_SESSION['admin_active'])) {
      if ($_SESSION['admin_active'] != 1) {
        $this->view->redirect("/admin/login");
      }
    } else {
      $this->view->redirect("/admin/login");
    }

    $title = $this->config['PROJECT_NAME'] . ' OTHERS';
    $this->view->render($title);
  }
  public function getSkinByPlayerAction()
  {
    if (isset($_SESSION['admin_active'])) {
      if ($_SESSION['admin_active'] != 1) {
        $this->view->redirect("/admin/login");
      }
    } else {
      $this->view->redirect("/admin/login");
    }
    if (empty($_GET['n'])) {
      $this->view->jsonDecode(['status' => 'error', 'response' => 'error']);
    }
    if (empty($_GET['p'])) {
      $this->view->jsonDecode(['status' => 'error', 'response' => 'error']);
    }
    if (!preg_match('#^[0-9]$#', $_GET['n'])) {
      $this->view->jsonDecode(['status' => 'error', 'response' => 'error']);
    }
    $config_skins = require 'backend/settings/configs/config_skin.php';
    $skins_max = $config_skins['max_skins'];
    $id = $_SESSION['authorize']['id'];
    $skin_num = $_GET['n'];
    if ($skin_num > $skins_max) {
      $this->view->jsonDecode(['status' => 'error', 'response' => 'error']);
    }

    $file = $this->model->getSkinFilePathByPlayer($_GET['p'], $_GET['n']);

    $file_path = "/frontend/img/skins/$id/$skin_num/$file.png";

    if ($file != '' and $file != 'base') {
      $this->view->jsonDecode(['status' => 'success', 'response' => $file_path]);
    } elseif ($file == 'base') {
      $this->view->jsonDecode(['status' => 'success', 'response' => '/frontend/img/skins/base.png']);
    } else {
      $this->view->jsonDecode(['status' => 'success', 'response' => 'none']);
    }
  }
  public function editPlayerAction()
  {
    if (isset($_SESSION['admin_active'])) {
      if ($_SESSION['admin_active'] != 1) {
        $this->view->redirect("/admin/login");
      }
    } else {
      $this->view->redirect("/admin/login");
    }
    if (empty($_GET['player'])) {
      $this->view->redirect("/admin/players");
    }
    $data_keys = require_once "backend/settings/configs/config_captha.php";
    $public_key = $data_keys['public_key'];
    $token_hash = $this->model->tokenCreate();
    $inviolability_status = $this->model->getInviolabilityStatus($_GET['player']);
    $admin_status = $this->model-> getAdminStatus($_GET['player']);
    $player_params = $this->model->getPlayerByNick($_GET['player']);
    if (!empty($_POST)) {
      if ($this->model->botCheck($_POST['g-recaptcha-response'])) {
        $this->view->message('error', 'Повторите попытку.');
      } elseif ($this->model->checkCsrfToken($_POST['security_token'], $_SESSION['csrf_token'])) {
        $this->view->message('error', 'Ошибка безопастности');
      } elseif ($inviolability_status == 1) {
        $this->view->message('error', 'Запрещены действия с неприкосновенными');
      } elseif ($admin_status == 1 and $_SESSION['authorize']['inviolability'] != 1 ) {
        $this->view->message('error', 'Нет прав на действия с администратором');
      }
      if ($_POST['name'] == "unban") {
        $this->model->unban($_GET['player']);
        $this->view->message('success', 'Игрок '.$_GET['player'].' успешно разбанен');
      } elseif ($_POST['name'] == "ban_forever") {
        $this->model->setBanForever($_GET['player'],$_POST['ban_reason']);
        $this->view->message('success', 'Игрок ' . $_GET['player'] . ' успешно забанен навсегда');
      } elseif ($_POST['name'] == "ban_before_time") {
        if (TimeManager::validateDateFormat($_POST['before_time'])) {
          $this->model->setBanBeforeTime($_GET['player'], $_POST['ban_reason'], $_POST['before_time']);
          $this->view->message('success', 'Игрок ' . $_GET['player'] . ' успешно забанен до '. $_POST['before_time']);
        } else {
          $this->view->message('error', "Неверно введен формат времени");
        }
        
        $this->model->setBanForever($_GET['player'], $_POST['ban_reason']);
      } elseif ($_POST['name'] == "plus_warn") {
        $this->model->setWarn($_GET['player']);
        $this->view->message('success', 'Игроку ' . $_GET['player'] . ' успешно добавлен варн.Теперь у него ' . $this->model->getWarns($_GET['player']) .' '.'варнов');
      } elseif ($_POST['name'] == "minus_warn") {
        if ($this->model->getWarns($_GET['player']) > 0) {
          $this->model->unsetWarn($_GET['player']);
          $this->view->message('success', 'Игроку ' . $_GET['player'] . ' успешно убран варн.Теперь у него ' . $this->model->getWarns($_GET['player']) . ' ' . 'варнов');
        } else {
          $this->view->message('success', 'Игроку нельзя отнять варн.Так как у него их нет.');
        }
      }

    }
    $params = [
      'player' => $player_params,
      'public_key_recaptha' => $public_key,
      'csrf_token' => $token_hash,
    ];
    $title = $this->config['PROJECT_NAME'] . ' EDIT PLAYER';
    $this->view->render($title,$params);
  }
  public function loginAction()
  {
    $data_keys = require_once "backend/settings/configs/config_captha.php";
    $public_key = $data_keys['public_key'];
    $token_hash = $this->model->tokenCreate();
    $params = [
      'public_key_recaptha' => $public_key,
      'csrf_token' => $token_hash,
    ];
    if (!empty($_POST)) {
      if ($this->model->botCheck($_POST['g-recaptcha-response'])) {
        $this->view->message('error', 'Повторите попытку.');
      } elseif ($this->model->checkCsrfToken($_POST['security_token'], $_SESSION['csrf_token'])) {
        $this->view->message('error', 'Ошибка безопастности');
      } elseif (!$this->model->login(trim($_POST['password']))) {
        $this->view->message('error', 'Пароль неверен!');
      } else {
        $this->view->location("admin");
      }
      
    }
    $title = $this->config['PROJECT_NAME'].' ADMIN Логин';
    $this->view->render($title,$params);
  }
  public function logoutAction()
  { 
    if (isset($_SESSION['admin_active'])) {
      if ($_SESSION['admin_active'] != 1) {
        $this->view->redirect("/admin/login");
      } else {
        $_SESSION['admin_active'] = 0;
        $this->view->redirect('/profile');
      }
    }    
  }
  public function statisticAction()
  {
    if (isset($_SESSION['admin_active'])) {
      if ($_SESSION['admin_active'] != 1) {
        $this->view->redirect("/admin/login");
      }
    } else {
      $this->view->redirect("/admin/login");
    }
    $data = "";
    $count = $this->model->getStatisticCount();
    if (empty($_GET['n'])) {
      if ($count < 7) {
        $data = $this->model->getAllDataStatistic();
      } else {
        $data = $this->model->getDataStatistic($count,7);
      }
    } else {
      if (is_numeric($_GET['n'])) {
        if ($count < intval($_GET['n'])) {
          $data = $this->model->getAllDataStatistic();
        } else {
          $data = $this->model->getDataStatistic($count, $_GET['n']);
        }
      } else {
        if ($_GET['n'] == "all") {
          $data = $this->model->getAllDataStatistic();
        } else {
          if ($count < 7) {
            $data = $this->model->getAllDataStatistic();
          } else {
            $data = $this->model->getDataStatistic($count, 7);
          }
        }
      }
    }
    $title = $this->config['PROJECT_NAME'] . ' Статистика';
    $labels = [];
    $quantity = [];
    
    foreach ($data as $key => $value) {
      array_push($labels,$value['date']);
    }
    foreach ($data as $key => $value) {
      array_push($quantity,$value['quantity']);
    }
    $params = [
      'labels' => $labels,
      'quantity' => $quantity,
    ];
    $this->view->render($title,$params);
  }
}