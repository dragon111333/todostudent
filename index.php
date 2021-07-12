<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>จดการบ้านง่ายๆ</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
      <!-- Font from google -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet"href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,200;0,300;0,500;1,400&display=swap">
</head>
<style>
    .center_point{
      position: absolute;
      top: 50%;
      left: 50%;
      -webkit-transform: translateX(-50%) translateY(-60%);
    }
    img{
      width:150px;
      height:150px;
    }
    #loader{
      color:white;
      font-size:50px;
    }
    body{
      background-color:#393939;
      font-family: 'Prompt', sans-serif;
    }
    span{
      font-size:30px;
      color:white;
    }
    footer{
      width:100%;
      text-align:center;
      bottom:0;
      position:absolute;
      color:#AEAEAE;
      font-size:12px;
    }
</style>
<body style="text-align:center;">

    <div class="center_point">
        <img src="package/content/include/icon_cir.png">
        <br><br><br>
        <span>TODO</span>&nbsp;&nbsp;<span style="color:#9CCBDC">STUDENT</span>
        <br><br><br>
        <i id="loader" class="fas fa-clock fa-spin" style="display:none;"></i>
    </div>
<footer>
    <div style="width:100%;"><i class="fa fa-cogs"></i> Made by<strong> Thewin</strong>, thank you.</div>
    <br>
</footer>
<script>
     setTimeout(()=>{$('#loader').attr('style','display:inline;'); },1000);
     setTimeout(()=>{location.href = "https://"+location.hostname+"/home";},2000);
</script>
</body>

</html>