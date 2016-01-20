<section class="news-highlight-home-block row" style="border:1px solid #C1F1D6;padding:0px; margin-bottom: 20px;margin-top:30px">
    <h3 class="tit-block" style="background: linear-gradient(#982A2A, #651616, #480E0E);color: #FBFDFC;">Tìm kiếm</h3>
    <div class="col-md-12">       

      <div class="form-group">
       
        <select class="form-control selectpicker show-tick" data-live-search="true" id="type" name="type">
          <option value='0'>-- Loại hình --</option>
          <option value='2'>BĐS bán</option>
          <option value='1'>BĐS cho thuê</option>
        </select>
      </div>
      <div class="form-group">
       
        <select class="form-control selectpicker show-tick" data-live-search="true" name="type_id" id="type_id">
          <option data-alias="" value='0'>-- Loại nhà đất --</option>
        </select>
      </div>
      <div class="form-group">         
        <select class="form-control selectpicker" name="city_id" id="city_id" data-live-search="true">
          <option data-alias="" value='0'>-- Chọn Tỉnh/TP --</option>
          <?php foreach ($cityArr['data'] as $key => $value) {
            ?>
            <option data-alias="<?php echo $value['alias']; ?>" value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
            <?php
          }?>
        </select>
      </div>
      <div class="form-group">         
        <select class="form-control selectpicker show-tick" name="district_id" id="district_id" data-live-search="true">
          <option data-alias="" value='0'>-- Chọn Quận/Huyện --</option>
        </select>
      </div>
      <div class="form-group">         
        <select class="form-control selectpicker show-tick" name="price_id" id="price_id" data-live-search="true">
          <option data-alias="" value='0'>-- Chọn khoảng giá --</option>
        </select>
      </div>
      <button type="button" class="btn btn-primary" id="btnSearch" style="float:right"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> &nbsp;Tìm kiếm</button>
      <div class="clearfix" style="margin-bottom:10px"></div>
   
  </div>
</section><!-- End /.slideshow -->