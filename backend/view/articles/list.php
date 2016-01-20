<?php
   require_once "model/Backend.php";
   $model = new Backend;
   $link = "index.php?mod=articles&act=list";
   
   if(isset($_GET['keyword'])){
       $keyword = $model->processData($_GET['keyword']);
       $link.='&keyword='.$keyword;
   }else{
       $keyword='';
   }
    if(isset($_GET['category_id'])){
       $category_id = $model->processData($_GET['category_id']);
       $link.='&category_id='.$category_id;
   }else{
       $category_id=-1;
   }
   $limit = 20;
   $arrTotal = $model->getListArticle($keyword,$category_id,-1, -1);
   $total_page = ceil($arrTotal['total'] / $limit);
   $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;  
   
   $offset = $limit * ($page - 1);   
   
   $arrList = $model->getListArticle($keyword,$category_id,$offset, $limit);
   
   ?>
<div class="row">
   <div class="col-md-12">
      <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=articles&act=form'">Tạo mới</button>        
      <div class="box-header">
         <h3 class="box-title">Danh sách bài viết</h3>
      </div>
      <!-- /.box-header -->
      <div class="box">
         <div class="box_search">
            <form method="get" id="form_search" name="form_search">
               <input type="hidden" name="mod" value="articles" />
               <input type="hidden" name="act" value="list" />
               <select name="category_id" id="category_id" style="height:30px;width:150px">
                   <option value="-1">Danh mục</option>
                   <option value="1" <?php echo (isset($_GET['category_id']) && $_GET['category_id']==1)  ? "selected" : ""; ?>>Tin tức</option>
                   <option value="2" <?php echo (isset($_GET['category_id']) && $_GET['category_id']==2)  ? "selected" : ""; ?>>Tin dự án</option>
               </select>
               Tiêu đề &nbsp;<input type="text" class="text_search" name="keyword" value="<?php echo (trim($keyword)!='') ? $keyword: ""; ?>" /> 
               &nbsp;&nbsp;&nbsp;
               <button class="btn btn-primary btn-sm right" type="submit">Tìm kiếm</button>
            </form>
         </div>
         <div class="box-body">
            <table class="table table-bordered table-striped">
               <tbody>
                  <tr>
                     <th style="width: 10px">No.</th>
                     <th width="300">Tiêu đề</th>
                     <th width="140">Ảnh đại diện</th>
                     <th>Mô tả ngắn</th>
                     <th width="140">Ngày tạo</th>
                     <th style="width: 40px">Action</th>
                  </tr>
                  <?php
                     $i = ($page-1) * $limit;                      
                     if(!empty($arrList['data'])){                         
                     foreach($arrList['data'] as $row){
                     
                     $i++;        
                     ?>
                  <tr>
                     <td><?php echo $i; ?></td>
                     <td>
                        <a href="index.php?mod=articles&act=form&id=<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?> 
                        </a>
                     </td>
                     <td>
                        <?php $url_image = ($row['image_url']) ? "../".$row['image_url'] : STATIC_URL."img/noimage.gif"; ?>
                        <img src="<?php echo $url_image; ?>" width="120" />
                     </td>
                     <td style="vertical-align:top"><?php echo $row['description']; ?></td>
                     <td><?php echo date('d-m-Y',$row['created_at']); ?></td>
                     <td style="white-space:nowrap">                            
                        <a href="index.php?mod=articles&act=form&id=<?php echo $row['id']; ?>">
                        <i class="fa fa-fw fa-edit"></i>
                        </a>
                        <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="articles" class="link_delete" >    
                        <i class="fa fa-fw fa-trash-o"></i>
                        </a>    
                     </td>
                  </tr>
                  <?php } }else{ ?>              
                  <tr>
                     <td colspan="8" class="error_data">Không tìm thấy dữ liệu!</td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
         <!-- /.box-body -->
         <div class="box-footer clearfix">
         
            <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
         </div>
      </div>
      <!-- /.box -->                           
   </div>
   <!-- /.col -->
</div>
<script type="text/javascript">
   $(function(){
   
       $('#cate_id').change(function(){
   
           $('#form_search').submit();
   
       });
   
   });
   
</script>
