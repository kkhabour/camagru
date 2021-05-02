<?php


    class SessionHelper {

        private static $USER = "user";
        private static $LOGGED_IN = "loggedin";
        private static $VERIFY_EMAIL = "verifyemailpage";



        static function set_user($user) {
            session_start();
            $_SESSION[$USER] = serialize($user);
        }

        static function get_user() {
            session_start();

            return unserialize($_SESSION[$USER]);
        }



        static function set_login() {
            session_start();

            $_SESSION[self::$LOGGED_IN] = true;
        }

        static function is_loggedin() {
            session_start();
            
            if (isset($_SESSION[self::$LOGGED_IN]))
                return $_SESSION[self::$LOGGED_IN];
            return false;
        }

        static function clear(){
            session_start();
            session_destroy();
        }

        
    }