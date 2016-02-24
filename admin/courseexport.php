<?php
include_once "../inc/dbconfig.php";

// require the PHPExcel file
require 'inc/PHPExcel.php';

// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();

function PopulateSheet($objPHPExcel) {
	$result = mysql_query("SELECT name, date, title, location, description, id FROM courses ORDER BY name ASC");
	$headings = array("Instructor","Date","Title","Location","Description","Files");
  $lastcol = "F";
	
	$rowNumber = 1;
	$col = 'A';
	foreach($headings as $heading) {
		$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading);
		$col++;
	}
	
	// Loop through the result set
	$rowNumber = 2;
	while ($row = mysql_fetch_row($result)) {
		$col = 'A';
		foreach($row as $cell) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit($col.$rowNumber, $cell, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$col++;
		}
    
    $TheFiles = "";
	  if (file_exists("../pdf/courses/" . $cell)) {
	  	$pdf = array();
	    $handler = opendir("../pdf/courses/" . $cell);

	    while ($file = readdir($handler)) {
	      if (pathinfo($file, PATHINFO_EXTENSION) == "pdf") $pdf[] .= $file . "\n";
	    }

	    closedir($handler);

	    natsort($pdf);
	    foreach ($pdf as $value) { $TheFiles .= $value; }
	  }
	  
	  if (file_exists("../audio/courses/" . $cell)) {
	  	$audio = array();
	    $handler = opendir("../audio/courses/" . $cell);

	    while ($file = readdir($handler)) {
	      if (pathinfo($file, PATHINFO_EXTENSION) == "mp3") $audio[] .= $file . "\n";
	    }

	    closedir($handler);

	    natsort($audio);
	    foreach ($audio as $value) { $TheFiles .= $value; }
	  }

	  if ($TheFiles == "") $TheFiles = "No files";

    $objPHPExcel->getActiveSheet()->setCellValueExplicit($lastcol.$rowNumber, $TheFiles, PHPExcel_Cell_DataType::TYPE_STRING);

		$rowNumber++;
	}
	
	// Format the header cells and autosize the columns
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.$lastcol.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.$lastcol.'1')->getFont()->setBold(true);
	for ($i="A"; $i<=$lastcol; $i++) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
	}
	
	$objPHPExcel->getActiveSheet()->setSelectedCell('A' . $rowNumber);
}

// Dump the info for this sort into first sheet
PopulateSheet($objPHPExcel);

// Save as an Excel BIFF (xls) file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Courses-' . date("Ymd-Hi") . '.xls"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');
?>