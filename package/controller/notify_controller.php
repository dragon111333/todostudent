<?php 
    class Notify{
        function __construct(){
            //---
        } 
        public static function addLineToken(){
            $conn = ConnectDB::getConnect();
            $sql = "INSERT INTO USER_LINE_TOKEN(USER_ID,USER_TOKEN)".
                    " VALUES(".$_SESSION['userData']['USER_ID'].",'".htmlentities($conn->escape_string($_POST['user_token']))."')";
            if($conn->query($sql)){
                echo 'true';
            }else{
                echo 'false';
            }
        }

        public static function cancelLineNotify(){
            $conn = ConnectDB::getConnect();
            $sql ='DELETE FROM USER_LINE_TOKEN WHERE USER_ID ='.$_SESSION['userData']['USER_ID'];
            if($conn->query($sql)){
                echo 'true';
            }else{
                echo 'false';
            }
        }
    }
?>