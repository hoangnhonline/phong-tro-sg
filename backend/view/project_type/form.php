<?php
if(isset($_GET['project_type_id'])){
    $project_type_id = (int) $_GET['project_type_id'];
    require_once "model/Ptype.php";
    $model = new Ptype;
    $detail = $model->getDetailPtype($project_type_id);
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=project_type&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($project_type_id > 0) ? "Cập nhật" : "Tạo mới" ?> loại dự án</h3>

            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Ptype.php">
                <?php if($project_type_id> 0){ ?>
                <input type="hidden" value="<?php echo $project_type_id; ?>" name="project_type_id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="project_type_name">Tên loại dự án</label>
                        <input  value="<?php echo isset($detail['project_type_name'])  ? $detail['project_type_name'] : "" ?>" type="text" name="project_type_name" id="project_type_name" class="form-control required">
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