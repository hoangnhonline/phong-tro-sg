<?php
require_once "model/Backend.php";
$model = new Backend;

$cityArr = $model->getList('city', -1, -1);

$link = "index.php?mod=district&act=list";

$arrCustom = array('city_id' => -1);

foreach ($arrCustom as $key => $value) {
    if (isset($_GET[$key]) && $_GET[$key] > 0) {
        $tmp = (int) $_GET[$key];
        $link.="&".$key."=".$tmp;
        $arrCustom[$key] = $tmp;
    }
}
$table = "district";
$listTotal = $model->getList($table, -1, -1, $arrCustom);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT, $arrCustom);


?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=district&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách quận/huyện</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <div class="panel panel-default">
                  <div class="panel-heading">Tìm kiếm</div>
                  <div class="panel-body">
                    <form class="form-inline">
                        <input type="hidden" name="mod" value="district" />
                        <input type="hidden" name="act" value="list" />
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city_id">Tỉnh/Thành</label>
                            <select class="form-control" data-table="district" data-type="list" data-child="district_id" name="city_id" id="city_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($cityArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['city_id']) && $_GET['city_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                          </div>
                    </div>
                    
                    <div class="col-md-6">
                        
                    </div>
                      
                      
                      
                    </form>
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th style="width: 10px">No.</th>
                        <th>Quận / Huyện</th>
                        <th>Tỉnh / Thành</th>
                        <th>Ngày tạo</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                    <?php
                    $i = ($page-1) * LIMIT;;
                    if(!empty($list['data'])){
                    foreach ($list['data'] as $key => $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $model->getNameById('city', $row['city_id']); ?></td>
                        <td><?php echo date('d-m-Y',$row['created_at']); ?></td>
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=district&act=form&id=<?php echo $row['id']; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="district" class="link_delete" >
                                <i class="fa fa-fw fa-trash-o"></i>
                            </a>

                        </td>
                    </tr>
                    <?php }}  ?>
                </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <!--
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">«</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">»</a></li>
                </ul>-->
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->

</div>