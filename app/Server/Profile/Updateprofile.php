<?php

    function updateprofile($firstname, $lastname, $username, $email, $password, $npassword ,$comment) {
      
        $user = SessionHelper::get_user();
        $error = null;

        try {
            $user_update = new User();
            $user_update->set_id($user->get_id());
            $user_update->set_firstname($firstname);
            $user_update->set_lastname($lastname);
            $user_update->set_username($username);
            $user_update->set_email($email);
            $user_update->set_password($password, $password);
            $user_update->set_image($user->get_image());
            $user_update->set_token($user->get_token());
            $user_update->set_verified($user->get_verified());
            $user_update->set_comment(($comment ? '1' : '0'));

            $oldpassword = $user_update->get_password();



            
            if (empty($npassword) == false)
                $user_update->set_password($npassword, $npassword);
            // check old password

            $db = new DatabaseHelper();
            if ($oldpassword != $db->get_user_password($user->get_id()))
                throw new Exception("Old password incorrect");

            // update user data

            $db->update_user($user_update);
            SessionHelper::set_user($user_update);

            header("location: profile");

        } catch (PDOException $e) {
            if ($e->getCode() == 23000)
                $error = 'username or email is already taken';
            require_once "Public/Profile/Profile.php";
        }
        catch (Exception $e) {
            $error = $e->getMessage();
            require_once "Public/Profile/Profile.php";
        }

    }