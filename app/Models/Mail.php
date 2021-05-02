<?php


 class Mail {





    static function send_verification($user)
    {
        $host = getenv('http_host');
        # code...
        
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=UTF-8\r\n";
        $header .= "From : CAMAGRU 1337\r\n";
        $header .= "Reply-to: karimkhabouri@gmail.com\r\n";
        $header .= "X-Mailer: PHP/" . phpversion();
    

        $subject = "Email verification";
        $url = 'http://' . $host . '/token?token=' . $user->get_token();


        $message = "<h2 style='text-align: center;' >Verify your email address<h2>";
        $message .= '<p style="text-align: center ;font-weight: normal; font-size: 16px;">Hi ' 
        . $user->get_firstname() 
        . ', use the link below to verify your email and start enjoying Camagru.</p>';

        $message .= "<div style='text-align:center'><a " .
        " style='border: none;color: white;padding: 15px 32px;text-align: center;font-weight: normal;" .
        "text-decoration: none;display: inline-block;font-size: 16px;background-color: black;'" .
        "href='$url'>Confirm my email address</a><div>";


        if (!mail($user->get_email(), $subject, $message, $header))
            throw new Exception("Email not sent, pelase try again after while");
        
    }


    static function send_forgotpassword($email, $token) {
        $host = getenv('http_host');
        # code...
        
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=UTF-8\r\n";
        $header .= "From : CAMAGRU 1337\r\n";
        $header .= "Reply-to: karimkhabouri@gmail.com\r\n";
        $header .= "X-Mailer: PHP/" . phpversion();


        $subject = "Reset Password";
        $url = 'http://' . $host . '/forgotpassword?token=' . $token;

        $message = "<h2 style='text-align: center;' >Reset your password<h2>";
        $message .= '<p style="text-align: center ;font-weight: normal; font-size: 16px;">
            Need to reset your password, No problem just click the button below and you\'ll be on your way,
            keep in mind ForgotPassword request expires after 15 min
        </p>';

        $message .= "<div style='text-align:center'><a " .
        " style='border: none;color: white;padding: 15px 32px;text-align: center;font-weight: normal;" .
        "text-decoration: none;display: inline-block;font-size: 16px;background-color: black;'" .
        "href='$url'>Change Password</a><div>";

        if (!mail($email, $subject, $message, $header))
            throw new Exception("Email not sent, pelase try again after while");

    }



    function comment_mail_notification($email, $image, $username, $comment) {
        $host = getenv('http_host');
        # code...

        $img_type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $src =  "data:image/" . $img_type . ";base64," . base64_encode($data);
        
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=UTF-8\r\n";
        $header .= "From : CAMAGRU 1337\r\n";
        $header .= "Reply-to: karimkhabouri@gmail.com\r\n";
        $header .= "X-Mailer: PHP/" . phpversion();

        $subject = "Comment";

        
        $message = "<h2>Someone commented to your post</h2>";
        $message .= "<img src='$src' style='width: 265px; height: auto; margin: 8px 0px;'>";
        $message .= "<span style='margin-right:16px'>$username</span>";
        $message .= "<span>$comment</span>";


        if (!mail($email, $subject, $message, $header))
            throw new Exception("Email not sent, pelase try again after while");
    }


 }