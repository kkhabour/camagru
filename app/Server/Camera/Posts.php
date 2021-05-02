<?php

$user = SessionHelper::get_user();
$host = getenv('http_host');

try {
    $db = new DatabaseHelper();
    $id = $user->get_id();
    $posts = $db->get_posts($id);

    if ($posts)
        foreach($posts as $post)
            echo "<div class='main-content-posts-photos-wrapper-img' onmouseover='delover(this)' onmouseout='delout(this)' ><img onclick='removeimage(this)' data-id='" . $post->get_id() . "'" .  "src='" . $post->get_image() . "'></div>";

} catch (Exception $e) {
    echo $e->getMessage();
}
