<?php
require_once __DIR__ . '../../PHPExcel-1.8/Classes/PHPExcel.php';
require_once __DIR__ . '../../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once 'phpQuery//phpQuery.php';

$host = 'localhost'; 
$user = 'root';      
$pass = 'root';          
$name = 'avito';    

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
$sheet->getColumnDimensionByColumn("A1")->setAutoSize(true);
$sheet->getColumnDimensionByColumn("B1")->setAutoSize(true);
$sheet->getColumnDimensionByColumn("C1")->setAutoSize(true);
$sheet->getColumnDimensionByColumn("D1")->setAutoSize(true);
$sheet->getRowDimension("2")->setRowHeight(50);


$sheet->setCellValue("A1", "Дата");
$sheet->setCellValue("B1", "Просмотры");
$sheet->setCellValue("C1", "Пользователь");
$sheet->setCellValue("D1", "Ссылка");
$query = "SELECT * FROM baseavito";
$dateFile=date('l');
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
for ($i = 2; $i < 10; $i++) 
    {
    foreach($data as $item)
        {

            $sheet->setCellValue("A$i", "$item[dates]");
            $sheet->setCellValue("B$i", "$item[view]");
            $sheet->setCellValue("C$i", "$item[user]");
            $sheet->setCellValue("D$i", "$item[link]");
            $objWriter->save(__DIR__ . "/file_$dateFile.xlsx");
            
        } 

    }

?>