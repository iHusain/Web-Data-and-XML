<?php
    function dbConnect(){
        try{
            $username = 'root';
            $password = '';
            $conn = new pdo("mysql:host=127.0.0.1:3306;dbname=board;", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        }   catch(PDOException $e){
            echo 'ERROR', $e->getMessage();
        }
    }
?>
