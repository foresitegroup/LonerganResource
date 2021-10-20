<?php
include_once "../inc/dbconfig.php";

$result = $mysqli->query("SELECT name, date, title, location, description, file1, file2, file3, file4, file5 FROM lectures ORDER BY name+0 ASC");

$header = "Presenter\tDate\tTitle\tLocation\tDescription\tFile 1\tFile 2\tFile 3\tFile 4\tFile 5";

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
header("Content-Disposition: attachment; filename=Lectures-".date("Ymd-Hi").".xls");
header("Pragma: no-cache");
header("Expires: 0");
print $header."\n".$data;
exit;
?>