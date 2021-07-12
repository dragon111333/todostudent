<?php 
include __DIR__.'/../package/content/include/include.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="UTF-8">
      <title>การบ้านทั้งหมด</title>
  </head>
  <body>
          <div class="container" style='align:center'>
                        <br>
                        <div id="all_work_div">
                          <div class="row" id="all_work_row">
                            <?php
                            $allWork = getAllWork(1);
                            $i = 0;
                            while(($row=$allWork->fetch_array())!=null){
                                  if($i%2==0){?>
                                    <div class="w-100"></div><br>
                             <?php } ?>
                                  <div class="col-6">
                                                  <?php  
                                                      $cardColor = '';
                                                      $textDate = '';
                                                      if(strlen($row['WORK_DEADLINE'])<=1){
                                                            $cardColor = ((int)$row['WORK_DEADLINE']<=3)?'danger':'warning';
                                                            $textDate =  ((int)$row['WORK_DEADLINE']<=3)?'white':'dark';
                                                      }else{
                                                            $cardColor = 'primary';
                                                      } 
                                                  ?>
                                                      <div class="card border-<?php echo $cardColor ?>">
                                                          <div class="card-header bg-<?php echo $cardColor ?>">
                                                            <form style=>
                                                              <div class="form-row">
                                                                  <div class="col badge badge-white" style="text-align:left">
                                                                  <?php if(strlen($row['WORK_DEADLINE'])<=3){ ?>
                                                                          <p class="text-<?php echo $textDate ?>" style="font-size:13px;">
                                                                            <i class="fa fa-exclamation-circle text-white"></i>
                                                                              อีก <?php echo (int)$row['WORK_DEADLINE'] ; ?>วัน!
                                                                          </p>
                                                                      <?php }else{ ?>
                                                                          <i class="fa fa-calendar text-white"></i>
                                                                          <span name="all_deadline" class="text-white" style="font: size:8px;">
                                                                              <?php echo ThewinUtil::dateIsoToThai(explode(' ',$row['WORK_DEADLINE'])[0],' '); ?>
                                                                          </span>
                                                                        <?php } ?>
                                                                  </div>
                                                                    <div class="col float-right">
                                                                        <button class="btn btn-sm btn-dark float-right" type="button" onClick="del(<?php echo $row['WORK_ID']; ?>)">
                                                                          <i class="fa fa-times-circle"></i><br>
                                                                        </button>
                                                                    </div>
                                                              </div>
                                                            </form>
                                                          </div>
                                                        <div class="card-body bg-white">
                                                          <h2 class="text-primary" style="font-size:15px"><?php echo $row['WORK_NAME']; ?></h2>
                                                          
                                                          <textarea style="font-size:15px;width:100%;height:100px;border:none;" class="form-control bg-white text-dark" disabled><?php echo $row['WORK_DESC']; ?></textarea>
                                                          <br>
                                                        </div>
                                                        <div class="card-footer bg-white">
                                                              <form>
                                                                <div class="form-row">
                                                                      <div class="col col-6 mx-auto">
                                                                          <button class="btn btn-outline-success btn-md form-control" type="button" onClick="doneWork('<?php echo $row['WORK_ID']; ?>')">
                                                                          <i class="fa fa-check-circle "></i><br></button>
                                                                      </div>
                                                                      <div class="col col-6 mx-auto">
                                                                        <button type="button" class="btn btn-md btn-secondary form-control" data-toggle="modal" data-target="#update_data_modal" onClick="edit(<?php echo $row['WORK_ID']; ?>,'<?php echo $row['WORK_NAME']; ?>')">
                                                                        <i class="fas fa-search-plus"></i><br></button>
                                                                          <input type="hidden" id="descTemp<?php echo $row['WORK_ID']; ?>" value="<?php echo $row['WORK_DESC']; ?>">
                                                                          <input type="hidden" id="dateTemp<?php echo $row['WORK_ID']; ?>" value="<?php echo $row['ORIGIN_DEADLINE']; ?>">
                                                                      </div>
                                                                </div>
                                                            </form>
                                                          </div>  
                                                  </div>
                                                </div>
                                          <?php
                                          $i++;
                                        } 
                                        ?> 
                                  </div>
                            </div>
                        </div>
                            <button type="button" class="btn btn-lg btn-success float-right" 
                                style="position:fixed;bottom:50;right:30;float:right;font-size:20px" data-toggle="modal" data-target="#plus_data_modal">
                                           <i class="fa fa-plus-circle" ></i> เพิ่ม
                           </button>
                                            <br><br><br>
      <?php include ('modal_home.php') ;?>
      <script src="../package/content/js/script.js"></script> 
      <script>
           function loadWork(){
              $('#all_work_div').load(projectPath+"/home #all_work_row");
            }

            function doneWork(work_id){
                    let element = {
                                      'question':'เสร็จจริงเหรอ?'
                                      ,'message':'งานของคุณเสร็จแล้วจริงหรือไม่'    
                                      ,'successMessage':'ยินดีด้วย!'
                                      ,'successDesc':'งานของคุณเสร็จแล้ว!'
                      };
                    checker(element,()=>{
                          $.ajax({
                              type:"POST",
                              contentType:'application/x-www-form-urlencoded;charset=utf-8',
                              url:pathController,
                              data:{'id':work_id,'func':'doneWork'}
                          }).done((rs)=>{
                                if(stringToBool(rs)){
                                      loadWork();
                                      callSuccessAlertBox(element);
                                }else{  
                                      callErrorAlertBox();
                                }
                          });
                    })
                    
            };

            function del(id){
              let element = {
                      'question':'ต้องการลบ?'
                      ,'message':'คุณต้องการลบงานนี้'    
                      ,'successMessage':'ลบสำเร็จ!'
                      ,'successDesc':'ลบงานของคุณแล้ว!'
              };
              checker(element,()=>{
                  $.post(pathController,"id="+id+"&func=delWork")
                  .done((status)=>{
                      if(status){
                        loadWork();
                        callSuccessAlertBox(element);
                      }else{
                        callErrorAlertBox();
                      }
                  });
              });
            }

            function edit(id,name){
                    $('#update_id').val(id);
                    $('#update_name').val(name);
                    $('#update_descript').val($('#descTemp'+id).val());
                    $('#update_date').val($('#dateTemp'+id).val().split(' ')[0]);
            }

            function editWork(){
                    if($('#update_name').val()==='' || $('#update_descript').val()==='' 
                    || $('#update_date').val()===''){
                          callWarningAlertBox({'message':'ข้อมูลว่าง!','desc':'โปรดกรอกข้อมูลให้ครบ'});
                    }else{
                          $.ajax({
                              method:"POST",
                              contentType:"application/x-www-form-urlencoded;charset=utf-8",
                              url:pathController,
                              data:{
                                      "update_id":$('#update_id').val()
                                      ,"update_name":$('#update_name').val()
                                      ,"update_desc":$('#update_descript').val()
                                      ,"update_date":$('#update_date').val()
                                      ,"func":"editWork"
                                    }
                          }).done((status)=>{
                                console.log(status);
                                if(stringToBool(status)){
                                    callSuccessAlertBox({"successMessage":"แก้ไขแล้ว!","successDesc":"อัพเดทงานแล้ว"});
                                    loadWork();
                                    $('#update_data_modal').modal('hide');
                                }else{
                                    callErrorAlertBox();
                                    loadWork();
                                }
                          });
                    }
                    
            }

            $('#add_work').click(()=>{
                  let add_name = $('#add_name').val();
                  let add_descript = $('#add_descript').val();
                  let add_date = $('#add_date').val();
                  if(add_name==''||add_descript==''||add_date==''){
                      callWarningAlertBox({'message':'ข้อมูลว่าง!','desc':'โปรดกรอกข้อมูลให้ครบ'});
                  }else{;
                    $.ajax({
                        type:"POST",
                        contentType:'application/x-www-form-urlencoded;charset=utf-8',
                        url:pathController,
                        data:{'add_name':add_name,'add_descript':add_descript,'add_date':add_date,'func':'addWork'}
                    }).done((rs)=>{
                          if(stringToBool(rs)){
                            let element = {
                                      'successMessage':'เพิ่มแล้ว!'
                                      ,'successDesc':'เพิ่มงานใหม่แล้ว'
                              };
                            callSuccessAlertBox(element);
                            loadWork();
                            $('#plus_data_modal').modal('hide');
                          }else{
                              callErrorAlertBox();
                          }
                    });
                  }
            });
      </script>
  </body>
</html>
