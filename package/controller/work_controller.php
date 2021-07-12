<?php 
class Work{
    function __construct(){
        //---
    }

    public static function addWork(){
        $conn = ConnectDB::getConnect();
    
        $userId = $_SESSION['userData']['USER_ID'];
        $addName = $conn->escape_string($_POST['add_name']);
        $addDesc = $conn->escape_string($_POST['add_descript']); 
        $addDate = $conn->escape_string($_POST['add_date']);
    
        $sql = "INSERT INTO WORK(USER_ID,WORK_NAME,WORK_DESC,WORK_DEADLINE,WORK_STATUS) \n"
                    ."VALUES(".$userId.",'".htmlentities($addName)."','".htmlentities($addDesc)
                    ."','".htmlentities($addDate)."',1)";
    
        if($conn->query($sql)){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    
    public static function editWork(){
        $conn = ConnectDB::getConnect();
        $sql  = "UPDATE WORK SET WORK_NAME='".htmlentities($conn->escape_string($_POST['update_name']))."' "
                                ." ,WORK_DESC='".htmlentities($conn->escape_string($_POST['update_desc']))."' "
                                ." ,WORK_DEADLINE='".htmlentities($conn->escape_string($_POST['update_date']))."' "
                                ." WHERE WORK_ID='".htmlentities($conn->escape_string($_POST['update_id']))."' ";
        if($conn->query($sql)){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    
    public static function doneWork(){
        $conn = ConnectDB::getConnect();
        $sql = 'UPDATE WORK SET work_status = 0 WHERE work_id ='.htmlentities($conn->escape_string($_POST['id']));
        if($conn->query($sql)){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    
    public static function delWork(){
        $conn = ConnectDB::getConnect();
        $id = $conn->escape_string($_POST['id']);
        $sql = 'DELETE FROM WORK WHERE WORK_ID='.$id;
        if($conn->query($sql)){
            echo 'true';
        }else{
            echo 'false';
        }
    }
}
?>