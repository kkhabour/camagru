<?php





function verifyemail($token) {
    


    if (strlen($token) != 32)
        error(404);
    
    
    
    try {
        $db = new DatabaseHelper();
        $user = $db->get_user_by_token($token);            
        
        require_once "Public/VerifyEmail/VerifyEmail.php";

        
    } catch (Exception $e) {
        error(404, $e->getMessage());
    }
    
}

