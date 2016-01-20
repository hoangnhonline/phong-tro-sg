<?php
if($_SESSION['level']==1){
    $arrCustom = array();    
}else{
    $arrCustom = array('user_id' => $_SESSION['user_id']);    
}
$id = 0;
$object_id = isset($_GET['object_id']) ? (int) $_GET['object_id'] : 0;
if(isset($_GET['object_type'])){
    $object_type = (int) $_GET['object_type'];    
}
$table = "objects";
$detailTaiSan = $detailHouse = array();
$detailTaiSan = $model->getDetail($table, $object_id);
if($detailTaiSan['house_id'] > 0){
    $detailHouse = $model->getDetail('house', $detailTaiSan['house_id']);
    $arrServiceHouse = $model->getHouseServices($detailTaiSan['house_id']);    
}
$detailHouse = $object_type == 2 ? $detailTaiSan : $detailHouse;

if($object_id > 0 && $object_type > 0){
    $addonArr = $model->getList('addon', -1, -1);
    $convenientArr = $model->getList('convenient', -1, -1);
    $serviceArr = $model->getList('services', -1, -1);
    $conArr = $model->getList('convenient', -1, -1);
    $customerArr = $model->getList('customers', -1, -1, $arrCustom);
    $arrAddonSelected = array();
    $cityArr = $model->getList('city', -1, -1);
    $wardArr = $model->getList('ward', -1, -1);
    
    $districtArr = $model->getList('district', -1, -1);
    
    $houseArr = $model->getList('house', -1, -1);
    $imageArr = $arrServiceSelected = array();
    $detail = $arrAddonSelected = array();
    if(isset($_GET['id'])){
        $id = (int) $_GET['id'];    
        $detail = $model->getDetail("contract", $id);
        $arrAddonSelected = $model->getListRoomInfo($id, 1);
        $arrConvenientSelected = $model->getListRoomInfo($id, 2);
        $imageArr = $model->getChild("images", "object_id", $id, 2);       
    }
?>

<div class="row">

    
    <?php if($id){ ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    <?php } ?>
    <div class="col-md-12">

        <!-- Custom Tabs -->

        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=contract&act=list'">Danh sách</button>
        <form method="post" action="controller/Contract.php">
            <input type="hidden" name="object_id" value="<?php echo $object_id; ?>">
            <input type="hidden" name="object_type" value="<?php echo $object_type; ?>">
        <div style="clear:both;margin-bottom:10px"></div>
        <input type="hidden" value="1" name="status" />
         <div class="box-header">

            <h3 class="box-title"><?php echo (isset($id) && $id > 0) ? "Cập nhật" : "Tạo mới" ?> hợp đồng </h3>
            <?php if($id > 0){ ?>
            <input type="hidden" value="<?php echo $id; ?>" name="id" />
            <?php } ?>
        </div><!-- /.box-header -->
        <div class="col-md-12">
            
            <div class="clearfix"></div>
        <div class="nav-tabs-custom">
            
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne"  style="background-color:#b3d9ff;color:#FFF">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Thông tin <?php echo $object_type == 1 ? "phòng" : "nhà" ; ?>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <div class="col-md-7" style="margin-top:20px">
                        <div class="form-group">
                            <label>Tên <?php echo $object_type == 1 ? "phòng" : "nhà"?> : </label>
                            <span class="value"><?php echo $object_type==1 ? $detailTaiSan['name'] : $detailHouse['name']; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ : </label>
                            <span class="value"><?php echo $detailHouse['address']; ?>, Phường <?php echo $wardArr['data'][$detailTaiSan['ward_id']]['name']; ?>, <?php echo $districtArr['data'][$detailTaiSan['district_id']]['name']; ?></span>                            
                        </div>
                        <?php if($object_type==1) {?>
                        <div class="form-group">
                            <label>Lầu : </label>
                            <span class="value"><?php echo $detailTaiSan['floor']; ?></span>                            
                        </div>
                        <div class="form-group">
                            <label>Giá thuê 1 tháng : </label>
                            <span class="value"><?php echo number_format($detailTaiSan['price_1']); ?></span>
                            <input type="hidden" id="h_price_1" name="h_price_1" value="<?php echo $detailTaiSan['price_1']; ?>"> 
                        </div>
                        <div class="form-group">
                            <label>Giá thuê 3 tháng : </label>
                            <span class="value"><?php echo number_format($detailTaiSan['price_3']); ?></span>  
                            <input type="hidden" id="h_price_3" name="h_price_3" value="<?php echo $detailTaiSan['price_3']; ?>">                           
                        </div>
                        <div class="form-group">
                            <label>Giá thuê 6 tháng : </label>
                            <span class="value"><?php echo number_format($detailTaiSan['price_6']); ?></span> 
                            <input type="hidden" id="h_price_6" name="h_price_6" value="<?php echo $detailTaiSan['price_6']; ?>">                            
                        </div>
                        <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo" style="background-color:#b3d9ff;color:#FFF">
              <h4 class="panel-title" >
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Thông tin khách hàng
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <div class="col-md-7" style="margin-top:20px">
                    <div class="form-group">
                        <label>Khách hàng</label>
                        <select class="form-control" id="kh_type">                        
                            <option value="1">Mới</option>
                            <option value="2">Cũ</option>
                        </select>                    
                    </div>
                    <div id="kh_new">
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <label class="radio-inline"><input type="radio" name="gender" id="gender_1" value="1"
                                <?php if((isset($detail['gender']) && $detail['gender'] == 1) || empty($detail)) { echo "checked"; } ?>
                                >Nam</label>
                            <label class="radio-inline"><input type="radio" name="gender" id="gender_2" value="2"
                                <?php if(isset($detail['gender']) && $detail['gender'] == 2) echo "checked"; ?>
                                >Nữ</label>
                        </div>
                        <div class="form-group">
                            <label for="name">Điện thoại</label>
                            <input  value="<?php echo isset($detail['phone'])  ? $detail['phone'] : "" ?>" type="text" name="phone" id="phone" class="form-control required">
                        </div>

                        <div class="form-group">
                            <label for="name">Email</label>
                            <input  value="<?php echo isset($detail['email'])  ? $detail['email'] : "" ?>" type="text" name="email" id="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="name">Ngày sinh</label>
                            <input  value="<?php echo isset($detail['birthday'])  ? $detail['birthday'] : "" ?>" type="text" name="birthday" id="birthday" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">CMND</label>
                            <input  value="<?php echo isset($detail['cmnd'])  ? $detail['cmnd'] : "" ?>" type="text" name="cmnd" id="cmnd" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Địa chỉ/Quê quán</label>
                            <textarea  name="address" id="address" class="form-control" rows="3"><?php echo isset($detail['address'])  ? $detail['address'] : "" ?></textarea>
                        </div>   
                    </div>
                    <div id="kh_cu" style="display:none;">
                        <div class="form-group">
                            <label>Tên khách hàng</label>
                            <select class="form-control selectpicker show-tick" data-live-search="true" id="customer_id" name="customer_id">                        
                                <option value="0">---chọn---</option>
                                <?php foreach($customerArr['data'] as $v) { ?>
                                <option <?php echo (!empty($detail) && $detail['customer_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                <?php } ?>
                            </select>                    
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree"  style="background-color:#b3d9ff;color:#FFF">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Thông tin hợp đồng
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thời hạn hợp đồng</label>
                        <select class="form-control selectpicker" id="no_month" data-live-search="true">                                    
                            <?php for($i=1; $i<=60; $i++){ ?>
                            <option value="<?php echo $i; ?>">
                                <?php 
                                
                                    echo $i." tháng";
                                
                                ?>
                                <?php 
                                if($i==12){
                                    echo  "( 1 năm )";
                                }elseif($i==24){
                                    echo "( 2 năm )";
                                }elseif($i == 36){
                                    echo "( 3 năm )";
                                }elseif($i == 48){
                                    echo "( 4 năm )";
                                }elseif($i == 60){
                                    echo "( 5 năm )";
                                }
                                ?>
                            </option>
                            <?php } ?>
                        </select>                    

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Giá thuê</label>
                        <input  value="<?php echo isset($detail['price'])  ? number_format($detail['price']) : number_format($detailTaiSan['price_1']); ?>" type="text" name="price" id="price" readonly="true" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Mã HĐ</label>
                        <input  value="<?php echo isset($detail['code'])  ? $detail['code'] : "" ?>" type="text" name="code" id="code" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Ngày kí HĐ</label>
                        <input  value="<?php echo isset($detail['contract_date'])  ? $detail['contract_date'] : "" ?>" type="text" name="contract_date" id="contract_date" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Ngày bắt đầu</label>
                        <input  value="<?php echo isset($detail['start_date'])  ? $detail['start_date'] : "" ?>" type="text" name="start_date" id="start_date" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Ngày kết thúc</label>
                        <input  value="<?php echo isset($detail['end_date'])  ? $detail['end_date'] : "" ?>" type="text" name="end_date" id="end_date" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Ngày đặt cọc</label>
                        <input  value="<?php echo (isset($detail['deposit_date']) && $detail['deposit_date'] != '0000-00-00')  ? $detail['deposit_date'] : "" ?>" type="text" name="deposit_date" id="deposit_date" class="form-control datepicker">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Số tiền cọc</label>
                        <input  value="<?php echo isset($detail['deposit'])  ? $detail['deposit'] : "" ?>" type="text" name="deposit" id="deposit" class="form-control number">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Số người ở</label>
                        <input  value="<?php echo isset($detail['no_person'])  ? $detail['no_person'] : "" ?>" type="text" name="no_person" id="no_person" class="form-control required">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Tiền thế chân</label>
                        <input  value="<?php echo number_format($detailTaiSan['deposit']); ?>" type="text"  class="form-control" readonly="true">
                        <input type="hidden" name="the_chan" id="the_chan" value="<?php echo ($detailTaiSan['deposit']); ?>"> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Số điện ban đầu</label>
                        <input  value="<?php echo isset($detail['so_dien'])  ? $detail['so_dien'] : "" ?>" type="text" name="so_dien" id="so_dien" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Số nước ban đầu</label>
                        <input  value="<?php echo isset($detail['so_nuoc'])  ? $detail['so_nuoc'] : "" ?>" type="text" name="so_nuoc" id="so_nuoc" class="form-control">
                    </div>
                </div> 
                <a style="float:right" class="btn btn-primary" id="calButton" data-toggle="modal" data-target="#calDiv">Tính tiền</a>   
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour"  style="background-color:#b3d9ff;color:#FFF">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Dịch vụ sử dụng
                </a>
              </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <div>
                    <?php //var_dump("<pre>", $arrServiceHouse); ?>
                     <?php if(!empty($arrServiceHouse)){ 
                            foreach($arrServiceHouse as $v) {                         
                        ?>
                        <div class="col-md-12">
                            <div class="col-md-1">                                   
                                
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <input type="checkbox"
                                <?php if($v['service_id'] == 1 || $v['service_id'] == 2) echo "checked"; ?>
                                 value="<?php echo $v['service_id']?>" name="service_id[]">
                                    <label><?php echo $serviceArr['data'][$v['service_id']]['name']; ?></label>                                        
                                    - <?php echo number_format($v['price']); ?> đ
                                    ( Tính tiền theo :
                                    <span><?php 
                                    if($v['cal_type'] == 1) echo "Phòng";
                                    if($v['cal_type'] == 2) echo "Số lượng người";
                                    if($v['cal_type'] == 3) echo "Số lượng sử dụng";
                                    ?></span> )
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                </div>
                            </div>
                        </div>
                        <?php } } ?>  
                </div>   
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingSix"  style="background-color:#b3d9ff;color:#FFF">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  Tiện nghi sử dụng thêm
                </a>
              </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
              <div class="panel-body">
                <div>
                    <?php //var_dump("<pre>", $arrServiceHouse); ?>
                     <?php if(!empty($conArr)){ 
                            foreach($conArr['data'] as $v) {   
                            //var_dump($v);                      
                        ?>
                        <div class="col-md-12">
                            <div class="col-md-1">                                   
                                
                            </div>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <input type="checkbox"                               
                                 value="<?php echo $v['id']?>" name="convenient_id[]">
                                    <label><?php echo $v['name']; ?></label>                                        
                                    - <?php echo number_format($v['price']); ?> đ                                   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                </div>
                            </div>
                        </div>
                        <?php } } ?>  
                </div>   
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFive"  style="background-color:#b3d9ff;color:#FFF">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFour">
                  Người ở cùng
                </a>
              </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                    <a style="float:right;margin-bottom:10px" class="btn btn-primary" id="addRoomate" >Thêm người</a>
                <div id="roomateDiv">
                    <div class="col-md-12 roomate" style="border:1px solid #CCC; padding:10px;margin-bottom:15px;">                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" name="name_roomate[]" class="form-control required">
                            </div>
                        </div>                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Giới tính</label><br />
                                <label class="radio-inline"><input type="radio" name="gender_roomate_0"  value="1" checked>Nam</label>
                                <label class="radio-inline"><input type="radio" name="gender_roomate_0" value="2">Nữ</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Điện thoại</label>
                                <input type="text" name="phone_roomate[]" class="form-control required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" name="email_roomate[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Ngày sinh</label>
                                <input type="text" name="birthday_roomate[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">CMND</label>
                                <input type="text" name="cmnd_roomate[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Địa chỉ/Quê quán</label>
                                <textarea  name="address_roomate[]" class="form-control" rows="3"></textarea>
                            </div>  
                        </div>
                    </div>
                </div>   
              </div>
            </div>
          </div>
        </div>

        </div><!-- nav-tabs-custom -->
        <div class="box-footer">
             <button class="btn btn-primary btnSave" type="submit">Save</button>
             <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=contract&act=list'">Cancel</button>
        </div>
        </div>
    </form>
</div>
<div class="modal fade" id="calDiv" tabindex="-1" role="dialog" aria-labelledby="calDivLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tính tiền</h4>
      </div>
      <div class="modal-body" id="contentCal"> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#addRoomate').click(function(){
        var count = $('.roomate').length;
        $.ajax({
            url: "ajax/roomate.php",
            type: "POST",
            async: true,
            data: {
                count : count
            },
            success: function(data){                    
                $('#roomateDiv').append(data);
            }
        });
    });
    $('#calButton').click(function(){
        var no_month = $('#no_month').val();
        var price_1 = $('#h_price_1').val();
        var price_3 = $('#h_price_3').val();
        var price_6 = $('#h_price_6').val();
        var no_person = $('#no_person').val();
        var the_chan = $('#the_chan').val();
        var deposit = $('#deposit').val();
        $.ajax({
            url: "ajax/cal.php",
            type: "POST",
            async: true,
            data: {
                no_month : no_month,
                price_1 : price_1,
                price_3 : price_3,
                price_6 : price_6,
                no_person : no_person,
                the_chan : the_chan,
                deposit : deposit
            },
            success: function(data){                    
                $('#contentCal').html(data);
            }
        });

    });
    $('#no_month').change(function(){
        var no_month = $('#no_month').val();
        var price_1 = $('#h_price_1').val();
        var price_3 = $('#h_price_3').val();
        var price_6 = $('#h_price_6').val();       
        $.ajax({
            url: "ajax/price.php",
            type: "POST",
            async: true,
            data: {
                no_month : no_month,
                price_1 : price_1,
                price_3 : price_3,
                price_6 : price_6               
            },
            success: function(data){                    
                $('#price').val(data);
            }
        });

    });
    $('#object_type').change(function(){        
        var value = $(this).val();
        if(value == 1){
            $('.type_room').show();
            $('.type_house').hide();
        }else{
            $('.type_room').hide();
            $('.type_house').show();
        }
    });
    $('#kh_type').change(function(){
        var value = $(this).val();
        if(value == 1){
            $('#kh_new').show();
            $('#kh_cu').val(0).hide();
        }else{
            $('#kh_new').hide();
            $('#kh_cu').show();
        }
    });

  
   
  
});

</script>
<?php } ?>