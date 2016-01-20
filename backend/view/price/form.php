<?php
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("price",$id);
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=price&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Tạo mới" ?> khoảng giá</h3>

            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Price.php">
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Khoảng giá</label>
                        <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                    </div>
                    <div class="form-group">
                        <label for="name">Áp dụng cho</label>
                        <select class="form-control" name="type">
                            <option value="0">--Chọn--</option>
                            <option value="1" <?php echo (isset($detail['name']) && $detail['type']==1)  ? "selected"  : ""; ?>>BĐS cho thuê</option>
                            <option value="2" <?php echo (isset($detail['name']) && $detail['type']==2)  ? "selected"  : ""; ?>>BĐS bán</option>
                        </select>                        
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