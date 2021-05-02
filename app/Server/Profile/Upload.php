<?php

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function getFileType($f) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime-type extension
        $f = finfo_file($finfo, $f);
        finfo_close($finfo);
        return $f;
    }

    function checkifdirexists($path) {
        if (file_exists($path))
            return ;
        mkdir($path);
    }



    $PROFILE_IMAGE = "profile-image";
    $fileTypes = ['image/jpeg','image/jpg','image/png'];
    $UPLOAD_PATH =  "Public/Images/Profiles/";

    // change dir to document root ;
    if (getcwd() != $_SERVER['DOCUMENT_ROOT'])
        chdir($_SERVER['DOCUMENT_ROOT']);

     
    $filename = $_FILES[$PROFILE_IMAGE]['name'];
    $fileType = $_FILES[$PROFILE_IMAGE]['type'];
    $fileSize = $_FILES[$PROFILE_IMAGE]['size'];
    $fileError = $_FILES[$PROFILE_IMAGE]['error'];
    $fileTmpName = $_FILES[$PROFILE_IMAGE]['tmp_name'];
    $fileExtension = strtolower(pathinfo($filename)['extension']);


    if ($fileError)
        error(400);

    if (intval($fileSize) == 0)
        error(400);

    if (!in_array(getFileType($fileTmpName), $fileTypes))
        error(400);

    $new_Path = $UPLOAD_PATH . generateRandomString() . '.' . $fileExtension;

    checkifdirexists($UPLOAD_PATH);

    $res = move_uploaded_file($fileTmpName, $new_Path);

    if (!$res)
        error(500);

    try {
        $user = SessionHelper::get_user();

        $db = new DatabaseHelper();
        $db->update_image($new_Path, $user->get_id());

        if ($user->get_image() != 'null' && $user->get_image())
            if (file_exists($user->get_image()))
                unlink($user->get_image());

        $user = $db->get_user($user->get_id());

        SessionHelper::set_user($user);
        echo $new_Path;

    } catch (Exception $e) {
        error(500);
    }

