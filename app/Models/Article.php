<?php

    class Article {

        private $id;
        private $username;
        private $userimage;
        private $image;
        private $likes;
        private $comments;
        private $time;



        function __construct() {
            $this->id = null;
            $this->username = null;
            $this->userimage = null;
            $this->image = null;
            $this->likes = null;
            $this->time = null;
            $this->comments = null;
        }

        function get_id() {
            return $this->id;
        }

        function get_username() {
            return $this->username;
        }

        function get_userimage() {
            return $this->userimage;
        }

        function get_image() {
            return $this->image;
        }

        function get_likes() {
            return $this->likes;
        }

        function get_comments() {
            return $this->comemnts;
        }

        function get_time() {
            return $this->time;
        }


        function set_id($id) {
            $this->id = $id;
        }

        function set_username($username) {
            $this->username = $username;
        }

        function set_userimage($userimage) {
            if ($userimage == "null")
                return ;
            $this->userimage = $userimage;
        }

        function set_image($image) {
            $this->image = $image;
        }

        function set_likes($likes) {
            $this->likes = $likes;
        }

        function set_comments($comments) {
            $this->comments = $comments;
        }

        function set_time($time) {
            $this->time = strtotime($time);
        }


        function print() {
            echo "username: " . $this->username;
            echo "<br>";
            echo "image: " . $this->image;
            echo "<br>";
            echo "likes: " . $this->likes;
            echo "<br>---------------------------<br>";
        }


        function html($loggedin, $c, $is_like) {            
            
            $host = getenv('REQUEST_SCHEME') . '://' .  getenv('http_host') . "/";
            $html = file_get_contents('Models/article_html.txt', 'r');

            $html = str_replace('{id}', $this->id, $html);


            

            if (is_null($this->userimage))
                $html = str_replace("{userimage}", $host . "Public/Images/avatar.png", $html);
            else
                $html = str_replace("{userimage}", $host . $this->userimage, $html);

            $html = str_replace("{username}", $this->username, $html);
            $html = str_replace("{postimage}", $host . $this->image, $html);
            $html = str_replace("{likes}", $this->likes, $html);

            if ($is_like)
                $html = str_replace('{likeicon}', $host . "Public/Images/favorite_black.svg", $html);
            else
                $html = str_replace('{likeicon}', $host . "Public/Images/favorite_white.svg", $html);


            $html = str_replace('{viewcomments}', '', $html);
                
            if ($this->comments) {
                $data = '';
                foreach ($this->comments as $comment)
                    $data = $data . $this->htmlcomment($comment);
                $html = str_replace('{comments}', $data, $html);
            } else
                $html = str_replace('{comments}', '', $html);

            

            $html = str_replace("{time}", $this->to_time_ago($this->time), $html);

            if ($loggedin) {
                $html = str_replace('{commentinput}', $this->commentinput(), $html);
                $html = str_replace('{ondblclick}', "ondblclick=\"like(this)\"", $html);
                $html = str_replace('{onclick}', "onclick=\"like(this)\"", $html);
            }
            else {
                $html = str_replace('{commentinput}', '<div style="margin:24px"></div>', $html);
                $html = str_replace('{ondblclick}', "", $html);
                $html = str_replace('{onclick}', "", $html);
            }



            echo $html;
        }


        function htmlcomment($comment) {
            return '<div><div><span>' .  $comment->get_username() .'</span><span>'
            . $comment->get_comment()
            . '</span></div><span>' . $comment->get_time(). '</span></div>';
        }


        function commentinput() {
            return '<div class="main-content-posts-article-comment-input">
                        <div>
                            <input class="comment-input"  type="text" placeholder="Add a comment...">
                            <button class="comment-post-button" onclick="comment(this)">Post</button>
                        </div>
                     </div>';
        }


        function to_time_ago($time) {
            $difference = time() - $time;
            if( $difference < 1 ) {
                return 'NOW';
            }
            $time_rule = array (
                12 * 30 * 24 * 60 * 60 => 'YEAR',
                30 * 24 * 60 * 60 => 'MONTH',
                24 * 60 * 60 => 'DAY',
                60 * 60 => 'HOUR',
                60 => 'MINUTE',
                1 => 'SECOND'
            );
            foreach( $time_rule as $sec => $my_str ) {
                $res = $difference / $sec;
                if( $res >= 1 ) {
                    $t = round( $res );
                    return $t . ' ' . $my_str .
                    ( $t > 1 ? 'S' : '' ) . ' AGO';
                }
            }
        }

    }