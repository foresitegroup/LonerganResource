<?php
include("../inc/dbconfig.php");

switch ($_SERVER['QUERY_STRING']) {
  case "t":
    $contype = "text/plain";
    $fileext = "txt";
    $head = "";
    break;
  case "x":
    $contype = "application/vnd.ms-excel";
    $fileext = "xls";
    $head = "Newsletter Subscribers\n";
    break;
  case "c":
    $contype = "application/vnd.ms-excel";
    $fileext = "csv";
    $head = "Newsletter Subscribers\n";
    break;
}

$result = mysql_query("SELECT * FROM newsletter ORDER BY email ASC");

while($row = mysql_fetch_array($result)) {
  $data .= $row['email'] . "\r\n";
}

$filetag = date("Ymd-Hi");

header("Content-Type: $contype");
header("Content-Disposition: attachment; filename=newletter_subscribers_$filetag.$fileext");
header("Pragma: no-cache");
header("Expires: 0");
print $head . $data;
exit;
?>