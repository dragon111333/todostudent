<?php 
    class ConnectDB{
         public static function getConnect(){
                $conn = null;
                $conn = new mysqli('localhost','root','','todo_db');
                if($conn->connect_errno){
                    echo 'CONNECT DB ERROR!';
                }else{
                    $conn->set_charset('utf8mb4');
                    return $conn;
                }
        }
    }
?>