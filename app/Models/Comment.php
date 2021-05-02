<?php

    class Comment {

        private $id;
        private $username;
        private $comment;
        private $time;


        function __construct() {

        }


        function get_id() {
            return $this->id;
        }

        function get_username() {
            return $this->username;
        }

        function get_comment() {
            return $this->comment;
        }

        function get_time() {
            return $this->to_time_ago($this->time);
        }

        function set_id($id) {
            $this->id = $id;
        }

        function set_username($username) {
            $this->username = $username;
        }

        function set_comment($comment) {
            $this->comment = $comment;
        }

        function set_time($time) {
            $this->time = strtotime($time);
        }



        function to_time_ago($time) {
            $difference = time() - $time;
            if( $difference < 1 ) {
                return 'now';
            }
            $time_rule = array (
                12 * 30 * 24 * 60 * 60 => 'y',
                30 * 24 * 60 * 60 => 'mo',
                24 * 60 * 60 => 'd',
                60 * 60 => 'h',
                60 => 'm',
                1 => 's'
            );
            foreach( $time_rule as $sec => $my_str ) {
                $res = $difference / $sec;
                if( $res >= 1 ) {
                    $t = round( $res );
                    return $t . $my_str;
                }
            }
        }

    }