<?php

    function login($email, $password) {

        $error = null;

        try {

            $db = new DatabaseHelper();
            $user = $db->login_user($email, $password);
            
            // clear sessions from all vars
            SessionHelper::clear();
            
            SessionHelper::set_user($user);
            SessionHelper::set_login();

            
            header('location: home');
            
        } catch (Exception $e) {
            $error = $e->getMessage();
            require_once "Public/Login/Login.php";
        }
    }




