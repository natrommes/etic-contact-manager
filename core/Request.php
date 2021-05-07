<?php

 class Request {

    public static function valueExists($data, $key, $default) {
        return isset($data[$key]) ? $data[$key] : $default;
    }

    public static function get($key, $defaultValue = null) {
      // return isset($_GET['$key']) ? $_GET['$key'] : $defaultValue;
      return Request::valueExists($_GET, $key, $defaultValue);
    }

    public static function post($key, $defaultValue = null) {
        // return isset($_POST['$key']) ? $_POST['$key'] : $defaultValue;
        return Request::valueExists($_POST, $key, $defaultValue);
    }

    public static function file ($key) {
        //return isset($_FILES['$key']) ? $_FILES['$key'] : null;
        return Request::valueExists($_FILES, $key, null);
    }

    public static function session($key, $value = null) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (is_null($value)) {
            //return isset($_SESSION['$key']) ? $_SESSION['$key'] : null;
            return Request::valueExists($_SESSION, $key, null);
        }

        $_SESSION['$key'] = $value;
        return $value;
    }

    public static function cookie($key, $value = null) {
        if (is_null($value)) {
            return Request::valueExists($_COOKIE, $key, null);
        }

        setcookie($key, $value);
        return $value;
    }
 }