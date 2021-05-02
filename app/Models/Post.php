<?php



    class Post {

        private $id;
        private $userid;
        private $image;
        private $createdat;


        function __construct() {
            $this->id = null;
            $this->userid = null;
            $this->image = null;
            $this->createdat = null;
        }


        function get_id() {
            return $this->id;
        }

        function get_userid() {
            return $this->userid;
        }

        function get_image() {
            return $this->image;
        }

        function get_createdat() {
            return $this->createdat;
        }


        function set_id($id) {
            $this->id = $id;
        }

        function set_userid($userid) {
            $this->userid = $userid;
        }

        function set_image($image) {
            $this->image = $image;
        }

        function set_createdat($createdat) {
            $this->createdat = $createdat;
        }
    }