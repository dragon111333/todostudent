<?php 
    class ThewinUtil{
        //--- [yyyy-mm-dd] ---
         function toThaiMonth($dateNum){
                $date = '';
                switch((int)$dateNum){
                    case 1:
                        $date = 'ม.ค.';
                        break;
                    case 2:
                        $date = 'ก.พ.';
                        break;
                    case 3:
                        $date = 'มี.ค.';
                        break;
                    case 4:
                        $date = 'ม.ย.';
                        break;
                    case 5:
                        $date = 'พ.ค.';
                        break;
                    case 6:
                        $date = 'มิ.ย.';
                        break;
                    case 7:
                        $date = 'ก.ค.';
                        break;
                    case 8:
                        $date = 'ส.ค.';
                        break;
                    case 9:
                        $date = 'ก.ย.';
                        break;
                    case 10:
                        $date = 'ต.ค.';
                        break;
                    case 11:
                        $date = 'พ.ย.';
                        break;
                    case 12:
                        $date = 'ธ.ค.';
                        break;
                }
                return $date;
        }

        function gen_uuid() {
            
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
               
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        
                mt_rand( 0, 0xffff ),

                mt_rand( 0, 0x0fff ) | 0x4000,

                mt_rand( 0, 0x3fff ) | 0x8000,
        
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }

        function dateIsoToThai($date,$dt){
               $util = new ThewinUtil();
               $date = explode('-',$date);
               return (string)( (int) $date[2]) 
                                .$dt. $util->toThaiMonth($date[1])
                                .$dt. ((int)$date[0]+543);
        }
       
    }
?>