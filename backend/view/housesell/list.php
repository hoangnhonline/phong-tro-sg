<?php
require_once "model/Backend.php";
$model = new Backend;

$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1);
$wardArr = array();
if(isset($_GET['district_id']) && $_GET['district_id'] > 0){
    $arrCustomWard['district_id'] = $_GET['district_id'];
    $wardArr = $model->getList('ward', -1, -1, $arrCustomWard);
}
$link = "index.php?mod=housesell&act=list";

$arrCustom = array('object_type' => 3,'city_id' => -1, 'district_id' => -1, 'ward_id' => -1 , 'name' => '','status' => 1);

foreach ($arrCustom as $key => $value) {
    if ((isset($_GET[$key]) && $_GET[$key] > 0) || ($_GET[$key] != '' && $_GET[$key] != '-1' && $_GET[$key] != '0')) {
        $tmp = $_GET[$key];
        $link.="&".$key."=".$tmp;
        $arrCustom[$key] = $tmp;
    }
}
if($_SESSION['level']==1){
    $arrCustom['user_id'] = -1;    
}else{
    $arrCustom['user_id'] = $_SESSION['user_id'];    
}
$table = "objects";
$listTotal = $model->getList($table, -1, -1, $arrCustom);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT, $arrCustom);


?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=housesell&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách nhà bán</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <div class="panel panel-default">
                  <div class="panel-heading">Tìm kiếm</div>
                  <div class="panel-body">
                    <form class="form-inline">
                        <input type="hidden" name="mod" value="housesell" />
                        <input type="hidden" name="act" value="list" />
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="name">Tên  nhà</label><br>
                           <input name="name" id="name" class="form-control" value="<?php echo (isset($_GET['name']) && $_GET['name']!= '') ? $_GET['name'] : ""; ?>">
                          </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="city_id">Tỉnh/Thành</label><br >
                            <select class="form-control select-change" data-table="district" data-type="list" data-child="district_id" name="city_id" id="city_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($cityArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['city_id']) && $_GET['city_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="district_id">Quận/Huyện</label><br >
                            <select class="form-control select-change" data-table="ward" data-type="list" data-child="ward_id" name="district_id" id="district_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($districtArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['district_id']) && $_GET['district_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ward_id">Phường / Xã</label><br >
                            <select class="form-control" name="ward_id" id="ward_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($wardArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['ward_id']) && $_GET['ward_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-2"><br >
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>                      
                    </form>
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                        
                        <th>Tên nhà</th>                        
                        <th style="text-align:center">Ngày tạo</th>
                        <th style="text-align:center">Cập nhật lần cuối</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                    <?php
                    $i = ($page-1) * LIMIT;
                    if(!empty($list['data'])){
                    foreach ($list['data'] as $key => $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>                       
                        <td>
                            <a href="index.php?mod=housesell&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                            <br />
                            Địa chỉ : <?php echo $row['address']; ?>, Phường <?php echo $model->getNameById('ward', $row['ward_id']); ?>, <?php echo $model->getNameById('district', $row['district_id']); ?>, <?php echo $model->getNameById('city', $row['city_id']); ?>
                        </td>                       
                        <td align="center"><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>
                        <td align="center"><?php echo date('d-m-Y H:i',$row['updated_at']); ?></td>
                        <td style="white-space:nowrap">
                            <a class="btn btn-sm btn-info" href="index.php?mod=housesell&act=view&id=<?php echo $row['id']; ?>" title="Xem chi tiết">
                                Xem chi tiết
                            </a>&nbsp;
                            <a class="btn btn-sm btn-warning" href="index.php?mod=housesell&act=form&id=<?php echo $row['id']; ?>">
                                Chỉnh sửa
                            </a>
                            <a class="btn btn-sm btn-danger" href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="house" class="btn btn-sm btn-danger link_delete" >
                                Xóa
                            </a>

                        </td>
                    </tr>
                    <?php } } else{  ?>
                    <tr>
                        <td colspan="5">Không tìm thấy dữ liệu.</td>
                    </tr>
                    <?php } ?>
                </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">              
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->

</div>