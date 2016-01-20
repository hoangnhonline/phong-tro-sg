<?php
if(isset($_GET['area_id'])){
    $area_id = (int) $_GET['area_id'];
    require_once "model/Area.php";
    $model = new Area;
    $detail = $model->getDetailArea($area_id);
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=area&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($area_id > 0) ? "Cập nhật" : "Tạo mới" ?> khoảng diện tích</h3>

            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Area.php">
                <?php if($area_id> 0){ ?>
                <input type="hidden" value="<?php echo $area_id; ?>" name="area_id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="area_name">Name</label>
                        <input  value="<?php echo isset($detail['area_name'])  ? $detail['area_name'] : "" ?>" type="text" name="area_name" id="area_name" class="form-control required">
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