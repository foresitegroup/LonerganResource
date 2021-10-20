<?php
include_once "../inc/dbconfig.php";

$result = $mysqli->query("
  SELECT conference.title AS conftitle, conference.location, FROM_UNIXTIME(conference.startdate, '%c/%e/%Y'), FROM_UNIXTIME(conference.enddate, '%c/%e/%Y'), conference.description, contributors.name, contributors.title AS conttitle, contributors.abstract, contributors.file1, contributors.file2, contributors.file3, contributors.file4, contributors.file5, contributors.file6
  FROM `conference`
  INNER JOIN `contributors` on conference.id = contributors.conference
  ORDER BY conference.startdate DESC, contributors.datetime ASC;
");

$header = "Conference Title\tConference Location\tConference Start Date\tConference End Date\tConference Description\tContributor Name\tPresentation Title\tPresentation Abstract\tFile 1\tFile 2\tFile 3\tFile 4\tFile 5\tFile 6\t";

while($row = $result->fetch_array(MYSQLI_ASSOC)) {
  $line = '';
  foreach($row as $value) {
    if ((!isset($value)) OR ($value == "")) {
      $value = "\t"; 
    } else {
      $value = str_replace('"', '""', $value);
      $value = str_replace("\n", " ", $value);
      $value = '"' . $value . '"' . "\t"; 
    }
    $line .= $value;
  }
  $data .= $line . "\n";
}
$data = str_replace("\r","",$data);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Conferences-".date("Ymd-Hi").".xls");
header("Pragma: no-cache");
header("Expires: 0");
print $header."\n".$data;
exit;
?>