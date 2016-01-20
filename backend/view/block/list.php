<?php
require_once "model/Block.php";

$model = new Block;

$link = "index.php?mod=block&act=list";

$limit = 20;

$arrList = $model->getListBlock();

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=block&act=form'">Tạo mới</button>

         <div class="box-header">

                <h3 class="box-title">Danh sách block</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">



            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width:1%">No.</th>

                        <th width="300">Block Name</th>

                        <th style="width: 1%">Action</th>

                    </tr>

                    <?php
                    $i = 0;
                    if(!empty($arrList)){

                    foreach($arrList as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td>

                            <a href="index.php?mod=block&act=form&block_id=<?php echo $row['block_id']; ?>">

                                <?php echo $row['block_name']; ?>

                            </a>



                        </td>


                        <td style="white-space:nowrap">

                            <a href="index.php?mod=block&act=form&block_id=<?php echo $row['block_id']; ?>">

                                Chỉnh sửa

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['block_name']; ?>" id="<?php echo $row['block_id']; ?>" mod="block" class="btn btn-sm btn-danger link_delete" >

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

            </div>

        </div><!-- /.box -->

    </div><!-- /.col -->



</div>