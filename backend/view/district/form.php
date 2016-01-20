<?php
$id = 0;
$detail = array();
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];    
    $detail = $model->getDetail("district",$id);
}
$cityArr = $model->getList('city', -1, -1);
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=district&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Tạo mới" ?> quận/huyện</h3>

            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/District.php">
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label>Tỉnh / Thành<span class="required"> ( * ) </span></label>                        
                        <select class="form-control required select-change" data-table="district" data-child="district_id" name="city_id" id="city_id">
                            <option value="0">---chọn---</option>
                            <?php foreach($cityArr['data'] as $v) { ?>
                            <option <?php echo (!empty($detail) && $detail['city_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                <?php echo $v['name']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if($id > 0){ ?>
                     <div class="form-group">
                        <label for="name">Quận / huyện</label>
                        <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                    </div>
                    <?php }else{ ?>
                    <div class="form-group">
                        <label for="str_name">Quận / huyện (mỗi giá trị cách nhau bằng dấu ",")</label>
                        <input  value="" type="text" name="str_name" id="str_name" class="form-control required">
                    </div>
                    <?php } ?>                    
                </div><!-- /.box-body -->

                <div class="box-footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset">Cancel</button>
                </div>
            </form>
        </div>

    </div><!-- /.col -->
</div>