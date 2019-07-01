<?php
include_once "../inc/dbconfig.php";

// require the PHPExcel file
require 'inc/PHPExcel.php';

// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();

function PopulateSheet($objPHPExcel) {
	$result = $mysqli->query("SELECT name, date, title, description, id FROM books ORDER BY name,date,title");
	$headings = array("Author","Date","Title","Description","Files");
  $lastcol = "E";
	
	$rowNumber = 1;
	$col = 'A';
	foreach($headings as $heading) {
		$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading);
		$col++;
	}
	
	// Loop through the result set
	$rowNumber = 2;
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$col = 'A';
		foreach($row as $cell) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit($col.$rowNumber, $cell, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$col++;
		}
    
    $TheFiles = "";
	  if (file_exists("../pdf/books/" . $cell)) {
	  	$pdf = array();
	    $handler = opendir("../pdf/books/" . $cell);

	    while ($file = readdir($handler)) {
	      if (pathinfo($file, PATHINFO_EXTENSION) == "pdf") $pdf[] .= $file . "\n";
	    }

	    closedir($handler);

	    natsort($pdf);
	    foreach ($pdf as $value) { $TheFiles .= $value; }
	  }
	  
	  if ($TheFiles == "") $TheFiles = "No files";

    $objPHPExcel->getActiveSheet()->setCellValueExplicit($lastcol.$rowNumber, $TheFiles, PHPExcel_Cell_DataType::TYPE_STRING);

		$rowNumber++;
	}
	
	// Format the header cells and autosize the columns
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.$lastcol.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.$lastcol.'1')->getFont()->setBold(true);
	for ($i='A'; $i<=$lastcol; $i++) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
	}
	
	$objPHPExcel->getActiveSheet()->setSelectedCell('A' . $rowNumber);
}

// Dump the info for this sort into first sheet
PopulateSheet($objPHPExcel);

// Save as an Excel BIFF (xls) file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Books-' . date("Ymd-Hi") . '.xls"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');
?>