<?php

    spl_autoload_register(function ($class_name) {
        include 'Models/' . $class_name . '.php';
    });
    


    // GET REQUESTS
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $HOME = $_GET['home'];

        if (isset($HOME) && is_string($HOME) == false)
            error(404);

        else if ($HOME == 'home')
            homepage();
        else if ($HOME == 'login')
            loginpage();

        else if ($HOME == 'register')
            registerpage();

        else if ($HOME == 'forgotpassword' && isset($_GET['token']))
            verifyforgotpassword($_GET['token']);

        else if ($HOME == 'forgotpassword')
            forgotpasswordpage();
        

        else if ($HOME == 'verification')
            verificationpage();

        else if ($HOME == 'camera')
            camerapage();

        else if ($HOME == 'profile')
            profilepage();
        
        else if ($HOME == 'logout')
            logout();

        else if ($HOME == 'posts')
            getposts();
        
        else if ($HOME == 'token')
            verifytoken($_GET['token']);



    }


    // POST REQUESTS
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // LOGIN REQUEST
        if (isset($_POST['login'])) {
            if (!is_string($_POST['login']) || $_POST['login'] != 'login')
                error(404);
            $email = $_POST['email'];
            $password = $_POST['password'];
            require_once 'Server/Login/Auth.php';
            login($email, $password);
        }

        
        // REGISTER REQUEST
        else if (isset($_POST['register'])) {
            if (!is_string($_POST['register']) || $_POST['register'] != 'register')
                error(404);
            require_once 'Server/Register/Register.php';
            register($_POST['firstname'], $_POST['lastname'], $_POST['username'], 
            $_POST['email'], $_POST['password'], $_POST['cpassword']);
        }


        // PAGINATION REQUEST
        else if (isset($_POST['offset']) && is_string($_POST['offset'])) {
            require_once "Server/Home/getarticles.php";
            print_articles(intval($_POST['offset']));
        }


        // FORGOT PASSWORD
        else if (isset($_POST['forgot']) && is_string($_POST['forgot'])) {
            require_once "Server/ForgotPassword/Forgotpassword.php";
            forgotpassword($_POST['forgotemail']);
        }

        else if (isset($_POST['changepassword']) && is_string($_POST['changepassword'])) {  
            require_once "Server/ForgotPassword/Forgotpassword.php";
            forgotchangepassword($_GET['token'], $_POST['changenewpassword'], $_POST['changeconfirmpassword']);
        }
        

        else if (SessionHelper::is_loggedin() == false)
            error(404);


        // UPDATE PROFILE REQUEST
        else if (isset($_POST['update'])) {
            if (!is_string($_POST['update']) || $_POST['update'] != 'update')
                error(404);
            require_once 'Server/Profile/Updateprofile.php';
            updateprofile($_POST['firstname'], $_POST['lastname'], $_POST['username'], 
            $_POST['email'], $_POST['oldpassword'], $_POST['newpassowrd'], $_POST['comment']);
        }

        // UPDATE PROFILE PHOTO
        else if ($_FILES['profile-image']) {
            require_once "Server/Profile/Upload.php";
        }

        // UPLOAD PHOTO FROM CAMERA
        else if (isset($_POST['avatar'])) {
            include "Server/Camera/Upload.php";
        }

        // LIKES
        else if (isset($_POST['like']) && is_string($_POST['like'])) {
            require_once "Server/Home/like.php";
        }

        // COMMENTS
        else if (isset($_POST['comment']) && is_array($_POST['comment'])) {
            require_once "Server/Home/comment.php";
        }

        // REMOVE POST
        else if (isset($_POST['removepost']) && is_string($_POST['removepost'])) {
            require_once "Server/Camera/Remove.php";
            $postid = $_POST['removepost'];
            remove_image($postid);

        }

        // SEND MAIL COMMENT NOTIFICATION
        else if (isset($_POST['mailnotification']) && is_array($_POST['mailnotification'])) {
            if (count($_POST['mailnotification']) != 2)
                error(400);
            
            require_once "Server/Home/mailnotification.php";
            $postid = $_POST['mailnotification'][0];
            $comment = $_POST['mailnotification'][1];
            
            mailnotification($postid, $comment);

        }

        else 
            error(400);


    }


    function homepage() {
        if (SessionHelper::is_loggedin())
            require_once './Public/Home/User.php';
        else
            require_once './Public/Home/Home.php';
    }

    function camerapage() {
        if (SessionHelper::is_loggedin())
            require_once "Public/Camera/Camera.php";
        else
            header('location: login');
    }

    function profilepage() {
        if (SessionHelper::is_loggedin())
            require_once "./Public/Profile/Profile.php";
        else
            header('location: login');
    }

    function loginpage() {
        if (SessionHelper::is_loggedin())
            header('location: home');
        else
            require_once './Public/Login/Login.php';
    }

    function registerpage() {
        if (SessionHelper::is_loggedin())
            header('location: home');
        else
            require_once "Public/Register/Register.php";
    }


    function forgotpasswordpage() {
        if (SessionHelper::is_loggedin() == false)
            require_once "Public/ForgotPassword/Forgotpassword.php";
        else
            header('location: home');
    }

    function verifyforgotpassword($token) {
        if (SessionHelper::is_loggedin())
            header('location: home');
        else {
            require_once "Server/ForgotPassword/Forgotpassword.php";
            forgotpasswordverification($token);
        }
    }

    function logout() {
        SessionHelper::clear();
        header('location: home');
    }

    function getposts() {
        if (SessionHelper::is_loggedin())
            require_once 'Server/Camera/Posts.php';
    }


    function verificationpage() {
        if (SessionHelper::is_loggedin() || !SessionHelper::get_user())
            header('location: home');
        else
            require_once "Public/Verification/Verification.php";
    }


    function verifytoken($token) {
        if (SessionHelper::is_loggedin() || !SessionHelper::get_user()) {
            header('location: home');
        } else {
            require_once 'Server/VerifyEmail/VerifyEmail.php';
            verifyemail($token);
        }
    }
    
    function error($code=404, $msg='') {
        http_response_code($code);
        echo $msg;
        exit();
    }