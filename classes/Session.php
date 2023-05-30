<?php

class Session
{
    public static function set ($key, $value) {
        session_start();
        $_SESSION[$key] = $value;
        session_write_close();
    }


}