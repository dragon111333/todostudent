<?php 
include __DIR__.'/../package/content/include/include.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta charset="UTF-8">
      <title>งานที่เสร็จแล้ว</title>
      <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
      <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  </head>
    <body>
    <style>
        td{
            border-right:0.5px solid #C9C9C9;
        }
    </style>
      <div class="container" style='align:center'>
                    <br>
                    <div class="row" id="work_done_row">
                        <div class="col" id="work_done_col">
                          <div class="card w-100">
                            <div class="card-header bg-white border-white text-success" style="text-align:center;">
                                      
                                      <h1 style="font-size:25px"><i class="fas fa-chart-pie"></i> งานที่เสร็จแล้ว</h1>
                            </div>
                            <div class='card-body' style='overflow:auto;'>
                              <table id="user_work"  class="table w-100">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col" style="width:1px;"></th>
                                    <th scope="col">ชื่องาน</th>
                                    <th scope="col">อธิบาย</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody id='user_work_body'>
                                    <?php 
                                    $result = getAllWork(0);
                                    if(mysqli_num_rows($result)<=0){ ?>
                                                <tr>
                                                      <td colspan="5" style="text-align:center;">
                                                      <h2 class="text-primary" style="font-size:18px">เยี่ยมมากทำงานเสร็จหมด!</h2></td>
                                                </tr>
                                      <?php }else{
                                              $i=1;
                                              $textLimit = 35;
                                              while(($row=$result->fetch_array())!=null){ ?>
                                                            <tr>
                                                                <td><?php echo $i ?></td>
                                                                <td class="text-sucess"><p style="font-size:10px" class="badge text-primary">
                                                                      <?php echo (strlen($row['WORK_NAME']>$textLimit))?substr($row['WORK_NAME'],0,$textLimit).'...':$row['WORK_NAME']; ?></p>
                                                                </td>
                                                                <td>
                                                                    
                                                                      <pre><?php 
                                                                              $line = explode('\n',$row['WORK_DESC'])[0];
                                                                              echo (strlen($line)>$textLimit)?substr($row['WORK_DESC'],0,$textLimit).'...':$row['WORK_DESC']; 
                                                                        ?></pre>
                                                                </td>
                                                                <td><button class="btn btn-sm btn-danger form-control" type="button" onClick="del('<?php echo $row['WORK_ID'] ?>')">
                                                                <i class="fa fa-times-circle"></i><br></button></td>
                                                            </tr>
                                                    
                                              <?php 
                                                $i++;
                                              }
                                        }
                                    ?>
                                </tbody>
                              </table>
                            </div>
                    </div>
                  </div>
              </div>
              <br><br>
              <div class="row" >
                  <div class="col"> 
                          <div class="card w-100">
                              <div class="card-header bg-white border-white text-primary" style="text-align:center;">
                                  <h1 style="font-size:25px"><i class="fas fa-chart-bar"></i> ผลสรุปงานทั้งหมด</h1>
                              </div>
                              <div class="card-body" id="chart_body">
                                  <div id="chart_col"> 
                                      <div class="row">
                                        <div class="col col-md-12 mx-auto">
                                            <div id="chart"></div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col col-md-12 mx-auto">
                                            <div id="chart2"></div>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                  </div>
              </div>
        </div>
    <?php include ('chart.php');?>
    <script src="../package/content/js/script.js"></script> 
    <script>
        function loadTable(){
          $('#user_work').DataTable({
                                "scrollY":"300px",
                                "scrollX":true,
                                "scrollCollapse":true,
                                "paging":false,
                                "bDestroy":true,
                                "bLengthChange": false,
                                "bFilter": false,
                                "ordering": false,
                                  "bInfo": false
          });
        }
        
        loadTable();

        function loadWork(){
              $('#work_done_row').load(projectPath+"/work_done #work_done_col");
              chartTopRender(chartBottomRender);
              setTimeout(() => {loadTable();}, 500);
        }
        
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
                      if(stringToBool(status)){
                        loadWork();
                        callSuccessAlertBox(element);
                      }else{
                        callErrorAlertBox();
                      }
                  });
              });
            }
    </script>
  </body>
</html>
