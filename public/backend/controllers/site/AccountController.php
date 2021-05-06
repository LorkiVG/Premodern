<?php 

namespace backend\controllers\site;
use backend\core\Controller;



class AccountController extends Controller {
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
      }
      elseif ($this->model->checkCsrfToken($_POST['security_token'],$_SESSION['csrf_token'])) {
        $this->view->message('error','Ошибка безопастности');
      }
      elseif (!$this->model->validatePost(['login', 'password'], $_POST)) {
				$this->view->message('error', $this->model->error);
      } 
			elseif (!$this->model->passwordVerify($_POST['login'], $_POST['password'])) {
				$this->view->message('error', 'Логин или пароль указан неверно.');
      }
      elseif ($this->model->banCheck($_POST['login'])) {
        $this->view->message('error', 'Аккаунт заблокирован.Вход запрещен!');
      }
			elseif (!$this->model->checkStatus('login', $_POST['login'])) {
				$this->view->message('error', $this->model->error);
			}
			$this->model->login($_POST['login']);
			$this->view->location('profile');
		}
    $this->view->render($this->config['PROJECT_NAME'].' Вход',$params);
  }

  public function registerAction()
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
      }
      elseif ($this->model->checkCsrfToken($_POST['security_token'],$_SESSION['csrf_token'])) {
        $this->view->message('error','Ошибка безопастности');
      } 
      elseif (!$this->model->validatePost(['login', 'email',  'password', 'password_repeat'], $_POST)) {
        $this->view->message('error', $this->model->error);
      } 
      elseif (empty($_POST['checker'])) {
        $this->view->message('error', 'Согласитесь с Условиями Пользования!');
      }
      elseif (!$this->model->checkLoginExists($_POST['login'])) {
				$this->view->message('error', 'Логин уже используется');
      }
			elseif ($this->model->checkEmailExists($_POST['email'])) {
        $this->view->message('error','Этот E-mail уже используется');
			}
      elseif (!$this->model->checkPasswordRepeat($_POST['password'],$_POST['password_repeat'])) {
        $this->view->message('error','Пароли не совпадают');
			}
			$this->model->register($_POST);
    }
    
    $this->view->render($this->config['PROJECT_NAME'].' Регистрация',$params);
  }
  public function logoutAction() {
    unset($_SESSION['authorize']);
    $_SESSION['admin_active'] = 0;
		$this->view->redirect('/login');
  }
  
  public function profileAction() {
    $data_keys = require_once "backend/settings/configs/config_captha.php";
    $public_key = $data_keys['public_key'];
    $token_hash = $this->model->tokenCreate();
    $params = [
      'public_key_recaptha' => $public_key,
      'csrf_token' => $token_hash,
    ];
    if (!empty($_POST)) {
      //*Security
      if ($this->model->botCheck($_POST['g-recaptcha-response'])) {
        $this->view->message('error', 'Повторите попытку.');
      } elseif ($this->model->checkCsrfToken($_POST['security_token'], $_SESSION['csrf_token'])) {
        $this->view->message('error', 'Ошибка безопастности');
      }
      
      if ($_POST['form_name'] == 'general_settings') {
        //*Filter form "New general settings"
        $to_validate = ['login'];
        if (!empty($_POST['email'])) {
          $to_validate =['login','email'];
        }
        if (!$this->model->validatePost($to_validate, $_POST)) {
          $this->view->message('error', $this->model->error);
        } elseif (!empty($_POST['email']) and $this->model->checkEmailExists($_POST['email'])) {
          $this->view->message('error', 'Этот E-mail уже используется');
        } elseif (!$this->model->checkLoginExists($_POST['login']) and $_POST['login'] != $_SESSION['authorize']['login']) {
          $this->view->message('error', 'Логин уже используется');
        } elseif (!$this->model->passwordCheck($_POST['password'])) {
          $this->view->message('error', 'Пароль неверен');
        }
        if (!empty($_POST['email'])) {
          $token_email = $this->model->createEmailToken();
          $this->model->saveGeneralSettings($_POST,$token_email);
          
          $status_send = $this->model->sendTokenToMailSecurityToken($_POST['email'], 'PreModern подтверждение email', 'Чтобы активировать аккаунт и нажмите на кнопку ниже', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/account/new_email?token=' . $token_email, 'Подтвердить email.');
          if ($status_send) {
            $this->view->message('success', 'Сохранено все кроме email.Чтоб сохранить email подтвердите его на почте.');
          } else {
            $this->view->message('success', 'Логин сохранен.Но произошла ошибка при смене email.');
          }
        } else {
          $this->model->saveGeneralSettings($_POST);
          $this->view->message('success', 'Сохранено');
        }
        
        
      } elseif ($_POST['form_name'] == 'password_settings') {
        //*Filter form "Create New Password"
        if (empty($_POST['old_password']) or empty($_POST['new_password'])) {
          $this->view->message('error', 'Некоторые поля пустые');
        } elseif (!$this->model->validatePost(['new_password'], $_POST)) {
          $this->view->message('error', $this->model->error);
        } elseif (!$this->model->passwordCheck($_POST['old_password'])) {
          $this->view->message('error', 'Пароль неверен');
        } 
        $this->model->saveNewPassword($_POST['new_password']);
        $this->view->message('success', 'Сохранено');
      }  else {
        $this->view->message('error', 'Ошибка безопастности');
      }
      //!!! СКИНЫ ПУСКАЕМ НА ОТДЕЛЬНЫЙ URL
      $this->model->save($_POST);
      $this->view->message('success', 'Сохранено');
    }
		$this->view->render('PreModern Профиль', $params);
  }
  public function uploadSkinAction()
  {
    //$this->view->message('error', json_encode($_POST));
    if (!empty($_POST)) {
      if ($this->model->botCheck($_POST['g-recaptcha-response'])) {
        $this->view->message('error', 'Повторите попытку.');
      } elseif ($this->model->checkCsrfToken($_POST['security_token'], $_SESSION['csrf_token'])) {
        $this->view->message('error', 'Ошибка безопастности');
      } elseif(($_FILES['skin_texture']['type'] != 'image/png')) {
        $this->view->message('error', 'Это не картинка');
      } elseif ($_FILES['skin_texture']['size'] > 75000) {
        $this->view->message('error', 'У нас запрещены HD-скины');
      } elseif (empty($_POST['skin_num'])) {
        $this->view->message('error', 'Ошибка безопастности 2');
      } elseif (!is_numeric($_POST['skin_num'])) {
        $this->view->message('error', 'Ошибка безопастности 2');
      } elseif ($this->model->checkLastUpdateSkin($_POST['skin_num'], $_SESSION['authorize']['id'])) {
        $this->view->message('error', 'Вы уже обновляли скин на данном слоте.Попробуйте через 10 часов');
      }
      $this->model->uploadSkin($_POST,$_FILES, $_SESSION['authorize']['id']);
      $this->view->message('success', 'Все отлично');

    } else {
      $this->view->message('error', 'Ошибка безопастности');
    }
  }
  
  public function confirmAction() {
		if (empty($_GET['token']) or !$this->model->checkTokenExists($_GET['token'])) {
			$this->view->redirect('/login');
		}
		$this->model->activate($_GET['token']);
		$this->view->render('PreModern Аккаунт активирован');
  }

  public function newEmailAction()
  {
    if (empty($_GET['token']) or !$this->model->checkTokenExists($_GET['token'])) {
      $this->view->redirect('/profile');
    }
    $this->model->activateNewEmail($_GET['token']);
    $this->view->render('PreModern Email активирован');
  }
  public function resetAction() {
    $data_keys = require_once "backend/settings/configs/config_captha.php";
    $public_key = $data_keys['public_key'];
    $token_hash = $this->model->tokenCreate();
    
    $params = [
      'public_key_recaptha' => $public_key,
      'csrf_token' => $token_hash,
    ];
    if (empty($_GET['token'])) {
      if (isset($_SESSION['authorize']['id'])) {
        $this->view->redirect('/profile');
      } else {
        $this->view->redirect('/login');
      }
    }
    if (!$this->model->checkTokenExists($_GET['token'])) {
      if (isset($_SESSION['authorize']['id'])) {
        $this->view->redirect('/profile');
      } else {
        $this->view->redirect('/login');
      }
      
    } 
		$this->view->render($this->config['PROJECT_NAME'].' Восстановление',$params);
  }
  public function resetingAction()
  {
    if (!empty($_POST)) {
      if ($this->model->botCheck($_POST['g-recaptcha-response'])) {
        $this->view->message('error', 'Повторите попытку.');
      } elseif ($this->model->checkCsrfToken($_POST['security_token'], $_SESSION['csrf_token'])) {
        $this->view->message('error', 'Ошибка безопастности');
      } elseif (!$this->model->checkTokenExists($_POST['token_reset'])) {
        $this->view->message('error', 'Произошла ошибка.Попробуйте снова');
      } elseif (!$this->model->validatePost(['password', 'password_repeat'], $_POST)) {
        $this->view->message('error', $this->model->error);
      } elseif (!$this->model->checkPasswordRepeat($_POST['password'], $_POST['password_repeat'])) {
        $this->view->message('error', 'Пароли не совпадают');
      }

      $this->model->reset($_POST['password'], $_POST['token_reset']);
      
      if (isset($_SESSION['authorize']['id'])) {
        $this->view->message('success', 'Успешная смена пароля теперь можете перейти в профиль');
      } else {
        $this->view->message('success', 'Успешная смена пароля теперь можете перейти ко входу');
      }
    } else {
      $this->view->message('error', 'Ошибка безопастности');
    }
  }
  public function fpasswordAction() {
    $data_keys = require_once "backend/settings/configs/config_captha.php";
    $public_key = $data_keys['public_key'];
    $token_hash = $this->model->tokenCreate();
    $params = [
      'public_key_recaptha' => $public_key,
      'csrf_token' => $token_hash,
    ];
    $token = $this->model->createEmailToken();
		if (!empty($_POST)) {
      if ($this->model->botCheck($_POST['g-recaptcha-response'])) {
        $this->view->message('error', 'Повторите попытку.');
      } elseif ($this->model->checkCsrfToken($_POST['security_token'], $_SESSION['csrf_token'])) {
        $this->view->message('error', 'Ошибка безопастности');
      } elseif (!$this->model->checkEmailExists($_POST['email'])) {
        $this->view->message('error','Аккаунта с таким E-mail не существует.');
      } elseif (!$this->model->checkStatus('email', $_POST['email'])) {
        $this->view->message('error', $this->model->error);
      }
      $status_send = $this->model->sendTokenToMailSecurityToken($_POST['email'], 'PreModern восстановление пароля', 'Чтобы восстановить пароль нажмите на кнопку ниже.Если вы не запрашивали восстановление просто проигнурируйте это сообщение.', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/account/reset?token=' .$token, 'Восстановить аккаунт');
      if ($status_send) {
        $this->model->FPasswordSetToken($_POST['email'], $token);
        $this->view->message('success', 'Инструкция к восстановлению пароля отправлена на email.');
      } else {
        $this->view->message('error', 'Произошла ошибка при отправке сообщения на email.');
      }
    }
		$this->view->render($this->config['PROJECT_NAME'].' Восстановление',$params );
  }
  public function getSkinAction() {
    if (empty($_GET['n'])) {
      $this->view->jsonDecode(['status' => 'error', 'response' => 'error']);
    } 
    if (!preg_match('#^[0-9]$#',$_GET['n'])) {
      $this->view->jsonDecode(['status' => 'error', 'response' => 'error']);
    }
    $config_skins = require 'backend/settings/configs/config_skin.php';
    $skins_max = $config_skins['max_skins'];
    $id = $_SESSION['authorize']['id'];
    $skin_num = $_GET['n'];
		if ($skin_num > $skins_max ) {
      $this->view->jsonDecode(['status' => 'error', 'response' => 'error']);
    }
    
    $file = $this->model->getSkinFilePath($_SESSION['authorize']['id'], $_GET['n']); 
    
    $file_path = "/frontend/img/skins/$id/$skin_num/$file.png";
    
    if ($file != '' and $file != 'base') {
      $this->view->jsonDecode(['status' => 'success','response' => $file_path]);
    } elseif ($file == 'base') {
      $this->view->jsonDecode(['status' => 'success','response' => '/frontend/img/skins/base.png']);
    } else {
      $this->view->jsonDecode(['status' => 'success', 'response' => 'none']);
    }
  }
  public function getActiveSkinAction()
  {
    $active_skin = $this->model->getActiveSkin($_SESSION['authorize']['id']);
    $file = $this->model->getSkinFilePath($_SESSION['authorize']['id'],$active_skin);
    $id = $_SESSION['authorize']['id'];
    $file_path = "/frontend/img/skins/$id/$active_skin/$file.png";

    if ($file != '' and $file != 'base') {
      $this->view->jsonDecode(['status' => 'success', 'response' => $file_path]);
    } elseif ($file == 'base') {
      $this->view->jsonDecode(['status' => 'success', 'response' => '/frontend/img/skins/base.png']);
    } else {
      $this->view->jsonDecode(['status' => 'success', 'response' => 'none']);
    }
  }
  public function setActiveSkinAction()
  {
    if (!empty($_POST)) {
      if ($this->model->botCheck($_POST['g-recaptcha-response'])) {
        $this->view->message('error', 'Повторите попытку.');
      } elseif ($this->model->checkCsrfToken($_POST['security_token'], $_SESSION['csrf_token'])) {
        $this->view->message('error', 'Ошибка безопастности');
      } elseif (empty($_POST['skin_num'])) {
        $this->view->message('error', 'Ошибка безопастности 2');
      } elseif (!is_numeric($_POST['skin_num'])) {
        $this->view->message('error', 'Ошибка безопастности 2');
      } elseif (!$this->model->setActiveSkin($_POST['skin_num'], $_SESSION['authorize']['id'])) {
        $this->view->message('error', 'Слот пуст');
      } 
      $this->view->message('success', 'Слот успешно выбран');
        
      

    } else {
      $this->view->message('error', 'Ошибка безопастности');
    }
    
  }
}
?>