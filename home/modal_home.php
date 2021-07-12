   <!-- Plus Data Modal -->
   <div class="modal fade text-success" id="plus_data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-white">
            <h5 class="modal-title text-success" style="font-size:25px"><i class="fa fa-plus"></i>&nbsp;เพิ่มงาน</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                      <label for="add_name">ชื่องาน</label>
                      <input type="text" class="form-control" id="add_name" placeholder="ชื่องาน">
                    </div>
                    <div class="form-group">
                      <label for="add_descript">อธิบาย</label>
                      <textarea class="form-control" id="add_descript" placeholder="คำอธิบาย" style="height:200px"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="add_date">กำหนดส่ง</label>
                      <input type="date" class="form-control" id="add_date" placeholder="วันที่">
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
              <button type="button" id="add_work" class="btn btn-primary">ยืนยัน</button>
            </div>
          </div>
        </div>
      </div>
      <!-- modal update -->
       <div class="modal fade text-primary" id="update_data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-white">
              <h5 class="modal-title"style="font-size:25px"><i class="fa fa-edit"></i>&nbsp;รายระเอียด</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                      <label for="update_name">ชื่องาน</label>
                      <input id="update_id" type="hidden" value="">
                      <input type="text" class="form-control bg-" id="update_name" placeholder="ชื่องาน">
                    </div>
                    <div class="form-group">
                      <label for="update_descript">อธิบาย</label>
                      <textarea class="form-control" id="update_descript" placeholder="คำอธิบาย" style="height:200px"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="update_date">กำหนดส่ง</label>
                      <input type="date" class="form-control" id="update_date" placeholder="วันที่">
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
              <button type="button" onClick="editWork()" class="btn btn-primary">แก้ไข</button>
            </div>
          </div>
        </div>
      </div>