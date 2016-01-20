<?php 
$price_1 = (int) $_POST['price_1'];
$price_3 = (int) $_POST['price_3'];
$price_6 = (int) $_POST['price_6'];
$no_month = (int) $_POST['no_month'];

if($no_month < 3){
    $price = $price_1;
    $month = 1;
}elseif ($no_month < 6 && $no_month > 2) {

    $price = $price_3 > 0 ? $price_3 : $price_1;
    $month = 3;
}else {
    $price = $price_6 > 0 ? $price_6 : $price_1;
    $month = 6;
}
echo number_format($price);
?>