<?php include (__DIR__.'/../../controller/controller.php'); ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=0.8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="http://www.todostudent.com/thewin_util/util.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    
    <!-- Font from google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,200;0,300;0,500;1,400&display=swap" >
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position:fixed;width:100%;z-index:1000;">
        <a class="navbar-brand" id="munu_brand" href="/home">TODO STUDENT&nbsp;&nbsp;<?php if(checkLogin()){ ?>
                                                                                              <button class="btn btn-secondary btn-sm">งานที่เหลือ&nbsp;
                                                                                                <span class="badge bg-danger text-white" style="font-size:12px"><?php echo getCountWork() ?></span>
                                                                                              </button>
                                                                                     <?php }; ?></a>
                <?php if(checkLogin()){ ?>                                                                                
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                <?php } ?>
              <div class="collapse navbar-collapse" id="navbarText">
                      
                        <?php if(checkLogin()){?>
                          <ul class="navbar-nav mr-auto" id="div_menu">
                                  <li class="nav-item" name="menu"  id="menu_home">
                                          <a class="nav-link" href="/home">หน้าแรก  <span class="badge bg-danger text-white" ><?php echo getCountWork() ?></span></a>
                                  </li>
                                  <li class="nav-item" name="menu" id="menu_work_done">
                                    <a class="nav-link" href="/work_done" >งานที่ทำเสร็จแล้ว</a>
                                  </li>
                                  <li class="nav-item" name="menu" id="get_line_notify">
                                    <a class="nav-link" href="/get_line_notify" >รับการแจ้งเตือนผ่านไลน์</a>
                                  </li>
                                  <li class="nav-item" name="menu">
                                    <a class="nav-link" href="#" onClick="logout()">ออกจากระบบ</a>
                                  </li>
                            </ul>
                            <span class="navbar-text" style="font-size:20px;color:white;">
                                    <i class="fas fa-user-circle"></i>
                                    <?php echo $_SESSION['userData']['USER_NICKNAME'];?>
                            </span>
                        <?php } ?>
             
              </div>
    </nav>
    <br><br>
    <script>
        const checkPage=()=>{
          let link = String(location.href).split("/");
          let page = link[(link.length-2)];
          if(<?php echo (checkLogin())?'true':'false';?>==false){
                if(!(page=='regis'||page=='login')){
                  location.href = location.origin+'/login';
                }
          }else{ 
              const host = location.origin;
              let menu = '';
              document.getElementsByName('menu').forEach((item,i) => {
                                item.class = 'nav-item';
              });
              switch(page){
                  case 'home':
                        $('#menu_home').attr('class','nav-item active');
                         break;
                 case 'work_done':
                        $('#menu_work_done').attr('class','nav-item active');
                        break;
                 case 'get_line_notify':
                        $('#get_line_notify').attr('class','nav-item active');
                        break;
               }
              }
        }
        const logout=()=>{
                    callLoading('กำลังโหลด');
                    $.post(pathController,'func=logout')
                    .done((rs)=>{
                        if(stringToBool(rs)){
                            location.href = projectPath+'/login';
                        }
                    });
         }
     checkPage();
    </script>
    <!-- new- -->
  <style>
      body{
          background-color:#262626;
          background-position: center center;
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
          font-family: 'Prompt', sans-serif;
      }
      head{
        font-family: 'Prompt', sans-serif;
      }
      .btn{
        border-radius:60px;
      }
      .modal-content .form-control
      ,input[type="text"].form-control
      ,input[type="password"].form-control
      ,textarea.form-control
      {
          background-color:#E0E0E0;
          border:none;
          padding: 10px;
          box-shadow: 5px 5px 10px #C6C6C6;
      }
  </style>
