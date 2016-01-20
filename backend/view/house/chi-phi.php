<?php

$house_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$detail = $model->getDetail("house",$house_id);
?>
<div class="row">
    <div class="col-md-6">

        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Thêm chi phí tháng của nhà : <?php echo $detail['name']; ?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Chiphi.php">                
                <div class="box-body">
                    <input type="hidden" value="<?php echo $house_id; ?>" name="house_id" /> 
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
                    <div class="form-group" id="div_chi_phi">
                        <button class="btn btn-danger" style="float:right;margin-bottom:10px" id="btnThem" type="button">Thêm chi phí</button>
                        <div class="clearfix"></div>         
                        <div class="row" style="margin-bottom:5px">
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Tên chi phí" name="name[]">
                              </div>
                              <div class="col-md-6">
                                <input type="text" class="form-control number" placeholder="Số tiền" name="price[]">
                              </div>  
                        </div>
                    </div>          
                    <div class="clearfix"></div>     
                </div><!-- /.box-body -->                
                <div class="clearfix"></div>
                <div class="box-footer" id="div_footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=addon&act=list'">Cancel</button>
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
    $('#btnThem').click(function(){
        var strHtml = '<div class="row" style="margin-bottom:5px"><div class="col-md-6"><input type="text" class="form-control" placeholder="Tên chi phí" name="name[]"></div>';
                   strHtml+='<div class="col-md-6"><input type="text" class="form-control number" placeholder="Số tiền" name="price[]"></div></div>';
                   $('#div_chi_phi').append(strHtml);
                   $('input.number').number(true);
    })
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