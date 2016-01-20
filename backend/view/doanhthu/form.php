<?php

$contract_id = isset($_GET['contract_id']) ? (int) $_GET['contract_id'] : 0;
$detail = $model->getDetail("contract",$contract_id);
$object_type = $detail['object_type'];
$object_id = $detail['object_id'];

if($object_type == 1){
    $detailObject = $model->getDetail('objects', $object_id);
    $house_id = $detailObject['house_id'];
    $arrServiceHouse = $model->getHouseServices($house_id);
    $conArr = $model->getList('convenient', -1, -1);
    $conArr = $conArr['data'];
   //var_dump("<pre>", $arrServiceHouse);
}
$haveDoanhThu = $model->checkDoanhThu($contract_id);
$serviceSelectedArr = $model->getContractService($contract_id);
$conSelectedArr = $model->getContractCon($contract_id);
//var_dump($detail);
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=doanhthu&act=list&contract_id=<?php echo $contract_id; ?>'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Thêm doanh thu tháng của HD : <?php echo $detail['code']; ?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Doanhthu.php">                
                <div class="box-body">
                    <input type="hidden" value="<?php echo $contract_id; ?>" name="contract_id" /> 
                    <div class="form-group">
                        <label for="name">Tháng</label>
                        <select class="form-control" name="month" id="month">
                            <option value="0">---chọn---</option>
                            <?php for($i = 1 ; $i < 13; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if($i==date('m')) echo "selected"; ?>>
                                Tháng <?php echo $i ;?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Năm</label>
                        <select class="form-control" name="year" id="year">
                            <option value="0">---chọn---</option>
                            
                            <option value="<?php echo date('Y'); ?>" selected >
                                <?php echo date('Y'); ?>
                            </option>
                            <option value="<?php echo date('Y')+1; ?>" >
                                <?php echo date('Y')+1; ?>
                            </option>
                            
                        </select>
                    </div>                    
                    <div class="form-group">
                        <label for="name">Tiền thuê</label>
                        <input class="form-control" readonly="true" name="price" value="<?php echo number_format($detail['price']); ?>" />
                        <input type="hidden" class='total' value="<?php echo $detail['price']; ?>"> 
                    </div>
                    <?php if($object_type == 1){ ?>
                    <fieldset>
                        <legend style="background-color:#ffcccc">Tiền dịch vụ</legend>

                        <?php 
                        foreach ($serviceSelectedArr as $key => $value) {
							//var_dump($value['cal_type']);
                            
                        ?>
                        <div class="col-md-12" style="border:1px solid #CCC; padding:10px;margin-bottom:10px">

                            <p style="font-weight:bold;font-size:15px;text-transform:uppercase;background-color:#CCC;padding:5px">
                                <?php echo $model->getNameById("services", $value['service_id']); ?>
                            </p>
                            <?php if($value['cal_type'] == 1){ ?>
                            Tính theo phòng : <span class="price"><?php echo number_format($arrServiceHouse[$value['service_id']]['price']); ?></span>
                            <input type="hidden" name="service_id[]" value="<?php echo $value['service_id']; ?>">
                            <input type="hidden" class="total" name="service_fee[<?php echo $value['service_id']; ?>]" value="<?php echo $arrServiceHouse[$value['service_id']]['price']; ?>">
                            <?php } ?>
                            <?php if($value['cal_type'] == 2){ ?>
                            <input type="hidden" name="service_id[]" value="<?php echo $value['service_id']; ?>">
                            Tính theo số người : <span class="price"><?php echo number_format($arrServiceHouse[$value['service_id']]['price']); ?> x <?php echo $detail['no_person']?> = <?php echo number_format($arrServiceHouse[$value['service_id']]['price']*$detail['no_person']);?></span>
                            <input type="hidden" class="total" name="service_fee[<?php echo $value['service_id']; ?>]" value="<?php echo ($arrServiceHouse[$value['service_id']]['price']*$detail['no_person']);?>">
                            <?php } ?>

                            <?php if($value['cal_type'] == 3){ ?>
                            <h4>Tính theo số lượng sử dụng</h4><br>
                            <div class='row'>

                               
                                <div class="col-md-5">
                                    <div class='form-group'>                                
                                        <label>Chỉ số cũ</label>
                                        <input type="text" class="form-control chiso" id="chi_so_cu_<?php echo $value['service_id']; ?>" name="chi_so_cu[]">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class='form-group'>                                
                                        <label>Chỉ số mới</label>
                                        <input type="text" class="form-control chiso" id="chi_so_moi_<?php echo $value['service_id']; ?>" name="chi_so_moi[]">
                                    </div>
                                </div>
                                <div class="col-md-2"><br>
                                    <a class="btn btn-default btnCal" data-value="<?php echo $value['service_id']; ?>">Thành tiền</a>
                                </div>
                                <div class="col-md-12">
                                    <div class='form-group'>                                
                                        <label>Đơn giá</label>
                                        <span class="price"><?php echo number_format($arrServiceHouse[$value['service_id']]['price']); ?></span>
                                        <input type="hidden" id='don_gia_<?php echo $value['service_id']; ?>' value='<?php echo $arrServiceHouse[$value['service_id']]['price']; ?>'>
                                    </div>
                                </div>
                                <div class='col-md-12' style="display:none;" id="div_total_<?php echo $value['service_id']; ?>">
                                    <div class='form-group'>                                
                                        <label>Thành tiền</label>    
                                        <span class="price" id="total_span_<?php echo $value['service_id']; ?>"></span>                                
                                        <input type="hidden" class="total" id="total_<?php echo $value['service_id']; ?>" name="total[]">
                                        <input type="hidden" name="service_id_chiso[]" value="<?php echo $value['service_id']; ?>">
                                        <input type="hidden" name="service_id_chi_so_price[]" value="<?php echo $arrServiceHouse[$value['service_id']]['price']; ?>">
                                        <input type="hidden" id="total_price_<?php echo $value['service_id']; ?>" name="service_id_total_price[]" value="<?php echo $arrServiceHouse[$value['service_id']]['price']; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php }?>
                    </fieldset>
                    <?php } ?>
                    <fieldset>
                        <legend style="background-color:#ffcccc">Tiền tiện nghi sử dụng thêm</legend>
                        <?php 
                        foreach ($conSelectedArr as $key => $value) {
                            
                        ?>
                        <div class="col-md-12" style="border:1px solid #CCC; padding:10px;margin-bottom:10px">                                                     
                            <?php echo $model->getNameById("convenient", $value['convenient_id']); ?> : <span class="price"><?php echo number_format($conArr[$value['convenient_id']]['price']); ?></span>
                            <input type="hidden" name="convenient_id[]" value="<?php echo $value['convenient_id']; ?>">
                            <input type="hidden" class="total" name="convenient_fee[<?php echo $value['convenient_id']; ?>]" value="<?php echo $conArr[$value['convenient_id']]['price']; ?>">
                          
                        </div>
                        <?php }?>
                    </fieldset>
                    <button id="btnTinhTien" type="button" class="btn btn-danger" style="float:right">TÍNH TIỀN</button>
                    <div class="clearfix"></div>
                    <div id="div_thanh_tien" style="display:none;">
                        <p style="margin-top:20px;border-bottom:1 px solid #ccc;padding:10px;padding-left:5px;background-color:#CCC;font-weight:bold">THÀNH TIỀN</p>
                        <div class="form-group">
                            <label for="name">Số tiền phải thu</label>
                            <input class="form-control number" readonly="true" name="tien_phai_thu" id="tien_phai_thu" />                          
                        </div>
                        <div class="form-group">
                            <label for="name">Số tiền nhận</label>
                            <input class="form-control number" name="tien_nhan" value="" id="tien_nhan" />
                        </div>
                        <div class="form-group">
                            <label for="name">Còn nợ lại</label>
                            <input class="form-control number" readonly="true" name="cong_no" value="0" id="cong_no" />
                        </div>
                    </div>
                </div><!-- /.box-body -->                
                
                <div class="box-footer" style="display:none;" id="div_footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=doanhthu&act=list&contract_id=<?php echo $contract_id; ?>'">Cancel</button>
                </div>
            </form>
        </div>

    </div><!-- /.col -->
</div>
<style type="text/css">
    span.price {font-weight: bold; font-size: 20px;float: right}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $('.btnCal').click(function(){
        var id = $(this).attr('data-value');
        if($('#chi_so_cu_' + id).val() == '' || $('#chi_so_moi_' + id).val() == ''){
            alert('Vui lòng nhập đầy đủ chỉ số cũ và mới');return false;            
        }
        var dongia = parseInt($('#don_gia_' + id).val());        
        var chisocu = parseInt($('#chi_so_cu_' + id).val());
        var chisomoi = parseInt($('#chi_so_moi_' + id).val());       
        if(chisomoi < chisocu){
            alert('Chỉ số mới phải lớn hơn chỉ số cũ'); return false;
        }
        var total = (chisomoi - chisocu)*dongia;
        $('#total_' + id).val(total);
        $('#total_span_' + id).html(addCommas(total));
        $('#total_price_' + id).html(total);
        $('#div_total_' + id).show();
    });
    $('#btnTinhTien').click(function(){
        var countEmpty = 0;
        $('input.chiso').each(function(){
            if($(this).val() == ''){
                countEmpty++;
            }
        });
        if(countEmpty > 0){
            alert('Vui lòng nhập đầy đủ chỉ số cũ và mới'); return false;
        }else{
            $('.btnCal').click();
            var total = 0;
            $('input.total').each(function(){
                var value = parseInt($(this).val());
                total = total + value;
            });
            $('#tien_phai_thu, #cong_no').val(total);            
            $('#div_thanh_tien, #div_footer').show();

        }
    });
    $('#tien_nhan').keyup(function(){
        var tien_phai_thu = $('#tien_phai_thu').val();
        var tien_nhan = $(this).val();
        var cong_no = tien_phai_thu - tien_nhan;
        $('#cong_no').val(cong_no);

    });
});
function addCommas(nStr)
{
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
}
</script>