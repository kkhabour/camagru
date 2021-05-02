<?php



    function lastlikes($id) {
        try {

            $db = new DatabaseHelper();

            $users = $db->last_likes($id);


            if ($users) 
                foreach($users as $u) {
                    $username = $u['username'];
                    $image = ($u['image'] != "null" && !is_null($u['image']) ? $u['image'] : "./Public/Images/avatar.png");
                    $time = to_time_ago(strtotime($u['created_at']));
                    
                    echo "<div class='bar-user'>
                    <div class='bar-userdata'>
                    <div style='background-image: url(". $image . ")'></div>
                    <span>" . $username . "</span></div><span>" 
                    . $time . "</span></div>";
                }
            else
                echo "<div class='no-likes'>
                <img src='Public/Images/posts.svg' width='100px' height='100px'>
                you don't have any likes yet
                </div>";



        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    function last_users() {
        try {
            $db = new DatabaseHelper();

            $users = $db->last_users();

            if ($users)
                foreach($users as $u) {
                    $username = $u['username'];
                    $image = null;
                    if (!is_null($u['image']) && $u['image'] != 'null')
                        $image = $u['image'];
                    else
                        $image = "./Public/Images/avatar.png";
                    $time = to_time_ago(strtotime($u['created']));

                    echo "<div class='bar-user'>
                    <div class='bar-userdata'>
                    <div style='background-image: url(". $image . ")'></div>
                    <span>" . $username . "</span></div><span>" 
                    . $time . "</span></div>";
                }
            else
                echo "<div class='no-likes'>
                <img src='Public/Images/posts.svg' width='100px' height='100px'>
                <p style='text-align:center'>there is no users for now, be the first one who register</p>
                </div>";


        } catch (PDOException $e) {
            http_response_code(404);
        }
    }



    function to_time_ago($time) {
        $difference = time() - $time;
        if( $difference < 1 ) {
            return 'NOW';
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
                return $t . $my_str . ' ago';
            }
        }
    }


