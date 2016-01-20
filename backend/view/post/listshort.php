<?php

require_once "model/Ticket.php";

$model = new Ticket;

require_once "model/Tinh.php";

$modelTinh = new Tinh;

require_once "model/Place.php";

$modelPlace = new Place;

require_once "model/Nhaxe.php";

$modelNhaxe = new Nhaxe;

require_once "model/Car.php";

$modelCar = new Car;

$link = "index.php?mod=ticket&act=listshort";
$page_show = 20;


/* get ds nha xe */



$arrNhaxe = $modelNhaxe->getListNhaxe('',-1, -1, -1);

/* end get ds nha xe */



/* get ds noi di */

$arrListTinhKey = array();

$arrListTinh = $modelTinh->getListTinh(-1,'',-1, -1, -1);

if(!empty($arrListTinh)){

    foreach ($arrListTinh['data'] as $value) {

        $arrListTinhKey[$value['tinh_id']] = $value;

    }

}

/* end get ds place */



/* get ds place */

$arrListPlaceKey = array();

$arrListPlace = $modelPlace->getListPlace(-1,'', -1, -1);

if(!empty($arrListPlace)){

    foreach ($arrListPlace['data'] as $value) {

        $arrListPlaceKey[$value['place_id']] = $value;

    }

}

/* end get ds place */



if (isset($_GET['nhaxe_id']) && $_GET['nhaxe_id'] > 0) {

    $nhaxe_id = (int) $_GET['nhaxe_id'];      

    $link.="&nhaxe_id=$nhaxe_id";

} else {

    $nhaxe_id = -1;

}



if (isset($_GET['ngaydi']) && trim($_GET['ngaydi']) != '') {

    $ngaydi = strtotime($_GET['ngaydi']);      

    $link.="&ngaydi=".$_GET['ngaydi'];

} else {

    $ngaydi = -1;

}



if (isset($_GET['tinh_id_start']) && $_GET['tinh_id_start'] > 0) {

    $tinh_id_start = (int) $_GET['tinh_id_start'];      

    $link.="&tinh_id_start=$tinh_id_start";

} else {

    $tinh_id_start = -1;

}

if (isset($_GET['tinh_id_end']) && $_GET['tinh_id_end'] > 0) {

    $tinh_id_end = (int) $_GET['tinh_id_end'];      

    $link.="&tinh_id_end=$tinh_id_end";

} else {

    $tinh_id_end = -1;

}



$arrTotal = $model->getListTicket($nhaxe_id,$tinh_id_start,$tinh_id_end,$ngaydi, -1, -1,2);



$total_page = ceil($arrTotal['total'] / LIMIT);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = LIMIT * ($page - 1);



$arrList = $model->getListTicket($nhaxe_id,$tinh_id_start,$tinh_id_end,$ngaydi,$offset, LIMIT,2);



?>

<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />

