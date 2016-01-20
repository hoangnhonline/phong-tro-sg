<?php
require_once "model/Backend.php";

$model = new Backend;

$link = "index.php?mod=seo&act=list";

$list = $model->getList('seo', -1, -1);

?>


<div class="row">

    <div class="col-md-12">  
 
    
         <div class="box-header">

                <h3 class="box-title">SEO List</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">             

                

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped" id="tbl_list">

                    <tbody><tr>

                        <th style="width: 1%">No. </th>
                        <th width="10%">Page name</th>                        
                        <th width="20%">Title</th>                        
                        <th width="20%">Description</th>                        
                        <th width="20%">Keyword</th>                        
                        <th width="1%">Action</th>

                    </tr>

                    <?php
                    $i = 0;                    
                    if(!empty($list['data'])){
                    foreach ($list['data'] as $key => $row) {
                    $i++;
                    ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>

                        <td>
                            <a href="index.php?mod=seo&act=form&id=<?php echo $row['id']; ?>">

                                <?php echo $row['page_name']; ?> 

                            </a>
                        </td>  
                        <td width="20%"><?php echo $row['meta_title']; ?></td>                     
                        <td width="20%"><?php echo $row['meta_description']; ?></td>                     
                        <td width="20%"><?php echo $row['meta_keyword']; ?></td>                     
                        <td style="white-space:nowrap">                            
                        
                            <a href="index.php?mod=seo&act=form&id=<?php echo $row['id']; ?>" title="Click để chỉnh sửa">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>
                        
                            <a title="Click để xóa" href="javascript:;" alias="<?php echo $row['page_name']; ?>" id="<?php echo $row['id']; ?>" mod="seo" class="link_delete" >    

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
              
            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>