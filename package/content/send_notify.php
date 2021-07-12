<?php
    include(__DIR__."/../controller/database.php");
    class Sender{
        protected $db = "des";
        public function __construct(){
           $this->db = ConnectDB::getConnect();
        }

        public function findWork(){
            $sql = "SELECT * FROM WORK WHERE " .
                    "		DATE(WORK_DEADLINE) " .
                    "		BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE,INTERVAL 3 DAY)" .
                    "		AND WORK_STATUS = 1";
            return $this->db->query($sql);
        }

        public function findUser(){
            $workList = $this->findWork();
            while(!is_null($item=$workList->fetch_array())){
                $sql = 'SELECT * FROM USER_LINE_TOKEN WHERE USER_ID='.$item["USER_ID"];
                $tokenUser = $this->db->query($sql);
                if(((int)$this->db->affected_rows)>0){
                    $message = ''
                    .'💡 '.$item["WORK_NAME"].' 💡'
                    ."                                                                                    "
                    .'[ใกล้ถึงกำหนดส่ง]'
                    ."                                                                                    "
                    .'📋 : '
                    .$item["WORK_DESC"].''
                    ."📆 : ".explode(" ",$item["WORK_DEADLINE"])[0].""
                    ."                                                                                    "
                    .'🔎 : web.todostudent.com';
                    $this->sendIt($tokenUser->fetch_array()["USER_TOKEN"],$message);
                }
            }
        }

        private function sendIt($token,$message){
            $curl = curl_init();
            curl_setopt_array($curl,[
                                            CURLOPT_URL => 'https://notify-api.line.me/api/notify',
                                            CURLOPT_CUSTOMREQUEST => 'POST',
                                            CURLOPT_POSTFIELDS => 'message='.$message,
                                            CURLOPT_HTTPHEADER => [
                                                'Authorization: Bearer '.$token,
                                                'Content-Type: application/x-www-form-urlencoded'
                                            ]
                                     ]);
        
            curl_exec($curl);
            curl_close($curl);
        }
    }
    $sender = new Sender();
    $sender->findUser();
?>