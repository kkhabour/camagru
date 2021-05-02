<?php


    function forgotpassword($email) {

        if (is_string($email) == false || SessionHelper::is_loggedin()) {
            header('location: home');
            exit();
        }
        
        $error = null;
        $succes = null;



        try {

            if (empty($email))
                throw new Exception("Email is empty");

            $email = filter_var($email, FILTER_SANITIZE_EMAIL);            

            $db = new DatabaseHelper();
            
            $id = $db->get_userid_by_email($email);
            $token = $db->set_forgotpassword_token($id);
            
            Mail::send_forgotpassword($email, $token);

            $succes = "Please check your email for a link";
            require_once "Public/ForgotPassword/Forgotpassword.php";



        } catch (PDOException $e) {
            $error = $e->getMessage();
            require_once "Public/ForgotPassword/Forgotpassword.php";
        } catch (Exception $e) {
            $error = $e->getMessage();
            require_once "Public/ForgotPassword/Forgotpassword.php";
        }
    }


    function forgotchangepassword($token, $password, $cpassword) {
        if (SessionHelper::is_loggedin())
            error(404);

        $user = new User();
        $error = null;
        try {

            $user->set_password($password, $cpassword);

            $db = new DatabaseHelper();
            $u =  $db->get_user_by_forgottoken($token);

            $id = $u['id'];

            $db->change_user_password($id, $user->get_password());
            $db->set_forgotpassword_token($id);

            header('location: login');

        } catch (PDOException $e) {
            $error = $e->getMessage();
            require_once "Public/ForgotPassword/Forgotpasswordverification.php";
        } catch (Exception $e) {
            $error = $e->getMessage();
            require_once "Public/ForgotPassword/Forgotpasswordverification.php";
        }

    }

    function forgotpasswordverification($token) {

        if (is_string($token) == false || strlen($token) != 32)
            error(404);


        try {

            $db = new DatabaseHelper();

            $u = $db->get_user_by_forgottoken($token);

            $time = date("i", (time() - strtotime($u['token_time'])));

            if ($time > 50)
                error(400);
            
            require_once "Public/ForgotPassword/Forgotpasswordverification.php";

        } catch (PDOException $e) {
            error(404);
        } catch(Exception $e) {
            error(404);
        }


    }