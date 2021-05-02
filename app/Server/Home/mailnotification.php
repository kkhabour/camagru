<?php



    function mailnotification($postid, $comment) {


        if (!is_string($postid) || !is_string($comment))
            error(400);
        
        try {

            $user = SessionHelper::get_user();

            $db = new DatabaseHelper();

            $postowner = $db->get_post_owner($postid);


    
            if (intval($postowner['comment']) == 1) {
                $email = $postowner['email'];
                $image = $postowner['image'];
                $username = $user->get_username();
                Mail::comment_mail_notification($email, $image, $username, $comment);
            }
        

        } catch (PDOExeption $e) {

        } catch (Exception $e) {

        }
    }