<?php


    class User {
        
        private $id;
        private $firstname;
        private $lastname;
        private $username;
        private $email;
        private $password;
        private $cpassword;
        private $image;
        private $token;
        private $verified;
        private $comment;
        

        private static $salt1 = "bad@<#'/&";
        private static $salt2 = "end%&#@";

        function __construct() {
            $this->id = null;
            $this->firstname = null;
            $this->lastname = null;
            $this->username = null;
            $this->email = null;
            $this->image = null;
            $this->password = null;
            $this->cpassword = null;
            $this->token = null;
            $this->verifed = 0;
            $this->comment = 1;
        }

        function get_id() {
            return $this->id;
        }
        
        function get_firstname() {
            return $this->firstname;
        }

        function get_lastname() {
            return $this->lastname;
        }

        function get_username() {
            return $this->username;
        }

        function  get_email() {
            return $this->email;
        }

        function get_image() {
            return $this->image;
        }

        function get_password() {
            return hash("ripemd128", self::$salt1 . $this->password . self::$salt2);
        }

        function get_token() {
            return $this->token;
        }

        function get_verified() {
            return $this->verified;
        }

        function get_comment() {
            return $this->comment;
        }

        function set_id($id){
            $this->id = $id;
        }

        function set_firstname($firstname) {
            if (is_string($firstname) == false)
                throw new Exception('type error!');

            $firstname = strtolower($firstname);
            $len = strlen($firstname);

            if ($len == 0)
                throw new Exception("first name cannot be empty");
            if (preg_match("/[^a-z]+/", $firstname) == 1)
                throw new Exception ("first name should be alphabetic only");
            if ($len < 3)
                throw new Exception("first name must be 3 characters at least");
            if ($len > 15)
                throw new Exception("first name cannot be more than 15 characters");
            $this->firstname = preg_replace("/[^a-z]+/", "", $firstname);
        }

        function set_lastname($lastname) {
            if (is_string($lastname) == false)
                throw new Exception('type error!');

            $lastname = strtolower($lastname);
            $len = strlen($lastname);

            if ($len == 0)
                throw new Exception("last name cannot be empty");
            if (preg_match("/[^a-z]+/", $lastname))
                throw new Exception ("last name name should be alphabetic only");
            if ($len < 3)
                throw new Exception("last name name must be 3 characters at least");
            if ($len > 15)
                    throw new Exception("last name cannot be more than 15 characters");
            
            $this->lastname = preg_replace("/[^a-z]+/", "", $lastname);
        }

        function set_username($username) {
            if (is_string($username) == false)
                throw new Exception('type error!');

            $username = strtolower($username);
            $len = strlen($username);
            
            if ($len == 0)
                throw new Exception("user name cannot be empty");
            if (preg_match("/[^a-z_.0-9_-]+/", $username))
                throw new Exception ("user name should be alphabetics only or _ or - or .");
            if ($len < 7)
                throw new Exception("user name must be 7 characters at least");
            if (strlen($username) > 16)
                throw new Exception("user name cannot be more than 16 characters");
            
           $this->username = preg_replace("/[^a-z0-9_-]+/","", $username);
        }

        /* Not completed yet, work on it later */ 
        function set_email($email) {
            if (is_string($email) == false)
                throw new Exception('type error!');

            $email = strtolower($email);
            $len = strlen($email);
            
            if ($len == 0)
                throw new Exception("email cannot be empty");
            if (preg_match("/[^a-z_.0-9-@]+/", $email))
                throw new Exception("email has some not allowed characters.");
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                throw new Exception("email is not valid");
            if ($len > 30)
                throw new Exception("email cannot be more than 30 characters");

            $this->email = $email;
        }

        function set_image($image) {
            $this->image = $image;
        }

        function set_password($password, $cpassword) {
            if (is_string($password) == false || is_string($cpassword) == false)
                throw new Exception('type error!');

            $password_pattern = "/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%^&+=*])[a-zA-Z0-9@#$%^&+=*]{8,}/";

            if (strlen($password) == 0)
                throw new Exception("password cannot be empty");
            if (preg_match("/[^a-zA-Z0-9@#$%^&+=*]/", $password))
                throw new Exception("password allowed only upper and lower alphabets, numbers, symbols @#$%^&+=*");
            if (!preg_match($password_pattern, $password))
                throw new Exception("Enter a combination of at least 8 characters, upper and lower alphabets, numbers, symbols @#$%^&+=*");
            if ($password != $cpassword)
                throw new Exception("Password and Confirm Password must match");
            
            $this->password = preg_replace("/[^a-zA-Z0-9@#$%^&+=*]+/", "", $password);
        }

        function set_token($token) {
            $this->token = $token;
        }

        function set_verified($verified) {
            if ($verified != 0 && $verified != 1)
                return;
            $this->verified = $verified;
        }

        function set_comment($comment) {
            if ($comment != 0 && $comment != 1)
                throw new Exception('email comment value is not valid');
            
            $this->comment = $comment;
        }

        function generate_token(){
            if ($this->token != '')
                return ;
            $this->token = hash("ripemd128", $this->username . $this->email);
        }

        /* static functions */
        static function add_user_to_session($user) {
            session_start();
            
            $_SESSION['user'] = serialize($user);
        }

        static function get_user_from_session() {
            session_start();
            
            return unserialize($_SESSION['user']);
        }


        function print() {
            echo "name: " . $this->firstname . " " . $this->lastname;
            echo "<br>";
            echo "username: " . $this->username;
            echo "<br>";
            echo "email: " . $this->email;
            echo "<br>";
            echo "token: " . $this->token;
            echo "<br>";
            echo "verified: " . $this->verified;
            echo "<br>";
            echo "comment: " . $this->comment;

        }
    }