<?php 
$price_1 = (int) $_POST['price_1'];
$price_3 = (int) $_POST['price_3'];
$price_6 = (int) $_POST['price_6'];
$no_month = (int) $_POST['no_month'];
$no_person = (int) $_POST['no_person'];
$deposit = (int) $_POST['deposit'];
$the_chan = (int) $_POST['the_chan'];

if($no_month < 3){
    $price = $price_1;
    $month = 1;
}elseif ($no_month < 6 && $no_month > 2) {
    $price = $price_3;
    $month = 3;
}else {
    $price = $price_6;
    $month = 6;
}

$total_first = $the_chan + $price;
$total_remain = $total_first - $deposit;
?>
<p style="font-weight:bold;color:red">Hợp đồng này đang áp dụng giá thuê : <?php echo $month ?> tháng</p>
<table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th style="text-align:left">Nội dung</th>
        <th style="text-align:right">Số tiền</th>        
      </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:left">Tiền thế chân</td>
            <td style="text-align:right"><?php echo number_format($the_chan); ?></td>        
        </tr>
        <tr>
            <td style="text-align:left">Tiền thuê 1 tháng</td>
            <td style="text-align:right"><?php echo number_format($price); ?></td>        
        </tr>
        <tr>
            <td style="text-align:left">Tổng tiền thu lần đầu</td>
            <td style="text-align:right"><?php echo number_format($total_first); ?></td>        
        </tr>
        <tr>
            <td style="text-align:left"><i>Đặt cọc trước</i></td>
            <td style="text-align:right"><?php echo number_format($deposit); ?></td>        
        </tr>
        <tr>
            <td style="text-align:left"><strong>Tổng tiền thu lần đầu còn lại</strong></td>
            <td style="text-align:right"><?php echo number_format($total_remain); ?></td>        
        </tr>        
    </tbody>
</table>