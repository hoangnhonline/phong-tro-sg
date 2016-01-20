<?php 
if(isset($_GET['time_id'])){
    $time_id = (int) $_GET['time_id'];
    require_once "model/Time.php";
    $model = new Time;
    $detail = $model->getDetailTime($time_id);
}
?>
<div class="row">
    <div class="col-md-8">
        
        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($time_id > 0) ? "Cập nhật" : "Tạo mới" ?> giờ khởi hành</h3>
                
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Time.php">
                <?php if($time_id> 0){ ?>
                <input type="hidden" value="<?php echo $time_id; ?>" name="time_id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Giờ</label>
                        <input  value="<?php echo isset($detail['time_start'])  ? $detail['time_start'] : "" ?>" type="text" name="time_start" id="time_start" class="form-control required">
                    </div>                  
                </div><!-- /.box-body -->

                <div class="box-footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset">Cancel</button>
                </div>
            </form>
        </div>

    </div><!-- /.col --> 
</div>