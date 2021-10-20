<?php
include_once "../inc/dbconfig.php";

$result = $mysqli->query("
  SELECT journaltitles.title, journals.volume, journals.number, journals.description, journals.file1
  FROM `journaltitles`
  INNER JOIN `journals` on journaltitles.id = journals.titleid
  ORDER BY journaltitles.title, journals.volume+0, journals.number+0 ASC;
");

$header = "Title\tVolume\tNumber\tDescription\tFile";

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
header("Content-Disposition: attachment; filename=Journals-".date("Ymd-Hi").".xls");
header("Pragma: no-cache");
header("Expires: 0");
print $header."\n".$data;
exit;
?>