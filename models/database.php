<?php

require 'providers/limbodb/index.php';

class Database extends LimboDB {

    private function __construct() {
        $this ->init('DB_HOST', 'DB_USERNAME', 'DB_PASSWORD', 'DB_NAME');
    }

    //Set up primary methods here that can be depended on by other method classes
    
}

?>
