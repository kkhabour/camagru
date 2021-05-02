<?php 
    


    class DatabaseHelper {
        private $connection = null;

        private static $LDB_NAME = "camagru";
        private static $LDB_USER = "camagru";
        private static $LDB_PASSWORD = "password";
        private static $LDB_HOST = "db";


        function __construct() {
            $DB_DSN = "mysql:host=" . self::$LDB_HOST . ";dbname=" . self::$LDB_NAME;
            
            try {
                $this->connection = new PDO($DB_DSN, self::$LDB_USER, self::$LDB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
            } catch (PDOException $e) {
                if ($e->getCode() == 1049 || $e->getCode() == 2006 || $e->getCode() == 1045) {
                    require_once "config/database.php";
                    $this->connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
                    $query = file_get_contents("config/setup.sql");
                    $stmt = $this->connection->prepare($query);
                    $stmt->execute();
                }                    
            } catch (Exception $e) {
                error(500);
            }
        }


        function is_connection_open() {
            return $this->connection ? true : false;
        }
        
        function close_connection() {
            $this->connection= null;
        }


        function add_user($user) {
            $sql = "INSERT INTO users (firstname, lastname, username, email, password, token) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$user->get_firstname(),
                $user->get_lastname(),
                $user->get_username(),
                $user->get_email(),
                $user->get_password(),
                $user->get_token(),
            ]);
        }

        function check_if_user_exist($username, $email) {
            $sql = "SELECT * FROM users WHERE username=? OR email=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$username, $email]);

            $o = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$o)
                return ;
            if ($o["username"] == $username)
                throw new Exception("username alredy taken, please try new one");
            if ($o["email"] == $email)
                throw new Exception("email alredy taken, please try new one");
        }

        private function set_user($o) {
            $user = new User();
            $user->set_id($o["id"]);
            $user->set_firstname($o["firstname"]);
            $user->set_lastname($o["lastname"]);
            $user->set_username($o["username"]);
            $user->set_email($o["email"]);
            $user->set_image($o['image']);
            $user->set_token($o['token']);
            $user->set_verified($o['verified']);
            $user->set_comment($o['comment']);
            
            return $user;
        }

        function login_user($email, $password) {
            $sql = "SELECT * FROM users WHERE email=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$email]);
            
            $o = $stmt->fetch(PDO::FETCH_ASSOC);

            $salt1 = "bad@<#'/&";
            $salt2 = "end%&#@";
            
            if (!$o)
                throw new Exception("Email is not found");

            if ($o["email"] != $email || $o["password"] != hash("ripemd128", $salt1 . $password . $salt2))
                throw new Exception("Email or password incorrect");

            if ($o['verified'] == 0)
                throw new Exception("you need to verify your email first");
            
            return $this->set_user($o);
        }

        private function update_user_verified($token) {
            $sql = "UPDATE users SET verified=? WHERE token=?";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([1, $token]);
        }

        function get_user_by_token($token) {
            $sql = "SELECT * FROM users WHERE token=?";
           
            if (preg_match("/[^a-zA-Z0-9]/", $token))
                throw new Exception("Token is not valid");

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$token]);
            
            $o = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$o)
                throw new Exception("Token is not found");
            
            $user = $this->set_user($o);

            if ($user->get_verified() == 1)
                throw new Exception("email already verified");
            
            $this->update_user_verified($token);
            $user->set_verified(1);
            
            return $user;
        }


        function get_user_password($id) {
            $sql = "SELECT * FROM users WHERE id=?";
           
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            
            $o = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$o)
                throw new Exception("database error");

            return $o['password'];
        }

        function update_user($user) {
            $sql = "UPDATE users SET firstname=?, lastname=?, username=?, email=?, password=?, comment=? WHERE id=?";
           
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                $user->get_firstname(),
                $user->get_lastname(),
                $user->get_username(),
                $user->get_email(),
                $user->get_password(),
                $user->get_comment(),
                $user->get_id()
            ]);
        }

        function update_image($image, $id) {
            $sql = "UPDATE users SET `image`=? WHERE id=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$image, $id]);
        }


        function add_post($id, $image) {
            $sql = "INSERT INTO posts (user_id, image_url) VALUE (?, ?)";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id, $image]);
        }

        function get_posts($id) {
            $sql = "SELECT * from posts WHERE user_id=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);

            $o = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$o)
                return null;
            
            $posts = array();
            foreach ($o as $obj) {
                $post = new Post();
                $post->set_id($obj['id']);
                $post->set_userid($obj['user_id']);
                $post->set_image($obj['image_url']);
                $post->set_createdat($obj['created_at']);

                array_push($posts, $post);
            }
            return $posts;
        }

        function get_articles($offset) {
            $sql = "SELECT posts.id, users.username, users.image, posts.image_url, COUNT(likes.id) as likes_count, posts.created_at FROM posts\n";
            $sql .= "INNER JOIN users on posts.user_id=users.id\n";
            $sql .= "LEFT JOIN likes on likes.post_id=posts.id\n";
            $sql .= "GROUP BY posts.id ORDER BY created_at DESC LIMIT 5 OFFSET $offset";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $o = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$o)
                return null;

            $articles = array();


            foreach($o as $obj) {
                $article = new Article();
                $article->set_id($obj['id']);
                $article->set_username($obj['username']);
                $article->set_userimage($obj['image']);
                $article->set_image($obj['image_url']);
                $article->set_likes($obj['likes_count']);
                $article->set_time($obj['created_at']);

                $article->set_comments($this->get_article_comments($article->get_id()));
                
                array_push($articles, $article);
            }
            return $articles;
        }

        function get_article_comments($id) {
            $sql = "SELECT * FROM (SELECT comments.id, users.username, comments.comment, comments.created_at FROM comments
                    INNER JOIN users
                    ON comments.user_id = users.id
                    WHERE comments.post_id = ?  ORDER BY comments.created_at DESC)
                    t1 ORDER BY t1.created_at;";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);

            $o = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$o)
                return null;


            $comments = array();

            foreach($o as $obj) {
                $comment = new Comment();
                $comment->set_id($obj['id']);
                $comment->set_username($obj['username']);
                $comment->set_comment($obj['comment']);
                $comment->set_time($obj['created_at']);

                array_push($comments, $comment);
            }            
            return $comments;
        }

        function get_post_comment_count($id) {
            $sql = "SELECT count(*) as c FROM comments WHERE post_id=?";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);

            $o = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$o)
                return -1;
            
            return intval($o['c']);
        }

        function add_comment($userid, $postid, $comment) {
            $sql = "INSERT INTO comments (user_id, post_id, comment) VALUE (?, ?, ?)";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$userid, $postid, $comment]);
        }



        function get_user($id) {
            $sql = "SELECT * FROM users WHERE id=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            
            $o = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$o)
                throw new Exception("database error");
            return $this->set_user($o);
        }



        function add_like($id, $postid) {
            $sql = "INSERT INTO likes (user_id, post_id) VALUE (?, ?)";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id, $postid]);
        }

        function del_like($id, $postid) {
            $sql = "DELETE FROM likes WHERE user_id=? AND post_id=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id, $postid]);
        }

        function get_likes_count($postid) {
            $sql = "SELECT count(*) as c FROM likes WHERE post_id=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$postid]);
            $o = $stmt->fetch(PDO::FETCH_ASSOC);

            return intval($o['c']);
        }

        function is_like($id, $postid) {
            $sql = "SELECT * FROM likes WHERE user_id=? AND post_id=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id, $postid]);

            $o = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$o)
                return false;
            return true;
        }


        function get_posts_count() {
            $sql = "SELECT count(*) as c FROM posts";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $o = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$o)
                return false;

            return intval($o['c']);

        }



        function remove_post_by_image($image) {
            $sql = "DELETE FROM posts WHERE image_url=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$image]);            
        }



        function last_likes($id) {            
            $sql = "SELECT users.username, users.image, likes.created_at FROM likes 
            INNER JOIN posts on posts.id = likes.post_id 
            INNER JOIN users on likes.user_id = users.id
            WHERE posts.user_id = ? && likes.user_id <> ?
            GROUP BY likes.user_id
            ORDER BY likes.created_at DESC LIMIT 6";


            $sql = "SELECT users.username, users.image, 
            max(likes.created_at) as 'created_at' FROM likes 
            INNER JOIN posts on posts.id = likes.post_id 
            INNER JOIN users on likes.user_id = users.id
            WHERE posts.user_id = ? AND likes.user_id <> ?
            GROUP BY likes.user_id
            ORDER BY created_at DESC LIMIT 4";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id, $id]);
            
            $o = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $o;
        }

        function last_users() {
            $sql = "SELECT username, image, created FROM users ORDER BY created DESC LIMIT 5";


            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            
            $o = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $o;
        }


        function get_userid_by_email($email) {
            $sql = "SELECT id FROM users WHERE email = ?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$email]);
            
            $o = $stmt->fetch(PDO::FETCH_ASSOC);


            if (!$o)
                throw new Exception("Email address does not exists");
            
            return intval($o);
        }

        

        function set_forgotpassword_token($userid) {
            $token = hash("ripemd128", "*)#$*)_@#" . time() . "!+!_@)QQSAD");
            $sql = "INSERT INTO forgotpassword (`user_id`, `token`) VALUE (?, ?) 
            ON DUPLICATE KEY UPDATE token=? ";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$userid, $token, $token]);

            return $token;
        }

        function get_user_by_forgottoken($token) {
            $sql = "SELECT users.id, users.email, forgotpassword.created_at as token_time FROM `users` 
            INNER JOIN forgotpassword on users.id = forgotpassword.user_id
            WHERE forgotpassword.token = ?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$token]);

            $o = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$o)
                throw new Exception("Token does not exists");

            return $o;
        }


        function change_user_password($id, $password) {
            $sql = "UPDATE users SET password=? WHERE id=?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$password, $id]);
        }



        function get_post_owner($postid) {
            $sql = "SELECT users.email, users.comment, posts.image_url as `image` FROM users INNER JOIN posts on posts.user_id=users.id
                    WHERE posts.id = ?;";

            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$postid]);

            $o = $stmt->fetch(PDO::FETCH_ASSOC);


            if (!$o)
                return null;
            
            return $o;
        }



    }