<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=ticket&act=form'">Tạo mới</button>        
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=ticket&act=list'">Danh sách vé chi tiết</button>        
         <div class="box-header">

                <h3 class="box-title">Danh sách vé rút gọn</h3>

            </div><!-- /.box-header -->

        <div class="box">

           <div class="box_search">                 

                    Nhà xe 

                    <select name="nhaxe_id" class="select_search" id="nhaxe_id">

                        <option value="0">Tất cả</option>

                        <?php

                        foreach ($arrNhaxe['data'] as $value) {

                            ?>

                            <option value='<?php echo $value['nhaxe_id']; ?>'

                                <?php if(isset($_GET['nhaxe_id']) && $_GET['nhaxe_id'] == $value['nhaxe_id']) echo "selected";?>

                                ><?php echo $value['nhaxe_name_vi']; ?></option>     

                        <?php

                        } 

                        ?>    

                    </select>

                    &nbsp;&nbsp;&nbsp;

                   Ngày đi &nbsp;

                   <input type="text" class="text_search" id="ngaydi" name="ngaydi" value="<?php echo (trim($_GET['ngaydi'])!='') ? $_GET['ngaydi']: ""; ?>" /> 

                    &nbsp;&nbsp;&nbsp;Nơi đi

                    <input type="hidden" name="tinh_id_start" id="tinh_id_start" value="<?php echo (isset($_GET['tinh_id_start'])) ? $_GET['tinh_id_start'] : "" ;?>" />

                    <input type="text" name="diem_xp" id="diem_xp" 

                    value="<?php echo isset($_GET['tinh_id_start']) ? $arrListTinhKey[$_GET['tinh_id_start']]['tinh_name_vi'] : ""; ?>"  />

                    &nbsp;&nbsp;&nbsp;

                    &nbsp;&nbsp;&nbsp;Nơi đến

                    <input type="hidden" name="tinh_id_end" id="tinh_id_end" value="<?php echo (isset($_GET['tinh_id_end'])) ? $_GET['tinh_id_end'] : "" ;?>" />

                    <input type="text" name="diem_den" id="diem_den" 

                    value="<?php echo isset($_GET['tinh_id_end']) ? $arrListTinhKey[$_GET['tinh_id_end']]['tinh_name_vi'] : ""; ?>" />

                    &nbsp;&nbsp;&nbsp;

                    <button class="btn btn-primary btn-sm right" id="btnSearch" type="button">Tìm kiếm</button>

                

            </div>

            <div class="box-body">



                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>

                        <th>Nhà xe</th>

                        <th width="200">Nơi đi</th>

                        <th width="200">Nơi đến</th>

                        <th>Giá</th>

                        <th>Ngày đi</th>

                        <th>Loại xe</th>

                                               

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

                        <td>

                            <a href="index.php?mod=nhaxe&act=form&nhaxe_id=<?php echo $row['nhaxe_id']; ?>" target="_blank">

                                <?php echo $modelNhaxe->getNhaxeNameByID($row['nhaxe_id']); ?>

                            </a>

                        </td>

                        <td><b><?php echo $modelTinh->getTinhNameByID($row['tinh_id_start']); ?></b>

                                <br />

                            &nbsp;&nbsp;&nbsp;- <?php echo $modelPlace->getPlaceNameByID($row['place_id_start']); ?>    

                        </td>

                        <td><b><?php echo $modelTinh->getTinhNameByID($row['tinh_id_end']); ?></b>

                            <br />

                            &nbsp;&nbsp;&nbsp;- <?php echo $modelPlace->getPlaceNameByID($row['place_id_end']); ?> 

                        </td>

                        <td><?php echo number_format($row['price']); ?></td>

                        <td><?php echo date('d-m-Y',$row['date_start']); ?></td>

                        <td><?php echo $modelCar->getCarNameByID($row['car_type']); ?></td>

                        

                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>                        

                        <td style="white-space:nowrap">

                            <a href="index.php?mod=ticket&act=form&ticket_id=<?php echo $row['ticket_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="tất cả vé tương tự" id="<?php echo $row['key_all']; ?>" mod="ticketshort" class="link_delete" >    

                                <i class="fa fa-fw fa-trash-o"></i>

                            </a>    

                            

                        </td>

                    </tr>      

                    <?php } }else{ ?>              

                    <tr>

                        <td colspan="8" class="error_data">Không tìm thấy dữ liệu!</td>

                    </tr>

                    <?php } ?>             

                </tbody></table>

            </div><!-- /.box-body -->

            <div class="box-footer clearfix">
                <div style="float:left;font-size:19px;font-weight:bold">Total : <?php echo $arrTotal['total']; ?></div>
                <!--

                <ul class="pagination pagination-sm no-margin pull-right">

                    <li><a href="#">«</a></li>

                    <li><a href="#">1</a></li>

                    <li><a href="#">2</a></li>

                    <li><a href="#">3</a></li>

                    <li><a href="#">»</a></li>

                </ul>-->

                <?php echo $model->phantrang($page, $page_show, $total_page, $link); ?>

            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>

 <script>

  $(function() {



    var arrTinh = [

    <?php foreach($arrListTinh['data'] as $tinh){ ?> 

      {

        value: "<?php echo $tinh['tinh_id']; ?>",

        label: "<?php echo $tinh['tinh_name_vi']; ?>"      

      },

      <?php } ?>

      

    ];



    $('#ngaydi').datepicker({

        showOtherMonths: true,

        selectOtherMonths: true,

        dateFormat :'dd-mm-yy'

    });



    $("#diem_xp" ).blur(function(){

        if($.trim($(this).val())==''){

            $('#tinh_id_start').val(0);

        }

    });

    $("#diem_den" ).blur(function(){

        if($.trim($(this).val())==''){

            $('#tinh_id_end').val(0);

        }

    });

    $("#diem_xp" ).autocomplete({

      minLength: 0,

      source: arrTinh,

      focus: function( event, ui ) {

        $( "#diem_xp" ).val( ui.item.label );

        return false;

      },

      select: function( event, ui ) {

        $( "#diem_xp" ).val( ui.item.label );

        $( "#tinh_id_start" ).val( ui.item.value );      

        return false;

      }

    })

    .autocomplete( "instance" )._renderItem = function( ul, item ) {

      return $( "<li>" )

        .append(item.label)

        .appendTo( ul );

    };

    $("#diem_den" ).autocomplete({

      minLength: 0,

      source: arrTinh,

      focus: function( event, ui ) {

        $( "#diem_den" ).val( ui.item.label );

        return false;

      },

      select: function( event, ui ) {

        $( "#diem_den" ).val( ui.item.label );

        $( "#tinh_id_end" ).val( ui.item.value );      

        return false;

      }

    })

    .autocomplete( "instance" )._renderItem = function( ul, item ) {

      return $( "<li>" )

        .append(item.label)

        .appendTo( ul );

    };



  });



    function search(){

        var str_link = "index.php?mod=ticket&act=listshort";

        var tmp = $('#nhaxe_id').val();

        if(tmp > 0){

            str_link += "&nhaxe_id=" + tmp ;

        }

        tmp = $.trim($('#ngaydi').val());

        if(tmp != ''){

            str_link += "&ngaydi=" + tmp ;   

        }

        tmp = $('#tinh_id_start').val();

        if(tmp > 0){

            str_link += "&tinh_id_start=" + tmp ;

        }

        tmp = $('#tinh_id_end').val();

        if(tmp > 0){

            str_link += "&tinh_id_end=" + tmp ;

        }

        location.href= str_link;

    }

    $('#nhaxe_id').change(function(){

        search();

    });

    $('#btnSearch').click(function(){

        search();

    });   

  </script>