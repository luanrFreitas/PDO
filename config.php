<?php
$conn = 'mysql:host=10.1.2.63;dbname=pbxip';
try {
    $db = new PDO($conn, 'softium', 'softium@123');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    if($e->getCode() == 1049){
        echo "Banco de dados errado.";
    }else{
        echo $e->getMessage();
    }
}