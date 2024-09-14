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
    self::startSession();
    $_SESSION[$key] = $value;
  }

  public static function getSession($key)
  {
    self::startSession();
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
  }

  public static function isAuthenticated()
  {
    self::startSession();
    return isset($_SESSION["uid"]);
  }

  public static function getAuthenticatedUser()
  {
    self::startSession();
    return $_SESSION["uid"] ? $_SESSION["uid"] : null;
  }

  public static function isAuthorized($requestUid)
  {
    self::startSession();
    if (!self::isAuthenticated()) {
      return false; // Not authenticated
    }
    $sessionUid = self::getSession('uid');
    return $sessionUid === $requestUid;
  }

  public static function destroySession()
  {
    session_unset();
    session_destroy();
  }
}
