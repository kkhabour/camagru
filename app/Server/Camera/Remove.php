<?php



    function removepost($postId) {
        try {
            $db = new DatabaseHelper();
            $db->remove_post_by_image($postId);

            http_response_code(200);

        } catch (PDOException $e) {
            http_response_code(404);
            echo $e->getMessage();
        }
    }


    function remove_image($image) {
        try {
            $db = new DatabaseHelper();
            $db->remove_post_by_image($image);
            http_response_code(200);

            if (file_exists($image))
                unlink($image);

        } catch (PDOException $e) {
            http_response_code(400);
        }
    }