<?php
date_default_timezone_set('Asia/Saigon');
require_once "model/Backend.php";
$model = new Backend;

$month = isset($_GET['month']) ? (int) $_GET['month'] : -1;
$year = isset($_GET['year']) ? (int) $_GET['year'] : -1;
$user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : -1;
$arrTotal = $model->getDoanhThuTotalUser($user_id, $month, $year);
require_once 'PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("HoangNH")
                             ->setLastModifiedBy("HoangNH")
                             ->setTitle("Office 2007 XLSX vinawatch.com")
                             ->setSubject("Office 2007 XLSX vinawatch.com")
                             ->setDescription("")
                             ->setKeywords("")
                             ->setCategory("");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tháng')
            ->setCellValue('B1', 'Năm')
            ->setCellValue('C1', 'Doanh thu')
            ->setCellValue('D1', 'Công nợ')
            ->setCellValue('E1', 'Mod');

$i = 1;
if(!empty($arrTotal)){
    foreach ($arrTotal as $value) {
        $i ++;       
        $name = $model->getNameById('users',$value['user_id']);
        
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, str_pad($value['month'], 0, STR_PAD_LEFT))
                ->setCellValue('B'.$i, $value['year'])
                ->setCellValue('C'.$i, ($value['doanhthu']))
                ->setCellValue('D'.$i, ($value['congno']))
                ->setCellValue('E'.$i, $name);
    }
}
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(300);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(300);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(300);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(300);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

// Redirect output to a client’s web browser (Excel5)
$fname = "-".date('Y')."-".date('m')."-".date('d')."-".date('h')."-".date('i');
header('Content-Type: application/xls');
header('Content-Disposition: attachment;filename="report'.$fname.'.xls"');
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>