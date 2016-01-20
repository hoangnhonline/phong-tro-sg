<?php
$user_id = $_SESSION['user_id'];
require_once "model/Backend.php";
$model = new Backend;


$link = "index.php?mod=room&act=list";

$arrCustom = array('object_type' => 1, 'city_id' => -1, 'district_id' => -1, 'ward_id' => -1, 'house_id' => -1, 'status' => -1, 'name' => '');
if($_SESSION['level']==1){
    $arrCustom['user_id'] = -1;    
}else{
    $arrCustom['user_id'] = $user_id;    
}
foreach ($arrCustom as $key => $value) {
    if ((isset($_GET[$key]) && $_GET[$key] > 0) || ($_GET[$key] != '' && $_GET[$key] != '-1' && $_GET[$key] != '0')) {
        $tmp = $_GET[$key];
        $link.="&".$key."=".$tmp;
        $arrCustom[$key] = $tmp;
    }
}

$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1);
$arrCustomWard = $wardArr = $houseArr = array();

if(isset($_GET['district_id']) && $_GET['district_id'] > 0){
    $arrCustomWard['district_id'] = $_GET['district_id'];
    $wardArr = $model->getList('ward', -1, -1, $arrCustomWard);
}
if(isset($_GET['ward_id']) && $_GET['ward_id'] > 0){
    $arrCustomHouse['ward_id'] = $_GET['ward_id'];
    $houseArr = $model->getList('house', -1, -1, $arrCustomHouse);
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
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=room&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách phòng cho thuê</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <div class="panel panel-default">
                  <div class="panel-heading">Tìm kiếm</div>
                  <div class="panel-body">
                    <form class="form-inline">
                        <input type="hidden" name="mod" value="room" />
                        <input type="hidden" name="act" value="list" />
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city_id">Tỉnh/Thành</label><br/>
                            <select class="form-control select-change " data-live-search="true" data-table="district" data-type="list" data-child="district_id" name="city_id" id="city_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($cityArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['city_id']) && $_GET['city_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="district_id">Quận/Huyện</label><br/>
                            <select class="form-control select-change " data-live-search="true" data-table="ward" data-type="list" data-child="ward_id" name="district_id" id="district_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($districtArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['district_id']) && $_GET['district_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ward_id">Phường/Xã</label><br/>
                            <select class="form-control select-change " data-live-search="true" data-table="house" data-type="list" data-child="house_id" name="ward_id" id="ward_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($wardArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['ward_id']) && $_GET['ward_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="house_id">Nhà</label><br/>
                            <select class="form-control " data-live-search="true" name="house_id" id="house_id">
                                <option value="0">---Tất cả---</option>
                                <?php foreach($houseArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['house_id']) && $_GET['house_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name">Tên phòng</label><br>
                           <input name="name" id="name" class="form-control" value="<?php echo (isset($_GET['name']) && $_GET['name']!= '') ? $_GET['name'] : ""; ?>">
                          </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="house_id">Trạng thái</label><br/>
                            <select class="form-control " data-live-search="true" name="status" id="status">
                                <option value="-1">--Tất cả--</option>
                                <option value="1" <?php if(isset($_GET['status']) && $_GET['status']==1) echo "selected"; ?>>Phòng trống</option>
                                <option value="2" <?php if(isset($_GET['status']) && $_GET['status']==2) echo "selected"; ?>>Đặt cọc</option>                                
                                <option value="3" <?php if(isset($_GET['status']) && $_GET['status']==3) echo "selected"; ?>>Đang ở</option>
                                <option value="4" <?php if(isset($_GET['status']) && $_GET['status']==4) echo "selected"; ?>>Chờ gia hạn</option>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <p><button type="submit" class="btn btn-primary">Tìm kiếm</button></p>
                    </div>                     
                      
                    </form>
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                        
                        <th>Tên phòng</th>
                        <th>Trạng thái</th>
                        <th style="text-align:center">Ngày tạo</th>
                        <th style="text-align:center">Cập nhật lần cuối</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                    <?php
                    $i = ($page-1) * LIMIT;
                    if(!empty($list['data'])){
                    foreach ($list['data'] as $key => $row) {
                        $houseDetail = $model->getDetail('house', $row['house_id']);
                        if($row['status'] > 1){
                            $contract_id = $model->getContractByObjectId($row['id'], 1);
                        }


                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>                       
                        <td>
                            <a href="index.php?mod=room&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                            <br />
                            Nhà :  <?php echo $houseDetail['name']; ?>
                            <br />
                            Địa chỉ : <?php echo $houseDetail['address']; ?>, Phường <?php echo $model->getNameById('ward', $row['ward_id']); ?>, <?php echo $model->getNameById('district', $row['district_id']); ?>, <?php echo $model->getNameById('city', $row['city_id']); ?>
                        </td> 
                        <td>
                            <?php 
                            if($row['status']==1) echo '<h4><span class="label label-lg label-success">Đang trống</span></h4>' ;
                            if($row['status']==2) echo '<h4><span class="label label-warning">Đã cọc</span></h4>' ;
                            if($row['status']==3) echo '<h4><span class="label label-primary">Đang ở</span></h4>' ;
                            if($row['status']==4) echo '<h4><span class="label label-danger">Chờ gia hạn</span></h4>' ;
                            ?>
                        </td>                      
                        <td align="center"><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>
                        <td align="center"><?php echo date('d-m-Y H:i',$row['updated_at']); ?></td>
                        <td style="white-space:nowrap">
                            
                            <?php if($row['status']==1){ ?>
                            <a title="Tạo hợp đồng" href="index.php?mod=contract&act=form&object_type=1&object_id=<?php echo $row['id']; ?>">
                                <i class="glyphicon glyphicon-plus"></i>
                            </a>&nbsp;&nbsp;
                            <?php }else{
                            ?>
                            <a target="_blank" title="Xem hợp đồng" href="index.php?mod=contract&act=edit&id=<?php echo $contract_id; ?>">
                                <i class="glyphicon glyphicon-book"></i>
                            </a>&nbsp;
                            <?php    
                            } 
                            ?>
                            <a href="index.php?mod=room&act=view&id=<?php echo $row['id']; ?>" title="Xem chi tiết">
                                <span class="glyphicon glyphicon-th-list"></span>
                            </a>&nbsp;
                            <a href="index.php?mod=room&act=form&id=<?php echo $row['id']; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <a  href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="room" class="link_delete" >
                                <i class="fa fa-fw fa-trash-o"></i>
                            </a>

                        </td>
                    </tr>
                    <?php } }else{  ?>
                    <tr>
                        <td colspan="6">Không tìm thấy dữ liệu.</td>
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
