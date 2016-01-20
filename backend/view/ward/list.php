<?php
require_once "model/Backend.php";
$model = new Backend;

$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1);

$link = "index.php?mod=ward&act=list";

$arrCustom = array('city_id' => -1, 'district_id' => -1);

foreach ($arrCustom as $key => $value) {
    if (isset($_GET[$key]) && $_GET[$key] > 0) {
        $tmp = (int) $_GET[$key];
        $link.="&".$key."=".$tmp;
        $arrCustom[$key] = $tmp;
    }
}
$table = "ward";
$listTotal = $model->getList($table, -1, -1, $arrCustom);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT, $arrCustom);


?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=ward&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách phường xã</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <div class="panel panel-default">
                  <div class="panel-heading">Tìm kiếm</div>
                  <div class="panel-body">
                    <form class="form-inline">
                        <input type="hidden" name="mod" value="ward" />
                        <input type="hidden" name="act" value="list" />
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city_id">Tỉnh/Thành</label><br />
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="district_id">Quận/Huyện</label><br />
                            <select class="form-control" name="district_id" id="district_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($districtArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['district_id']) && $_GET['district_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-4"><br />
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                      
                      
                      
                    </form>
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                        
                        <th>Phường / xã</th>
                        <th style="text-align:center">Quận / Huyện</th>
                        <th style="text-align:center">Tỉnh / Thành</th>
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
                            <a href="index.php?mod=ward&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                        </td>
                        <td align="center"><?php echo $model->getNameById('district', $row['district_id']); ?></td>
                        <td align="center"><?php echo $model->getNameById('city', $row['city_id']); ?></td> 
                        <td align="center"><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>
                        <td align="center"><?php echo date('d-m-Y H:i',$row['updated_at']); ?></td>
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=ward&act=form&id=<?php echo $row['id']; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="ward" class="link_delete" >
                                <i class="fa fa-fw fa-trash-o"></i>
                            </a>

                        </td>
                    </tr>
                    <?php } }  ?>
                </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">              
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->

</div>