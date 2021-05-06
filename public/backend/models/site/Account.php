<?php 

namespace backend\models\site;

use backend\core\Model;
use backend\lib\ReCaptcha;
use backend\lib\phpmailer\PHPMailer;
use backend\lib\phpmailer\SMTP;
use backend\lib\phpmailer\Exception;
use backend\core\View;
use DateTime;

class Account extends Model {
	public function BotCheck ($recaptcha_response) {
		$secret_key = '6LfbviwaAAAAAM_A6JBsoYTyAPhFSPmqOG4qJSe8';
		$re = new ReCaptcha();
		$reResult = $re->verify($secret_key,$_SERVER['REMOTE_ADDR'],$recaptcha_response);
		if ($reResult['success']  && $reResult['score'] > 0.5) {
			return false;
		} else {
			return true;
		}
		
	}
  public function validatePost($input, $post) {
		$rules = [
			'login' => [
				'pattern' => '#^[a-zA-Z0-9]{3,15}$#',
				'message' => 'Логин указан неверно (только латинские буквы и цифры от 3 до 15 символов)',
			],
			'email' => [
				'pattern' => '#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#',
				'message' => 'E-mail адрес указан неверно',
			],
			'password' => [
				'pattern' => '#^[a-zA-Z0-9]{5,30}$#',
				'message' => 'Пароль указан неверно (только латинские буквы и цифры от 5 до 30 символов)',
			],
			'new_password' => [
				'pattern' => '#^[a-zA-Z0-9]{5,30}$#',
				'message' => 'Пароль указан неверно (только латинские буквы и цифры от 5 до 30 символов)',
			],
      'password_repeat' => [
				'pattern' => '#^[a-zA-Z0-9]{5,30}$#',
				'message' => 'Пароль указан неверно (только латинские букв и цифры от 5 до 30 символов)',
      ],
		];
		foreach ($input as $val) {
			if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
				$this->error = $rules[$val]['message'];
				return false;
			}
		}
		return true;
	}
	public function checkLastUpdateSkin($skin_num,$id)
	{
		$skin_number = 'skin_'.$skin_num .'_date';
		$params = [
			'id' => $id,

		];
		$status = $this->db->column("SELECT $skin_number FROM `accounts` WHERE id = :id", $params);
		if ($status === null or $status == ""or $status == 0) {
			return false;
		} else {
			$normal_update_date = $status + 36000;
			if ($normal_update_date < time()) {
				return false;
			} else {
				return true;
			}
		}

	}
  public function register($post) {
		$token_email = $this->createEmailToken();
		$params = [
			'id' => null,
			'login' => $post['login'],
			'email' => $post['email'],
			'password' => password_hash($post['password'], PASSWORD_DEFAULT),
			'token' => $token_email,
			'status' => 0,
			'is_banned' => 0,
			'banned_before_time' => null,
			'banned_reason' => null,
			'warns' => 0,
			'is_admin' => 0,
			'inviolability' => 0,
			'active_skin' => 1,
			'skin_1' => 'base',
			'skin_2' => '',
			'skin_3' => '',
			'skin_4' => '',
			'skin_5' => '',
			'skin_1_date' => null,
			'skin_2_date' => null,
			'skin_3_date' => null,
			'skin_4_date' => null,
			'skin_5_date' => null,
			'new_email' => '',
			'date_register' => date("d.m.y")
		];
	
		$this->db->query('INSERT INTO `accounts`  VALUES (:id, :login, :email , :password, :token , :status,:is_banned ,:banned_before_time, :banned_reason, :warns, :is_admin, :inviolability, :active_skin , :skin_1 , :skin_2 , :skin_3 , :skin_4 , :skin_5, :skin_1_date , :skin_2_date , :skin_3_date , :skin_4_date , :skin_5_date,:new_email , :date_register)', $params);
		$status_send = $this->sendTokenToMailSecurityToken($post['email'],'PreModern подтверждение email','Чтобы активировать аккаунт и нажмите на кнопку ниже',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/account/confirm?token='.$token_email,'Активировать аккаунт.');
		if ($status_send) {
			View::messageStatic('success', 'Успешная регистрация, теперь перейдите на почту подтвердите email.');
		} else {
			View::messageStatic('error', 'Произошла ошибка при отправке сообщения на email.');
		}
	}

	public function createEmailToken() {
		$token = bin2hex(random_bytes(random_int(30,40)));
		return $token;
	}
	public function sendTokenToMailSecurityToken($email,$title,$message,$link, $but_title) {
		$body = "
			<center><div style = \"margin: 0 auto;\">
				<h2 style = \"font-size:30px;color:#121A27;\">$title</h2>
				<p style = \"font-size:23px;color:#121A27;\" >$message </p>
				<a style = \"font-size:24px;font-weight: 400;color:#121A27;background-color:#f6a50d;padding: 6px 17px 6px 17px;border-radius:10px;text-decoration: none;\" href = \"$link\">$but_title</a>
			</div></center>";
		$mail = new PHPMailer();
		$config_smtp = require 'backend/settings/configs/config_smtp.php';
		try {
			$mail->isSMTP();   
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth   = true;
			//$mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

			// Настройки вашей почты
			$mail->Host       = $config_smtp['host']; // SMTP сервера вашей почты
			$mail->Username   = $config_smtp['username']; // Логин на почте
			$mail->Password   = $config_smtp['password']; // Пароль на почте
			$mail->SMTPSecure = $config_smtp['secure'];
			$mail->Port       = $config_smtp['port'];
			$mail->setFrom($config_smtp['username'], 'PreModern'); // Адрес самой почты и имя отправителя

			$mail->addAddress($email);  

			$mail->isHTML(true);
			$mail->Subject = $title;
			$mail->Body = $body;    


			if ($mail->send()) {
				return true;
			} else {
				return false;
			}

		} catch (Exception $e) {
			return false;
		}
	}
	public function reset($password,$token)
	{
		$params = [
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'token' => $token,
			
		];
		return $this->db->query('UPDATE `accounts` SET token = "", password = :password WHERE token = :token', $params);
		
		
	}
	public function FPasswordSetToken($email, $token)
	{
		$params = [
			'token' => $token,
			'email' => $email
			
		];
		return $this->db->query('UPDATE `accounts` SET token = :token WHERE email = :email', $params);
		
	}
	
  public function checkEmailExists($email) {
		$params = [
			'email' => $email,
		];
		
		return $this->db->column('SELECT id FROM `accounts` WHERE email = :email', $params);
	}
	public function tokenCreate() {
		if (!isset($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(40));
		}
		$token_to_form = password_hash($_SESSION['csrf_token'], PASSWORD_DEFAULT);
		return $token_to_form;
	}
	public function checkCsrfToken($token_hash,$token) {
		if (password_verify ($token , $token_hash )) {
      return false;
    }
    return true;
	}
  public function checkPasswordRepeat($password,$password_repeat) {
		if ($password === $password_repeat) {
      return true;
    }
    return false;
	}
	public function banCheck($login)
	{
		$params = [
			'login' => $login,
		];
		$status = $this->db->column("SELECT is_banned FROM `accounts` WHERE login = :login", $params);
		if ($status == 0) {
			return false;
		} else {
			$before_time = $this->db->column("SELECT banned_before_time FROM `accounts` WHERE login = :login", $params);
			$dt = DateTime::createFromFormat("d.m.y-H:i:s", $before_time);
			$ts = $dt->getTimestamp();
			if ($ts <= time()) {
				return false;
			} else {
				return true;
			}
		}
	}
	public function checkStatus($type, $data) {
		$params = [
			$type => $data,
		];
		$status = $this->db->column('SELECT status FROM `accounts` WHERE '.$type.' = :'.$type, $params);
		if ($status != 1) {
			$this->error = 'Аккаунт ожидает подтверждения по E-mail';
			return false;
		}
		return true;
	}
	public function passwordVerify($login, $password) {
		$params = [
			'login' => $login,
		];
		$hash = $this->db->column('SELECT password FROM `accounts` WHERE login = :login', $params);
		if (!$hash or !password_verify($password, $hash)) {
			return false;
		}
		return true;
	}
	public function checkLoginExists($login) {
		$params = [
			'login' => $login,
		];
		if ($this->db->column('SELECT id FROM `accounts` WHERE login = :login', $params)) {
			$this->error = 'Этот логин уже используется';
			return false;
		}
		return true;
	}
	public function setActiveSkin($skin_num,$id)
	{
		$param = [
			'id' => $id,
		];
		$skin_number = "skin_$skin_num";
		$skin_info = $this->db->column("SELECT $skin_number FROM `accounts`  WHERE id = :id", $param);
		if ($skin_info == "" or $skin_info == null) {
			return false;
		} else {
			$params = [
				'id' => $id,
				'skin_num' => $skin_num,
			];
			$this->db->query("UPDATE `accounts` SET active_skin = :skin_num WHERE id = :id", $params);
			return true;
		}
	}
	public function uploadSkin($post,$files, $id)
	{
		$skin_num = $post['skin_num'];
		$dir = 'frontend/img/skins/'.$_SESSION['authorize']['id'].'/'.$skin_num;
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$files_scan = scandir($dir);
		$tmp_file_name = $files['skin_texture']['name'];
		$file_name_to_base =  bin2hex(random_bytes(20)) . $tmp_file_name;
		$file_name =  $file_name_to_base. '.png';
		if (count($files_scan) > 0 ) {
			foreach (glob($dir . '/*') as $file) {
				chmod($file, 0777);
				unlink($file);
			}
			copy($files['skin_texture']['tmp_name'], $dir .'/'. $file_name);
		} else {
			copy($files['skin_texture']['tmp_name'], $dir .'/'. $file_name);
		}
		$params = [
			'id' => $id,
			'skin_'.$skin_num => $file_name_to_base,
			'skin_' . $skin_num.'_date' => time()
		];
		$sql = 'skin_'.$skin_num.'= :skin_'.$skin_num.' , '.'skin_' . $skin_num . '_date = :skin_' .$skin_num.'_date';
		$this->db->query("UPDATE `accounts` SET $sql WHERE id = :id", $params);
	}
	public function login($login) {
		$params = [
			'login' => $login,
		];
		
		$data = $this->db->row('SELECT * FROM `accounts` WHERE login = :login', $params);
		$_SESSION['authorize'] = $data[0];
	}
	public function checkTokenExists($token) {
		$params = [
			'token' => $token,
		];
		return $this->db->column('SELECT id FROM `accounts` WHERE token = :token', $params);
	}
	public function passwordCheck($password)
	{
		$id_user = $_SESSION['authorize']['id'];
		$params = [
			'id' => $id_user
		];
		$password_user = $this->db->column('SELECT `password` FROM `accounts` WHERE id = :id', $params);

		if (password_verify($password, $password_user)) {
			return true;
		} else {
			return false;
		}
	}
	public function activate($token) {
		$params = [
			'token' => $token,
		];
		$this->db->query('UPDATE `accounts` SET status = 1, token = "" WHERE token = :token', $params);
	}

	public function activateNewEmail($token)
	{
		$vars = [
			'token' => $token,
		];
		$new_email = $this->db->column('SELECT `new_email` FROM `accounts` WHERE token = :token', $vars);
		$params = [
			'token' => $token,
			'email' => $new_email
		];
		$this->db->query('UPDATE `accounts` SET email = :email, new_email = "", token = "" WHERE token = :token', $params);
	}
	public function getSkinFilePath($id,$skin_num)
	{
		$params = [
			'id' => $id,
			
		];
		$skin_number = 'skin_'.$skin_num;
		return $this->db->column("SELECT $skin_number FROM `accounts` WHERE id = :id", $params);
	}
	public function getActiveSkin($id)
	{
		$params = [
			'id' => $id,
		];
		return $this->db->column("SELECT active_skin FROM `accounts` WHERE id = :id", $params);
	}
	public function saveNewPassword($new_password)
	{
		$params = [
			'id' => $_SESSION['authorize']['id'],
			'password' => password_hash($new_password, PASSWORD_DEFAULT)
		];
		if ($this->db->query('UPDATE `accounts` SET `password` = :password WHERE id = :id', $params)) {
			$_SESSION['authorize']['password'] = $new_password;
		} else {
			View::messageStatic('error', 'При сохранение информации что-то пошло не так');
		}
	}
	public function saveGeneralSettings($post,$token ="none")
	{
		$params = [
			'id' => $_SESSION['authorize']['id'],
			'login' => $post['login'],
		];
		if (!empty($post['email'])) {
			$params['email'] = $post['email'];
			$params['token'] = $token;
			$sql = ',new_email = :email , token = :token';
		} else {
			$sql = '';
		}
		if ($this->db->query ('UPDATE `accounts` SET `login` = :login' . $sql . ' WHERE id = :id', $params) ) {
			foreach ($params as $key => $val) {
				$_SESSION['authorize'][$key] = $val;
			}
		} else {
			View::messageStatic('error', 'При сохранение информации что-то пошло не так');
		}
	}
}