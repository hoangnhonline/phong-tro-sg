<?php
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $data = $model->getDetail("seo",$id);
}
?>
<div class="row">
    <div class="col-md-12" >
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=seo&act=list'">SEO List</button>
        <form method="post"  action="controller/Seo.php" enctype="multipart/form-data">

        <div class="col-md-10" style="background-color:#FFF">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:10px"></div>

            <div class="box-header">

                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Update SEO info " : "Tạo mới" ?>                      
                    <?php echo (isset($id) && $id> 0) ? " : ".$data['page_name'] : ""; ?></h3>

                <?php if(isset($id) && $id> 0){ ?>

                <input type="hidden" value="<?php echo $id; ?>" name="id" />

                <?php } ?>

            </div><!-- /.box-header -->

            <div class="">

                <div class="button">                    

                    <div class="row">
                            
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label>Page name</label>
                                <input type="text" readonly="readonly" name="page_name" id="page_name" class="form-control" value="<?php if(!empty($data)) echo $data['page_name']; ?>" />
                            </div>                          
                           
                        </div>                   
                        <div style="margin-top:30px" >

                <div class="button">
                    <div class="col-md-12" >
                        <h4 class="box-title">SEO information</h4>
                        <div class="form-group">
                            <label>Title</label>
                            <textarea name="meta_title" id="meta_title" class="form-control" rows="3"><?php if(!empty($data)) echo $data['meta_title']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control" rows="3"><?php if(!empty($data)) echo $data['meta_description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta keyword</label>
                            <textarea name="meta_keyword" id="meta_keyword" class="form-control" rows="3"><?php if(!empty($data)) echo $data['meta_keyword']; ?></textarea>
                        </div>
                        <input type="hidden" name="seo_title" value="">
                        <input type="hidden" name="seo_text" value="">
                        <!--
                        <div class="form-group">
                            <label>SEO Title</label>
                            <input type="text" name="seo_title" id="seo_title" class="form-control" value="<?php if(!empty($data)) echo $data['seo_title']; ?>">
                        </div>
                        <div class="form-group">
                            <label>SEO Text</label>
                            <textarea name="seo_text" id="seo_text" class="form-control" rows="3"><?php if(!empty($data['seo_text'])) echo $data['seo_text']; ?></textarea>
                        </div>
                    -->
                    </div>        
                </div>  
                <div style="clear:both"></div>
            </div><!-- nav-tabs-custom -->
                    </div>               
                </div>
            </div><!-- nav-tabs-custom -->

        </div><!-- /.col -->
       
        <div class="col-md-6">

            <!-- Custom Tabs -->
            <div style="clear:both;margin-bottom:30px"></div>
            <div class="box-header">
                
            </div><!-- /.box-header -->
            
        </div><!-- /.col -->

        <div class="col-md-12 nav-tabs-custom">          

            <div class="button">
                <button class="btn btn-primary btnSave" type="submit" >Save</button>
                <button class="btn btn-primary" type="button" onclick="location.href='index.php?mod=seo&act=list'">Cancel</button>
            </div>

        </div>
        </form>
    </div>
</div>
