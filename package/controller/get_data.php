<?php
//------[get Data]-------------
function checkLogin(){
    if(isset($_COOKIE['loginID'])&&strlen($_COOKIE['loginID'])>3){
            $_SESSION['userData'] = findUserDataByUUID($_COOKIE['loginID']);
            $_SESSION['loginStatus'] = true;
            return true;
    }else{
            return false;
    }
}

function findUserDataByUUID($uuid){
    $conn = ConnectDB::getConnect();
    $sql = "SELECT * FROM USER WHERE USER_UUID = '".$uuid."' LIMIT 1";
    $result = $conn->query($sql);
    return ($conn->affected_rows>0)?$result->fetch_array():null;
}

function getAllWork($workStatus){
    $conn = ConnectDB::getConnect();
    $sql ="SELECT USER_ID,WORK_ID,WORK_NAME,IFNULL(WORK_DESC,'') AS 'WORK_DESC'\n".
        ",WORK_STATUS\n" .
        ",WORK_DEADLINE as 'ORIGIN_DEADLINE' \n ".
        ",IFNULL(IF(DATEDIFF(WORK_DEADLINE,CURRENT_DATE)<=7,DATEDIFF(WORK_DEADLINE,CURRENT_DATE)".
        ",WORK_DEADLINE),'ไม่กำหนด') \n".
        "AS 'WORK_DEADLINE'\n".
        "FROM WORK WHERE user_id =".$_SESSION['userData']['USER_ID']." and work_status = ".$workStatus." \n".
        "ORDER BY DATE(ORIGIN_DEADLINE) ASC";
    return $conn->query($sql);
}

function getCountWork(){
    $conn = ConnectDB::getConnect();
    $sql = "SELECT COUNT(*) as 'COUNT' FROM WORK WHERE USER_ID=".$_SESSION['userData']['USER_ID']." AND WORK_STATUS=1";
    $result = $conn->query($sql);
    return (int) $result->fetch_array()['COUNT'];
}

function checkRegisLineNotify(){
    $conn = ConnectDB::getConnect();
    $sql = 'SELECT * FROM USER_LINE_TOKEN WHERE USER_ID='.$_SESSION['userData']['USER_ID'];
    $conn->query($sql);
    return ($conn->affected_rows>0)?true:false;
}

function getCountWorkMonth($allWork){
    $conn = ConnectDB::getConnect();
    $data  = [];
    $sql = '';
    for($i=3;$i>=0;$i--){
        if($allWork){
            $sql = "	SELECT COUNT(*) AS COUNT FROM WORK\n".
                    "	WHERE \n".
                    "	MONTH(WORK_REG) = MONTH(DATE_ADD(CURRENT_DATE,INTERVAL -".$i." MONTH))\n".
                    "   AND YEAR(WORK_REG) = YEAR(CURRENT_DATE) \n".
                    "	AND USER_ID = ".$_SESSION['userData']['USER_ID'];
        }else{
            $sql = "SELECT COUNT(*) AS COUNT FROM \n".
                    "(\n".
                    "	SELECT * FROM WORK_DONE_LOG\n".
                    "	WHERE \n".
                    "	MONTH(TIME_REG)=MONTH(DATE_ADD(CURRENT_DATE,INTERVAL -".$i." MONTH))\n".
                    "	AND \n".
                    "	YEAR(TIME_REG)=YEAR(DATE_ADD(CURRENT_DATE,INTERVAL -".$i." MONTH))\n".
                    ")AS D\n".
                    "INNER JOIN\n".
                    "(\n".
                    "	SELECT * FROM WORK\n".
                    "    WHERE USER_ID = ".$_SESSION['userData']['USER_ID']." \n".
                    ")AS W\n".
                    "ON\n".
                    "W.WORK_ID = D.WORK_ID \n".
                    "GROUP BY W.USER_ID";
        }

        $row = $conn->query($sql)->fetch_array();
        $numOfMonth =(int)(isset($row['COUNT']))?$row['COUNT']:"0";
        array_push($data,$numOfMonth);
    }
    return json_encode($data);
}

function backDateByCurrentDate($month){
    $monthSet = [];
    $date = date_create(date('Y-m-d'));
    $util = new ThewinUtil();

    for($i=$month;$i>=0;$i--){
        $backMonth = ($i==$month)?0:1;
        date_add($date,date_interval_create_from_date_string('-'.$backMonth.' MONTH'));
      
        $row = $util->dateIsoToThai(date_format($date,'Y-m-d'),'-');
        $row = explode('-',$row)[1].'/'.explode('-',$row)[2];
      
        array_push($monthSet,$row);
    }
    return json_encode(array_reverse($monthSet));
}
?>