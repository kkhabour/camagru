<?php 



    function print_articles($offset=0) {
        try {
    
            $db = new DatabaseHelper();

            // check if limit is more than posts
            $c = $db->get_posts_count();

            if ($offset >= $c)
                return ;
    
            $articles = $db->get_articles($offset);
            $loggedin = SessionHelper::is_loggedin();
            $user = SessionHelper::get_user();
    
    
            if ($articles)
                foreach($articles as $article) {
                    $c = $db->get_post_comment_count($article->get_id());
                    $is_like = false;
                    if ($user)
                        $is_like = $db->is_like($user->get_id(), $article->get_id());
                    $article->html($loggedin, $c, $is_like);
    
                }
            else if ($offset != 0)
                return ;
            else {
                echo "<div style='text-align: center;'><h3>";
                echo "No Posts Yet</h3></div>";
            }
                        
    
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
