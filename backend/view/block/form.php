<?php
if(isset($_GET['block_id'])){
    $block_id = (int) $_GET['block_id'];
    require_once "model/Block.php";
    $model = new Block;
    $detail = $model->getDetailBlock($block_id);
    $arrLink = $model->getListLinkByBlock($block_id);
}
?>

<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=block&act=list'">Danh sách</button>
        <form method="post" action="controller/Block.php">
        <!-- Custom Tabs -->

        <div style="clear:both;margin-bottom:10px"></div>
         <div class="box box-primary">
         <div class="box-header">
                <h3 class="box-title"></h3>
                <?php if($block_id > 0){ ?>
                <input type="hidden" value="<?php echo $block_id; ?>" name="block_id" />
                <?php } ?>

            </div><!-- /.box-header -->
            <div class="box-body">
                    <div class="form-group">

                        <label>Tên Block <span class="required"> ( * ) </span></label>

                        <input class="form_control" name="block_name" value="<?php echo $detail['block_name']; ?>" id="block_name" style="width:250px" />

                    </div>

                    <div class="form-group">
                     <fieldset>
                        <legend>Link:</legend>
                        <div class="form-group">

                            <label>Text</label>

                            <input class="form_control" name="text[1]" value="<?php echo $arrLink[0]['text_link']; ?>" id="text_1"  style="width:250px" />

                            <label>&nbsp;&nbsp;&nbsp;Link</label>

                            <input class="form_control" name="link[1]" value="<?php echo $arrLink[0]['link_url']; ?>" id="link_1" style="width:500px"/>
                        </div>
                        <div class="form-group">

                            <label>Text</label>

                            <input class="form_control" name="text[2]" value="<?php echo $arrLink[1]['text_link']; ?>" id="text_2"  style="width:250px" />

                            <label>&nbsp;&nbsp;&nbsp;Link</label>

                            <input class="form_control" name="link[2]" value="<?php echo $arrLink[1]['link_url']; ?>" id="link_2" style="width:500px"/>
                        </div>
                        <div class="form-group">

                            <label>Text</label>

                            <input class="form_control" name="text[3]" value="<?php echo $arrLink[2]['text_link']; ?>" id="text_3"  style="width:250px" />

                            <label>&nbsp;&nbsp;&nbsp;Link</label>

                            <input class="form_control" name="link[3]" value="<?php echo $arrLink[2]['link_url']; ?>" id="link_3" style="width:500px"/>
                        </div>
                        <div class="form-group">

                            <label>Text</label>

                            <input class="form_control" name="text[4]" value="<?php echo $arrLink[3]['text_link']; ?>" id="text_4"  style="width:250px" />

                            <label>&nbsp;&nbsp;&nbsp;Link</label>

                            <input class="form_control" name="link[4]" value="<?php echo $arrLink[3]['link_url']; ?>" id="link_4" style="width:500px"/>
                        </div>
                        <div class="form-group">

                            <label>Text</label>

                            <input class="form_control" name="text[5]" value="<?php echo $arrLink[4]['text_link']; ?>" id="text_5"  style="width:250px" />

                            <label>&nbsp;&nbsp;&nbsp;Link</label>

                            <input class="form_control" name="link[5]" value="<?php echo $arrLink[4]['link_url']; ?>" id="link_5" style="width:500px"/>
                        </div>
                        <div class="form-group">

                            <label>Text</label>

                            <input class="form_control" name="text[6]" value="<?php echo $arrLink[5]['text_link']; ?>" id="text_6"  style="width:250px" />

                            <label>&nbsp;&nbsp;&nbsp;Link</label>

                            <input class="form_control" name="link[6]" value="<?php echo $arrLink[5]['link_url']; ?>" id="link_6" style="width:500px"/>
                        </div>

                    </fieldset>
                    </div>

               </div>
            <div class="button">
                <button class="btn btn-primary btnSave" type="submit">Save</button>
                <button class="btn btn-primary" type="reset">Cancel</button>
            </div>
              </div><!-- nav-tabs-custom -->
        </div>
    </form>
    </div><!-- /.col -->
</div>