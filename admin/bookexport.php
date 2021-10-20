<?php
include_once "../inc/dbconfig.php";

$result = $mysqli->query("SELECT name, date, title, description FROM books ORDER BY name,date,title");

$header = "Author\tDate\tTitle\tDescription";

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
header("Content-Disposition: attachment; filename=Books-".date("Ymd-Hi").".xls");
header("Pragma: no-cache");
header("Expires: 0");
print $header."\n".$data;
exit;
?>