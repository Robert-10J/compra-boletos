<?php

    function conectarDB() : mysqli {
        $db = mysqli_connect('mysql-roberttv.alwaysdata.net', 'roberttv', 'Alejandra12_', 'roberttv_boletos');
        //$db = mysqli_connect('localhost:3308', 'root', 'Toor248', 'boletos');

        if(!$db) {
            echo "Error no se pudo conectar";
            exit;
        } 

        return $db;   
    }