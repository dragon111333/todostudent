<?php 
include __DIR__.'/../package/content/include/include.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="UTF-8">
      <title>การบ้าน</title>
  </head>
    <body>
      <div class="container" style='align:center'>
                    <br>
                    <div class="row" id="notify_row" style="text-align:center;">
                        <div class="col col-md-4 mx-auto" id="notify_div">
                          <div class="card">
                            <div class='card-header'>
                            <h4>รับการแจ้งเตือนผ่านไลน์</h4>
                              <p class="text-primary">แจ้งเตือนงาน</p>
                            </div>
                                <div class='card-body' style='overflow:auto;'>
                                    <?php if(checkRegisLineNotify()){ ?>
                                                <form>
                                                    <div class="form-row">
                                                        <div class="col col-8">
                                                                  <button type="button" style="width:100%" class="btn btn-md btn-success"><i class="fa fa-check"></i> รับการแจ้งเตือนแล้ว</button>
                                                        </div>
                                                        <div class="col col-4">
                                                                  <button type="button" style="width:100%;" onclick="cancel_notify()" class="btn btn-outline-danger">ยกเลิก</button>
                                                        </div>
                                                    </div>
                                                  </form>
                                    <?php }else{ ?>
                                                <form>
                                                    <div class="form-row" style="width:100%;">
                                                      <div class="col col-8">
                                                          <input type="text" class="form-control" id="user_token" placeholder="กรอก Token ของคุณ">
                                                      </div>
                                                      <div class="col col-4">
                                                            <button type="button" style="width:100%;" class="btn btn-outline-success" onclick="add_line_token()">ยืนยัน</button>
                                                      </div>
                                                    </div>
                                                </form>
                                    <?php } ?>
                              
                                </div>
                                    <div class="card-footer bg-white" style="border:none">
                                     <button type="button" class="btn btn-link float-left"><i class="fa fa-exclamation-circle">
                                                            </i>&nbsp;<a href="https://notify-bot.line.me/my/" target="_blank">รับToken</a></button>
                                    </div>
                            </div>
                    </div>
                  </div>
              </div>
        </div>
        <script src="../package/content/js/script.js"></script> 
        <script>
            function add_line_token(){
                    const token = $('#user_token').val();
                    if(token===''){
                      callWarningAlertBox({'message':'ข้อมูลว่าง!','desc':'โปรดกรอก Token'});
                    }else{
                      $.post(pathController,"user_token="+token+"&func=addLineToken")
                      .done((status)=>{
                        if(stringToBool(status)){
                            callSuccessAlertBox({"successMessage":"เพิ่มสำเร็จ!","successDesc":"รับการแจ้งเตือนผ่านLine Notify"});
                            $('#notify_row').load(projectPath+"/get_line_notify #notify_div");
                        }else{
                            callErrorAlertBox();
                        }
                      });
                    }
                }

              function cancel_notify(){
                    let element = {
                            'question':'ต้องการลบ?'
                            ,'message':'คุณต้องการลบงานนี้'    
                            ,'successMessage':'ลบสำเร็จ!'
                            ,'successDesc':'ลบงานของคุณแล้ว!'
                    };
                    checker(element,()=>{
                          $.post(pathController,'func=cancelLineNotify')
                          .done((status)=>{
                              if(stringToBool(status)){
                                callSuccessAlertBox({"successMessage":"ยกเลิกการแจ้งเตือนแล้ว!","successDesc":"ยกเลิกการแจ้งเตือนผ่านLine Notify"});
                                $('#notify_row').load(projectPath+"/get_line_notify/index.php #notify_div");
                              }else{
                                callErrorAlertBox();
                              }
                          });
                    })
                }
        </script>
  </body>
</html>
