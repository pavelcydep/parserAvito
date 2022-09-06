<?php
require_once __DIR__ . '../../PHPExcel-1.8/Classes/PHPExcel.php';
require_once __DIR__ . '../../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once 'phpQuery//phpQuery.php';
 

$link = mysqli_connect($host, $user, $pass, $name);
$xls = new PHPExcel();
$objWriter = new PHPExcel_Writer_Excel5($xls);

$xls->getProperties()->setTitle("Название");
$xls->getProperties()->setSubject("Тема");
$xls->getProperties()->setCreator("Автор");
$xls->getProperties()->setManager("Руководитель");
$xls->getProperties()->setCompany("Организация");
$xls->getProperties()->setCategory("Группа");
$xls->getProperties()->setKeywords("Ключевые слова");
$xls->getProperties()->setDescription("Примечания");
$xls->getProperties()->setLastModifiedBy("Автор изменений");
$xls->getProperties()->setCreated("25.03.2019");
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
$sheet->setTitle('Название листа');
$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 

$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
 
// Поля
$sheet->getPageMargins()->setTop(1);
$sheet->getPageMargins()->setRight(0.75);
$sheet->getPageMargins()->setLeft(0.75);
$sheet->getPageMargins()->setBottom(1);
 

$sheet->getHeaderFooter()->setOddHeader("Название листа");



$sheet->getHeaderFooter()->setOddFooter('&L&B Название листа &R Страница &P из &N');
$sheet->setCellValueExplicit("A1", '1.', PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicit("B2", '1.', PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicit("B3", '1.', PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValueExplicit("B4", '1.', PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->getColumnDimension("A")->setWidth(20);
$sheet->getColumnDimension("B")->setWidth(20);
$sheet->getColumnDimension("C")->setWidth(20);
$sheet->getColumnDimension("D")->setWidth(80);
$sheet->getRowDimension("2")->setRowHeight(50);


$sheet->setCellValue("A1", "Дата");
$sheet->setCellValue("B1", "Просмотры");
$sheet->setCellValue("C1", "Пользователь");
$sheet->setCellValue("D1", "Ссылка");
$host = 'localhost'; 
$user = 'root';      
$pass = 'root';          
$name = 'avito';    

$link = mysqli_connect($host, $user, $pass, $name);

$patchDataTable=date("jmYh_I_s_A");



//for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
$data = array(); // create an array
$query = "SELECT * FROM avitotable WHERE  dates LIKE 'сегодня%' or dates LIKE 'вчера%'";
$result=mysqli_query($link, $query) or die(mysqli_error($link));
while($row = mysqli_fetch_assoc($result)){ 
  $data[] = $row; }
print_r($data);
     foreach($data as $item)
       {
         
            $ind=$item['id']+1;
            $sheet->setCellValue("A$ind", "$item[dates]");
            $sheet->setCellValue("B$ind", "$item[view]");
            $sheet->setCellValue("C$ind", "$item[user]");
            $sheet->setCellValue("D$ind", "$item[link]");
           
            $objWriter->save(__DIR__ . "/filesExcel/file_$patchDataTable.xlsx");
            
        
        } 



?>