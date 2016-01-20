<?php
require_once "model/Question.php";

$model = new Question;

$link = "index.php?mod=question&act=list";

$limit = 20;

$arrList = $model->getListQuestion();

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=question&act=form'">Tạo mới</button>        

         <div class="box-header">

                <h3 class="box-title">Danh sách câu hỏi</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">             

                

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width:1%">No.</th>

                        <th width="300">Câu hỏi</th>                                                                      

                        <th style="width: 1%">Action</th>

                    </tr>

                    <?php                   
                    $i = 0;
                    if(!empty($arrList['data'])){                   

                    foreach($arrList['data'] as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td>

                            <a href="index.php?mod=question&act=form&question_id=<?php echo $row['question_id']; ?>">

                                <?php echo $row['content']; ?> 

                            </a>

                       

                        </td>
                        
                       
                        <td style="white-space:nowrap">                            

                            <a href="index.php?mod=question&act=form&question_id=<?php echo $row['question_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['content']; ?>" id="<?php echo $row['question_id']; ?>" mod="question" class="link_delete" >    

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

                <!--

                <ul class="pagination pagination-sm no-margin pull-right">

                    <li><a href="#">«</a></li>

                    <li><a href="#">1</a></li>

                    <li><a href="#">2</a></li>

                    <li><a href="#">3</a></li>

                    <li><a href="#">»</a></li>

                </ul>-->

                <?php echo $model->phantrang($question, PAGE_SHOW, $total_question, $link); ?>

            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>