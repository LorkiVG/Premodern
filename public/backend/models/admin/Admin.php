<?php

namespace backend\models\admin;

use backend\core\Model;
use backend\lib\ReCaptcha;
use backend\core\View;
class Admin extends Model {
  public function tokenCreate()
  {
    if (!isset($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(40));
    }
    $token_to_form = password_hash($_SESSION['csrf_token'], PASSWORD_DEFAULT);
    return $token_to_form;
  }
  public function checkCsrfToken($token_hash, $token)
  {
    if (password_verify($token, $token_hash)) {
      return false;
    }
    return true;
  }
  public function BotCheck($recaptcha_response)
  {
    $secret_key = '6LfbviwaAAAAAM_A6JBsoYTyAPhFSPmqOG4qJSe8';
    $re = new ReCaptcha();
    $reResult = $re->verify($secret_key, $_SERVER['REMOTE_ADDR'], $recaptcha_response);
    if ($reResult['success']  && $reResult['score'] > 0.5) {
      return false;
    } else {
      return true;
    }
  }
  public function login($password)
  {
    $settings_admin = require_once "backend/settings/configs/config_admin.php";
    $password_admin = $settings_admin['password'];
    if ($password === $password_admin) {
      $_SESSION['admin_active'] = 1;
      return true;
    } else {
      return false;
    }

  }
  public function getStatisticCount()
  {
    return $this->db->column("SELECT COUNT(`num`) as count FROM `statistic`");
  }
  public function getDataStatistic($count, $retrievable_quantity)
  {
    $p = [
      'minimum' => $count - $retrievable_quantity
    ];
    return $this->db->row("SELECT `date`,`quantity` FROM `statistic` WHERE `num` > :minimum",$p);
  }
  public function getAllDataStatistic()
  {
    return $this->db->row("SELECT `date`,`quantity` FROM `statistic`");
  }
  public function getPlayerByNick($login)
  {
    $p = [
      'login' => $login
    ];
    return $this->db->row("SELECT `login`,`email`,`date_register`,`active_skin`,`is_banned`,`banned_before_time`,`banned_reason`,`warns` FROM `accounts` WHERE `status` = 1 AND `login` = :login",$p);
  }
  public function getInviolabilityStatus($login)
  {
    $p = [
      'login' => $login
    ];
    return $this->db->column("SELECT inviolability FROM `accounts` WHERE `login` = :login", $p);
  }
  public function getAdminStatus($login)
  {
    $p = [
      'login' => $login
    ];
    return $this->db->column("SELECT is_admin FROM `accounts` WHERE `login` = :login", $p);
  }
  public function getPlayers()
  {
    return $this->db->row("SELECT `login`,`email`,`date_register`,`active_skin`,`is_banned`,`banned_before_time`,`banned_reason`,`warns` FROM `accounts` WHERE `status` = 1");
  }
  public function getSkinFilePathByPlayer($login, $skin_num)
  {
    $params = [
      'login' => $login,

    ];
    $skin_number = 'skin_' . $skin_num;
    return $this->db->column("SELECT $skin_number FROM `accounts` WHERE login = :login", $params);
  }
  public function unban($login)
  {
    $params = [
      'login' => $login,
    ];
    return $this->db->query("UPDATE `accounts` SET `is_banned` = 0 , `banned_reason` = '' WHERE login = :login", $params);
  }
  public function setBanForever($login, $ban_reason)
  {
    $params = [
      'login' => $login,
      'banned_reason' => $ban_reason
    ];
    return $this->db->query("UPDATE `accounts` SET `is_banned` = 1 , `banned_reason` = :banned_reason , `banned_before_time` = 'forever' WHERE login = :login", $params);
  }
  public function setBanBeforeTime($login, $ban_reason, $before_time)
  {
    $params = [
      'login' => $login,
      'banned_reason' => $ban_reason,
      'banned_before_time' => $before_time,
    ];
    return $this->db->query("UPDATE `accounts` SET `is_banned` = 1 ,`banned_reason` = :banned_reason , `banned_before_time` = :banned_before_time WHERE login = :login", $params);
  }
  public function getWarns($login)
  {
    $params = [
      'login' => $login,
    ];
    return $this->db->column("SELECT warns FROM `accounts` WHERE `login` = :login", $params);
  }
  public function setWarn($login)
  {
    $params = [
      'login' => $login,
    ];
    return $this->db->query("UPDATE `accounts` SET `warns` = `warns` + 1  WHERE login = :login", $params);
  }
  public function unsetWarn($login)
  {
    $params = [
      'login' => $login,
    ];
    return $this->db->query("UPDATE `accounts` SET `warns` = `warns` - 1  WHERE login = :login", $params);
  }
}

