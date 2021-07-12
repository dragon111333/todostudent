//++++++++++++++++++++++++++++++++++++++++alertBLock++++++++++++++++++++++++++++++++++++++
  let pathController = location.origin+"/package/controller/controller.php";
  let projectPath = location.origin;
  function checker(element,doItFunction){
    Swal.fire({
                title: element.question,
                text: element.message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่'
            }).then((result) => {
                if (result.isConfirmed) {
                    doItFunction();
                }
          });
  }

  function callErrorAlertBox(){
    Swal.fire(
          'ผิดพลาด!',
          'เกิดข้อผิดพลาดไม่ทราบสาเหตุโปรดลองอีกครั้งภายหลัง',
          'error'
       );
  }

  function callSuccessAlertBox(element){
      Swal.fire(
             element.successMessage,
             element.successDesc,
             'success'
      );
  }

  function callWarningAlertBox(element){
        Swal.fire({
          title: element.message,
          text: element.desc,
          icon: 'warning',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'ตกลง'
        });
  }
  
  function callLoading(label){
        let timerInterval
              Swal.fire({
                title: label,
                timer: 10000,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading()
                },
                willClose: () => {
                  clearInterval(timerInterval)
                }
              })
  }
//++++++++++++++++++++++++++++++++++++++++alertBLock++++++++++++++++++++++++++++++++++++++

//++++++++++++++++++++++++++++++++++++++++UTIL++++++++++++++++++++++++++++++++++++++
  function stringToBool(str){
      return (String(str)==='true')?true:false;
  }
//++++++++++++++++++++++++++++++++++++++++UTIL(END)+++++++++++++++++++++++++++++++++
$('a').click(()=>{
      callLoading('กำลังโหลด...');
  });
