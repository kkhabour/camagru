<?php 



function register($firstname, $lastname, $username, $email, $password, $cpassword) {

    $user = new User();
    $error = null;

    try {

        $user->set_firstname($firstname);
        $user->set_lastname($lastname);
        $user->set_username($username);
        $user->set_email($email);
        $user->set_password($password, $cpassword);
        $user->set_verified(0);
        $user->generate_token();
        

        $database = new DatabaseHelper();
        $database->check_if_user_exist($username, $email);
        $database->add_user($user);
        
        SessionHelper::set_user($user);
        
        Mail::send_verification($user);
        

        header("location: verification");
        

    } catch (PDOException $e) {
        $error = $e->getMessage();
        require_once "Public/Register/Register.php";
    } catch (Exception $e) {
        $error = $e->getMessage();
        require_once "Public/Register/Register.php";
    }

}