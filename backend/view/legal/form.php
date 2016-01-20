<?php
if(isset($_GET['legal_id'])){
    $legal_id = (int) $_GET['legal_id'];
    require_once "model/Legal.php";
    $model = new Legal;
    $detail = $model->getDetailLegal($legal_id);
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=legal&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($legal_id > 0) ? "Cập nhật" : "Tạo mới" ?> khoảng giá</h3>

            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Legal.php">
                <?php if($legal_id> 0){ ?>
                <input type="hidden" value="<?php echo $legal_id; ?>" name="legal_id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="legal_name">Name</label>
                        <input  value="<?php echo isset($detail['legal_name'])  ? $detail['legal_name'] : "" ?>" type="text" name="legal_name" id="legal_name" class="form-control required">
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