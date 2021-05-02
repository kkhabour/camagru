<?php

    require_once "database.php";
    

        try {
        
            $connections = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $connections->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $query = file_get_contents("setup.sql");
    
            $stmt = $connections->prepare($query);
            $stmt->execute();
    
            echo "Database created successfully";
    
        } 
        catch (EXPERIENCE $e) {
            http_response_code(500);
        }





?>