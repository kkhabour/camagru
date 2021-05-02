<?php



function checkAvatarInput($avatar) {
    if (!is_array($avatar) && count($avatar) != 3)
        error(400);

    foreach($avatar as $el)
        if (is_string($el) == false)
            error(400);
}

function checkStickersInput($stickers) {
    if (!$stickers)
        return ;
    if (is_array($stickers) == false)
        error(400);
    foreach($stickers as $sticker)
        if (is_string($sticker) == false)
            error(400);
}


function getFileType($f) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime-type extension
    $f = finfo_file($finfo, $f);
    finfo_close($finfo);
    return $f;
}



function checkimagetype($image) {
    $types = ['image/png', 'image/jpg', 'image/jpeg'];
    $type = getFileType($image);
    if (!in_array($type, $types))
        error(415);
    return explode('/', $type)[1];
}


function base64toimage($base64, $type) {
    $base64 = explode( ',' ,$base64);
    if (count($base64) != 2)
        error('base64 is not valid');
    checkifdirexists('Public/Images/Posts/');
    $imagePath = 'Public/Images/Posts/' . generateRandomString() . '.' . $type;
    $fp = fopen($imagePath, "w+");;
    fwrite($fp, base64_decode($base64[1]));
    fclose($fp);
    return $imagePath;
}


function addsticker($imagePath, $width, $height, $type, $stickers) {
    $dest = resizeimage($imagePath, $type, $width, $height);
    if ($stickers)
        foreach($stickers as $sticker) {
            $data = explode(',', $sticker);
            $path = 'Public/Images/stickers/' . $data[0];
            $x = $data[1];
            $y = $data[2];
            list($width, $height) = getimagesize($path);
            $src = imagecreatefrompng($path);
            imagecopy($dest, $src, $x, $y, 0, 0, $width, $height);
        }
    saveImage($dest, $imagePath, $type);
    return $imagePath;
}



function resizeimage($imagePath, $type, $newwidth, $newheight) {
    list($width, $height) = getimagesize($imagePath);
    $src = openImage($imagePath, $type);
    $dest = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dest, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    return $dest;
}



function openImage($path, $type) {
    switch($type) {
        case 'png':
            return imagecreatefrompng($path);
        case 'jpg':
        case 'jpeg':
            return imagecreatefromjpeg($path);
    }
}

function saveImage($dest, $path, $type) {
    switch($type) {
        case 'png':
            return imagepng($dest, $path);
        case 'jpg':
        case 'jpeg':
            return imagejpeg($dest, $path);
    }
}

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function checkifdirexists($path) {
    if (file_exists($path))
        return ;
    mkdir($path);
}



checkAvatarInput($_POST['avatar']);
checkStickersInput($_POST['stickers']);

// change directory to root dir;
chdir($_SERVER["DOCUMENT_ROOT"]);

$image = $_POST['avatar'][0];
$width = $_POST['avatar'][1];
$height = $_POST['avatar'][2];

// set memory  limit 
ini_set ('memory_limit', '400M');          


// accept only ['jpeg','jpg','png'];
$type = checkimagetype($image);


// convert base64 code to image
$imagePath = base64toimage($image, $type);


// add sticker to image
$imageURL = addsticker($imagePath, $width, $height, $type, $_POST['stickers']);

try {
    $user = SessionHelper::get_user();

    $db = new DatabaseHelper();
    $db->add_post($user->get_id(), $imageURL);

    echo $imageURL;

} catch(Exception $e) {
    error(500);
}





