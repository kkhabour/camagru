<?php





$postid = intval($_POST['like']);


if (!$postid)
    error(400);


$user = SessionHelper::get_user();
$host = getenv('REQUEST_SCHEME') . '://' .  getenv('http_host') . "/";


try {

    $db = new DatabaseHelper();
    
    $db->add_like($user->get_id(), $postid);
    
    
    echo $host . 'Public/Images/favorite_black.svg';
    echo ',' . $db->get_likes_count($postid);

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $db->del_like($user->get_id(), $postid);
        echo $host . 'Public/Images/favorite_white.svg';
        echo ',' . $db->get_likes_count($postid);

    }

} catch (Exception $e) {
    error(404, $e->getMessage());
}


