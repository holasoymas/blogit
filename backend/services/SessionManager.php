<?php

class SessionManager
{
  public static function startSession()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  public static function setSession($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public static function getSession($key)
  {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
  }

  public static function isAuthenticated()
  {
    return isset($_SESSION["uid"]);
  }

  public static function isAuthorized($requestUid)
  {
    if (!self::isAuthenticated()) {
      return false; // Not authenticated
    }
    $sessionUid = self::getSession('uid');
    return $sessionUid === $requestUid;
  }

  public function destroySession()
  {
    session_unset();
    session_destroy();
  }
}
