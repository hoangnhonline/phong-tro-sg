<?php
$id = 0;
$detail = array();
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];    
    $detail = $model->getDetail("ward",$id);
}
$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1);
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=ward&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Thêm mới" ?> Phường / xã</h3>

            </div><!-- /.box-header -->
            <div class="box-body">
            <!-- form start -->
            <form role="form" method="post" action="controller/Ward.php">
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
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
                    <div class="form-group">
                        <label>Quận/huyện<span class="required"> ( * ) </span></label>                        
                        <select class="form-control" name="district_id" id="district_id">
                            <option value="0">---chọn---</option>
                            <?php foreach($districtArr['data'] as $v) { ?>
                            <option <?php echo (!empty($detail) && $detail['district_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                <?php echo $v['name']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if($id > 0){ ?>
                     <div class="form-group">
                        <label for="name">Phường / Xã</label>
                        <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                    </div>
                    <?php }else{ ?>
                    <div class="form-group">
                        <label for="str_name">Phường / Xã (mỗi giá trị cách nhau bằng dấu ",")</label>
                        <input  value="" type="text" name="str_name" id="str_name" class="form-control required">
                    </div>
                    <?php } ?>
                         
                </div>
                <div class="box-footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=ward&act=list'">Cancel</button>
                </div>
            </form>
        </div>

    </div><!-- /.col -->
</div>