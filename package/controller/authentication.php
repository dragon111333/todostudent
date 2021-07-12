<?php
class Authentication{
    public static function authen(){
        $conn = ConnectDB::getConnect();
        $username =$conn->escape_string( $_POST['username']);
        $password = sha1($conn->escape_string($_POST['password']));
        $sql = "SELECT * FROM USER WHERE user_username='".$username."' limit 1";
       
        $result = $conn->query($sql);
        
        if($conn->affected_rows>0){
            $userData = $result->fetch_array();
            if($userData['USER_PASSWORD']!=$password){
                echo '1';
            }else{
                $_SESSION['userData'] = $userData;
                $_SESSION['loginStatus'] = true;
                self::self::setCookieSystem((int)$_POST['inSystem'],$userData['USER_UUID']);
                echo '2';
            }
        }else{
            echo '0';
        }
    }
    
    public static function loginFb(){
        $conn = ConnectDB::getConnect();
        $fbId = htmlentities($conn->escape_string($_POST['fb_id']));
        $fbName = htmlentities($conn->escape_string($_POST['fb_name']));
        $sqlFind = "SELECT USER.* FROM \n".
                    "(\n".
                    "	SELECT * FROM USER \n".
                    ") AS USER\n".
                    "INNER JOIN \n".
                    "(\n".
                    "	SELECT USER_ID AS 'FB_USER_ID',FB_ID  FROM FB_USER\n".
                    "	WHERE FB_ID = '$fbId'\n".
                    ") AS FB_USER\n".
                    "ON USER.USER_ID = FB_USER.FB_USER_ID\n".
                    "LIMIT 1";
        $userData = $conn->query($sqlFind)->fetch_array();
        if($conn->affected_rows>0){
            $_SESSION['userData'] = $userData;
            $_SESSION['loginStatus'] = true;
            self::setCookieSystem((int)$_POST['inSystem'],$userData['USER_UUID']);
            echo 'have_fb_user';
        }else{
            $util = new ThewinUtil();
            //------- ถ้าไม่เจอให้เพิ่มuserใหม่ --------
            $sql = "INSERT INTO USER(USER_USERNAME,USER_NICKNAME,USER_PASSWORD,USER_UUID)"
                        ."VALUES('".$fbId."',"
                        ."'".$fbName."'"
                        .",'".sha1($fbId)."'"
                        .",'".$util->gen_uuid()."')";
            if($conn->query($sql)){ 
                    $sql = "INSERT INTO FB_USER(USER_ID,FB_ID) VALUES(".$conn->insert_id.",'".$fbId."')";
                    if($conn->query($sql)){
                            $userData = $conn->query($sqlFind)->fetch_array();
                            $_SESSION['userData'] = $userData;
                            $_SESSION['loginStatus'] = true;
                            self::setCookieSystem((int)$_POST['inSystem'],$userData['USER_UUID']);
                            echo 'new_fb_user';
                    }else{
                        echo $conn->error;
                    }
            }else{
                echo $conn->error;
            }
        }
    }

    public static function logout(){
        try {
            setcookie('loginID',null,time()+0,'/');
            session_destroy();
            echo 'true';
        } catch (Exception $e) {
            echo $e;
        }
    }
    
    public static function setCookieSystem($status,$userId){
        $day = 30;
        $timeCookie = ($status==1)?($day*60*60*24):1800;
        setcookie('loginID',$userId,time()+$timeCookie,'/');
        setcookie('loginTime',$timeCookie,time()+$timeCookie,'/');
    }

}
?>
