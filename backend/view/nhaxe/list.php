<?php
require_once "model/Nhaxe.php";
$model = new Nhaxe;
$link = "index.php?mod=nhaxe&act=list";

if (isset($_GET['hot']) && $_GET['hot'] > -1) {
    $hot = (int) $_GET['hot'];      
    $link.="&hot=$hot";
} else {
    $hot = -1;
}
if(isset($_GET['keyword'])){
    $keyword = $model->processData($_GET['keyword']);
    $link.='&keyword='.$keyword;
}else{
    $keyword='';
}
$limit = 100;
$arrTotal = $model->getListNhaxe($keyword,$hot, -1, -1);

$total_page = ceil($arrTotal['total'] / $limit);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = $limit * ($page - 1);

$arrList = $model->getListNhaxe($keyword,$hot,$offset, $limit);
?>

<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=nhaxe&act=form'">Tạo mới</button>        
    <button class="btn btn-primary btn-sm right" id="capnhat_thutu">Cập nhật thứ tự</button> 
         <div class="box-header">
                <h3 class="box-title">Danh sách nhà xe</h3>
            </div><!-- /.box-header -->
        <div class="box">
            <div class="box_search">
                
                <form method="get" id="form_search" name="form_search">
                    <input type="hidden" name="mod" value="nhaxe" />
                    <input type="hidden" name="act" value="list" />
                    Tên nhà xe &nbsp;<input type="text" class="text_search" name="keyword" value="<?php echo (trim($keyword)!='') ? $keyword: ""; ?>" /> 
                    &nbsp;&nbsp;&nbsp;Loại 
                    <select name="hot" class="event_change select_search">
                        <option value="-1">Tất cả</option>  
                        <option value="0" <?php echo ($hot==0) ? "selected" : ""; ?>>Bình thường</option>   
                        <option value="1" <?php echo ($hot==1) ? "selected" : ""; ?>>Uy tín</option>        
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-sm right" type="submit">Tìm kiếm</button>
                </form>
            </div>
            <div class="box-body">
                <input type="hidden" id="str_order" value="">
                <table class="table table-bordered table-striped" id="drag">
                    <tbody><tr>
                        <th style="width: 10px">No.</th>
                        <th>Tên <img src="<?php echo STATIC_URL?>img/vi.png"/></th>
                        <th>Tên <img src="<?php echo STATIC_URL?>img/uk_.png"/></th>
                        <th>Địa chỉ</th>
                        <th>Ngày tạo</th>
                        <th width="1%" style="white-space:nowrap">Chi nhánh</th>
                        <th width="1%" style="white-space:nowrap">Hình ảnh</th>                        
                        <th style="width: 40px">Action</th>
                    </tr>
                    <?php
                    $i = ($page-1) * $limit; 
                    if(!empty($arrList['data'])){                   
                    foreach($arrList['data'] as $row){
                    $i++;
                    ?>
                    <tr id="rows_<?php echo $row['nhaxe_id']; ?>">
                        <td><?php echo $i; ?></td>
                        <td>
                            <a href="index.php?mod=nhaxe&act=form&nhaxe_id=<?php echo $row['nhaxe_id']; ?>">
                                <?php echo $row['nhaxe_name_vi']; ?> 
                            </a>
                            <?php if($row['hot']==1) { ?>
                            &nbsp;&nbsp;&nbsp;<img src="static/img/ok.gif" width="20" alt="Nhà xe uy tín" title="Nhà xe uy tín"/>
                            <?php } ?>
                        </td>
                        <td><?php echo $row['nhaxe_name_en']; ?></td>
                        <td><?php echo $row['address_vi']; ?></td>
                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>   
                        <td align="center">
                            <a href="index.php?mod=branch&act=list&nhaxe_id=<?php echo $row['nhaxe_id']; ?>">
                                <img width="22" src="static/img/branch.jpg" alt="Quản lý chi nhánh" title="quản lý chi nhánh"/> 
                            </a>
                        </td>
                        <td align="center">
                            <a href="index.php?mod=image&act=list&nhaxe_id=<?php echo $row['nhaxe_id']; ?>">
                                <img src="static/img/gallery.jpg" alt="Quản lý hình ảnh" title="quản lý hình ảnh"/> 
                            </a>
                        </td>                     
                        <td style="white-space:nowrap">                            
                            <a href="index.php?mod=nhaxe&act=form&nhaxe_id=<?php echo $row['nhaxe_id']; ?>" class="btn btn-sm btn-warning">
                                Chỉnh sửa
                            </a>
                            <a href="javascript:;" alias="<?php echo $row['nhaxe_name_vi']; ?>" id="<?php echo $row['nhaxe_id']; ?>" mod="nhaxe" class="btn btn-sm btn-danger link_delete" >    
                                Xóa
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
<script type="text/javascript" src="static/js/drag.js"></script>
<script type="text/javascript">
    $(function(){
        $("table#drag").tableDnD({        
            onDrop: function(table, row) {
                var rows = table.tBodies[0].rows;
                var strOrder = '';
                var strTemp = '';
                for (var i=0; i<rows.length; i++) {
                    strTemp = rows[i].id;
                    strOrder += strTemp.replace('rows_','') + ";";
                }                
                $('#str_order').val(strOrder);
            },
            onDragClass: "myDragClass"
        });       
        $('#capnhat_thutu').click(function(){
              $.ajax({
                  url: "controller/Nhaxe.php",
                  type: "POST",
                  async: false,
                  data: {"str_order":$('#str_order').val(),'act':'order'},
                  success: function(data){      
                      alert('Cập nhật thành công');
                      window.location.reload();
                  }
              });           
          });
    });       
</script>