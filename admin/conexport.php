<?php
include_once "../inc/dbconfig.php";

// require the PHPExcel file
require 'inc/PHPExcel.php';

// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();

function PopulateSheet($objPHPExcel) {
	$query = "
	SELECT conference.title AS conftitle, conference.location, FROM_UNIXTIME(conference.startdate, '%c/%e/%Y'), FROM_UNIXTIME(conference.enddate, '%c/%e/%Y'), conference.description, contributors.name, contributors.title AS conttitle, contributors.abstract, contributors.file1, contributors.file2, contributors.file3, contributors.file4, contributors.file5, contributors.file6
	FROM `conference`
	INNER JOIN `contributors` on conference.id = contributors.conference
	ORDER BY conference.startdate DESC, contributors.datetime ASC;
	";

	$result = $mysqli->query($query);
	$headings = array("Conference Title","Conference Location","Conference Start Date","Conference End Date","Conference Description","Contributor Name","Presentation Title","Presentation Abstract","File 1","File 2","File 3","File 4","File 5","File 6");
  $lastcol = "N";
	
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
		$rowNumber++;
	}
	
	// Format the header cells and autosize the columns
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.$lastcol.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDDDD');
	$objPHPExcel->getActiveSheet()->getStyle('A1:'.$lastcol.'1')->getFont()->setBold(true);
	// for ($i="A"; $i<=$lastcol; $i++) {
	// 	$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
	// }
	
	$objPHPExcel->getActiveSheet()->setSelectedCell('A' . $rowNumber);
}

// Dump the info for this sort into first sheet
PopulateSheet($objPHPExcel);

// Save as an Excel BIFF (xls) file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Conferences-' . date("Ymd-Hi") . '.xls"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');
?>