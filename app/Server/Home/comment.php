<?php



if (count($_POST['comment']) != 2)
    error(400);

if (!is_string($_POST['comment'][0]) || !is_string($_POST['comment'][1]))
    error(400);


$postid = intval($_POST['comment'][0]);
$comment = htmlspecialchars($_POST['comment'][1], ENT_QUOTES);

if (!$postid || !$comment)
    error(400);

$user = SessionHelper::get_user();

try {

    $db = new DatabaseHelper();




    $db->add_comment($user->get_id(), $postid, $comment);
    
    echo '<div><div><span>' . $user->get_username() . '</span><span>' . $comment
    . '</span></div><span>1s</span></div>';
    

    

    


    
} catch (Exception $e) {
    error(404, $e->getMessage());
}

