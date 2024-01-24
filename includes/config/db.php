<?php

session_start();

function conectarDB() : mysqli{

    $db = new mysqli(
        'localhost',
        'root',
        '',
        'bienesraices_crud'
    );

    if (!$db) {
        
        exit;
    }

    return $db;
    
    
}


