<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=user&act=list";
$table = "users";
$listTotal = $model->getList($table, -1, -1);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT);

?>
<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=user&act=form'">Tạo mới</button>        

         <div class="box-header">

                <h3 class="box-title">Danh sách mod</h3>

            </div><!-- /.box-header -->

        <div class="box">

           

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>
                        <th>Hình ảnh</th>
                        <th>Tên</th>

                        <th>Email</th>
                        <th>Số nhà cho thuê</th>

                        <th>Số phòng cho thuê</th>

                        <th style="width: 40px">Action</th>

                    </tr>
                     <?php
                    $i = ($page-1) * LIMIT;
                    if(!empty($list['data'])){
                    foreach ($list['data'] as $key => $row) {
                         if($row['level'] > 1){
                            $user_id = $row['id'];
                            $arrAsset = $model->getChild('district', 'user_id', $user_id);                       
                            $string_district_id = "";
                            $arrDistrictAsset = array();
                            if(!empty($arrAsset)){
                                foreach ($arrAsset as $value) {
                                    $string_district_id.=$value['id'].",";
                                }
                                $string_district_id = rtrim($string_district_id, ",");                            
                                $arrDistrictAsset = $model->getListByStringId('district', $string_district_id);                                
                            }
                    $i++;
                    ?>
                  
                    <tr>

                        <td><?php echo $i; ?></td>
                        <td>
                            <img class="img-thumbnail" src="../<?php echo $row['image_url']; ?>" width="130"/>
                        </td>
                        <td><?php echo $row['name']; ?></td>

                        <td><?php echo $row['email']; ?></td>
                        
                        <td>
                        <?php
                        if($string_district_id != '') echo $model->countRentByStringDistrictId('objects', $string_district_id, 2);
                        ?></td>       
                        <td> <?php 
                         if($string_district_id != '') echo $model->countRentByStringDistrictId('objects', $string_district_id, 1);
                        ?></td>                      
                        <td style="white-space:nowrap">

                            <a href="index.php?mod=user&act=form&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">

                                Chỉnh sửa

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="users" class="btn btn-sm btn-danger link_delete" >    

                                Xóa

                            </a>    

                            

                        </td>

                    </tr>      

                    <?php }}} ?>              

                </tbody></table>

            </div><!-- /.box-body -->

            <div class="box-footer clearfix">

             

                <?php if(!empty($list['data'])){ echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); } ?>

            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>