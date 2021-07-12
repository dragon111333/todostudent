<?php include __DIR__.'/../package/content/include/include.php';?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>เข้าสู่ระบบ</title>
    <script src="https://www.google.com/recaptcha/api.js?render=6Lcu52kaAAAAAO7KX1ayyxhI3D2jm3OvaBtbpYC4"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
  </head>
  <body>
    <div class="container" style='align:center'>
      <br>
        <div class="row">
          <div class="col-md-4 mx-auto">
                <div class="alert alert-secondary text-dark">
                                <div class="alert-body" style="text-align:center;">
                                    <h5 style="font-size:20px">เข้าสู่ระบบ</h5>
                                    <p class="badge badge-primary text-white">โปรดสมัครสมาชิก</p>
                                </div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4 mx-auto">
            <div class="card">
              <div class='card-body' style="text-align:center;overflow:auto;">
                          <br><br>
                          <div onlogin="checkLoginStateFB();" class="fb-login-button" data-width="300" data-size="large" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true"></div>
                          <br><br>
                          <button type="button" id="inSystemCheck" class="btn btn-sm btn-outline-info">
                            <i class="far fa-check-circle" id="checkIcon" ></i><span> อยู่ในระบบ</span>
                        </button>
                        <br>
                        <br><br>
          </div>
      </div>
    </div>
  </div>
</div>
<footer style="background-color:#232324;width:100%;text-align:center;bottom:0;position:absolute;height:35px;color:white;font-size:8px">
    <div style="height:10px"></div>
<div class='text-muted'><i class="fa fa-cogs"></i> Made by<strong> Thewin</strong>, thank you.</div>
</footer>
 <script src="/../package/content/js/script.js"></script> 
 <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '185324913562786',
      cookie     : true,                     // Enable cookies to allow the server to access the session.
      xfbml      : true,                     // Parse social plugins on this webpage.
      version    : 'v1.0'                   // Use this Graph API version for this call.
    });
  };
    let inSystemChecker = false;
    $('#login_buuton').click(()=>{
              const user_name = String($('#user_name').val());
              const user_password = String($('#user_password').val());
              if(user_name===''||user_password===''){
                  callWarningAlertBox({'message':'ข้อมูลว่าง!','desc':'โปรดกรอกข้อมูลให้ครบ'});
              }else{
                  callLoading('กำลังตรวจสอบ!');
                  $.ajax({
                    type:'POST',
                    contentType:'application/x-www-form-urlencoded;charset=utf-8',
                    url:pathController,
                    data: {'username':user_name,'password':user_password,'inSystem':(i)?1:0,'func':'authen'}
                  }).done((rs)=>{
                    console.log(rs);
                     switch(rs){
                       case '0':
                          callWarningAlertBox({'message':'ไม่พบผู้ใข้นี้!','desc':'โปรดตรวจสอบข้อมูล'});
                          break;
                        case'1':
                          callWarningAlertBox({'message':'รหัสผ่านไม่ถูกต้อง!','desc':'โปรดตรวจสอบข้อมูล'});
                          break;
                        case'2':
                          location.href = projectPath+'/home';
                          break;
                     }
                  });
              }
          });
         $('#inSystemCheck').click(()=>{
                    inSystemChecker = !inSystemChecker;
                    if(inSystemChecker){
                        $('#checkIcon').attr('class','fas fa-check-circle');
                        $('#inSystemCheck').attr('class','btn btn-sm btn-success');
                    }else{
                      $('#checkIcon').attr('class','far fa-check-circle');
                      $('#inSystemCheck').attr('class','btn btn-sm btn-outline-secondary');
                    }
          });
          function checkLoginStateFB() {              
            FB.getLoginStatus(function(response) {  
                  if(String(response.status)==="connected"){
                        new Promise((resolve,reject)=>{
                            FB.api("/me",(res)=>{resolve(res);});
                        }).then((result)=>{
                            loginByFB(result);
                        })
                  }
            });
          }
          function loginByFB(data){
             $.ajax({
                  "type":"POST",
                  "contentType":"application/x-www-form-urlencoded;charset=utf-8",
                  "url":pathController,
                  "data":{"fb_id":data.id,"fb_name":data.name,'inSystem':(i)?1:0,"func":"loginFb"}
             })
             .done((response)=>{
                  console.log(response);
                  if(String(response)==="have_fb_user"||String(response)==="new_fb_user"){
                        location.href = projectPath+'/home';
                  }else{
                    callWarningAlertBox({'message':'เกิดข้อผิดพลาด!','desc':'โปรดลองอีกครั้ง'});
                  }
             });
          }
 </script>
</body>
</html>
