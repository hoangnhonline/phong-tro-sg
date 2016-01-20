<?php

require_once "model/Place.php";

$model = new Place;

$link = "index.php?mod=place&act=list";

require_once "model/Tinh.php";

$modelTinh = new Tinh;

if (isset($_GET['nhaxe_id']) && $_GET['nhaxe_id'] > 0) {

    $nhaxe_id = (int) $_GET['nhaxe_id'];      

    $link.="&nhaxe_id=$nhaxe_id";

} else {

    $nhaxe_id = -1;

}


if (isset($_GET['keyword']) && trim($_GET['keyword']) != '') {

    $keyword = $_GET['keyword'];      

    $link.="&keyword=$keyword";

} else {

    $keyword = '';

}

$arrTotal = $model->getListPlace($nhaxe_id,$keyword, -1, -1);



$total_page = ceil($arrTotal['total'] / LIMIT);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = LIMIT * ($page - 1);



$arrList = $model->getListPlace($nhaxe_id,$keyword,$offset, LIMIT);

// list nha xe
require_once "model/Nhaxe.php";

$modelNhaxe = new Nhaxe;

$arrListNhaxe = $modelNhaxe->getListNhaxe('',-1, -1, -1);

?>

<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=place&act=form'">Tạo mới</button>        

         <div class="box-header">

                <h3 class="box-title">Danh sách điểm xp/điểm đến</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">                 

                    Nhà xe 

                    <select class="select_search" name="nhaxe_id" id="nhaxe_id">

                        <option value="0">---Tất cả---</option>

                        <?php if(!empty($arrListNhaxe['data'])){

                            foreach ($arrListNhaxe['data'] as $value) {

                                ?>

                                <option <?php echo $_GET['nhaxe_id'] == $value['nhaxe_id'] ? "selected" : ""; ?> value="<?php echo $value['nhaxe_id']; ?>"><?php echo $value['nhaxe_name_vi']; ?></option> 

                                <?php 

                            }}

                            ?>                                          

                    </select>                   

                    &nbsp;&nbsp;&nbsp;

                   Tên  &nbsp;

                   <input type="text" class="text_search" id="keyword" name="keyword" value="<?php echo (trim($keyword)!='') ? $keyword: ""; ?>" /> 

                    &nbsp;&nbsp;&nbsp;

                    <button class="btn btn-primary btn-sm right" id="btnSearch" type="button">Tìm kiếm</button>

                

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>

                        <th style="width:150px;white-space:nowrap">Nhà xe</th>

                        <th>Tên <img src="<?php echo STATIC_URL?>img/vi.png"/></th>

                        <th>Tên <img src="<?php echo STATIC_URL?>img/uk_.png"/></th>

                        <th>Địa chỉ</th>

                        <th>Ngày tạo</th>                        

                        <th style="width: 40px">Action</th>

                    </tr>

                    <?php
                    if(!empty($arrList['data'])){
                    $i = ($page-1) * LIMIT;                    

                    foreach($arrList['data'] as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td><?php echo $modelNhaxe->getNhaxeNameByID($row['nhaxe_id']); ?></td>

                        <td>

                            <a href="index.php?mod=place&act=form&place_id=<?php echo $row['place_id']; ?>">

                                <?php echo $row['place_name_vi']; ?>

                            </a>

                        </td>

                        <td><?php echo $row['place_name_en']; ?></td>

                        <td><?php echo $row['address_vi']; ?></td>

                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>                        

                        <td style="white-space:nowrap">

                            <a href="index.php?mod=place&act=form&place_id=<?php echo $row['place_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['place_name_vi']; ?>" id="<?php echo $row['place_id']; ?>" mod="place" class="link_delete" >    

                                <i class="fa fa-fw fa-trash-o"></i>

                            </a>    

                            

                        </td>

                    </tr>      

                    <?php } }else{ ?>              

                    <tr>

                        <td colspan="7" class="error_data">Không tìm thấy dữ liệu!</td>

                    </tr>

                    <?php } ?>  
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

<script type="text/javascript">

$(function(){
    

    $('#nhaxe_id').change(function(){

        search();

    });

    $('#btnSearch').click(function(){

        search();

    });

    $('#keyword').keypress(function (e) {

      if (e.which == 13) {

        search();

      }

    });

});   

function search(){

    var str_link = "index.php?mod=place&act=list";

    var tmp = $('#nhaxe_id').val();

    if(tmp > 0){

        str_link += "&nhaxe_id=" + tmp ;

    }
   
    tmp = $.trim($('#keyword').val());

    if(tmp != ''){

        str_link += "&keyword=" + tmp ;   

    }    

    location.href= str_link;

}       



</script>