<?php
include("../inc/dbconfig.php");
require_once("../inc/getid3/getid3/getid3.php");

if (($_GET['a'] != "delete") && ($_POST['date'] != "")) {
  $date = strtotime($_POST['date'] . " " . $_POST['hour'] . ":" . $_POST['minute'] . " " . $_POST['ap']);
}

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO contributors (conference, datetime, name, title, abstract, file1, file2, file3, file4, file5, file6, display) VALUES ('" . $_POST['conference'] . "', '$date', '" . mysql_real_escape_string($_POST['name']) . "', '" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['abstract']) . "', '" . $_POST['file1'] . "', '" . $_POST['file2'] . "', '" . $_POST['file3'] . "', '" . $_POST['file4'] . "', '" . $_POST['file5'] . "', '" . $_POST['file6'] . "', '" . $_POST['display'] . "')";
    break;
  case "edit":
    $query = "UPDATE contributors SET conference = '" . $_POST['conference'] . "', datetime = '$date', name = '" . mysql_real_escape_string($_POST['name']) . "', title = '" . mysql_real_escape_string($_POST['title']) . "', abstract = '" . mysql_real_escape_string($_POST['abstract']) . "', file1 = '" . $_POST['file1'] . "', file2 = '" . $_POST['file2'] . "', file3 = '" . $_POST['file3'] . "', file4 = '" . $_POST['file4'] . "', file5 = '" . $_POST['file5'] . "', file6 = '" . $_POST['file6'] . "', display = '" . $_POST['display'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM contributors WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

$TheID = ($_GET['a'] == "add") ? mysql_insert_id() : $_REQUEST['id'];

// Delete XML playlist...
if (file_exists("../audio/contributors/cont" .  $TheID . ".xml")) {
  unlink("../audio/contributors/cont" .  $TheID . ".xml");
}

// ...and create a new one
if ($_GET['a'] != "delete") {
  $ext = array(end(explode(".", $_POST['file1'])), end(explode(".", $_POST['file2'])), end(explode(".", $_POST['file3'])), end(explode(".", $_POST['file4'])), end(explode(".", $_POST['file5'])), end(explode(".", $_POST['file6'])));
  if (in_array("mp3", $ext)) {
    $xml = "<rss version=\"2.0\" xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\">\n<channel>\n<title>Playlist</title>\n";

    for ($i = 1; $i <= 6; $i++) {
      if (end(explode(".", $_POST['file' . $i])) == "mp3") {
        $getID3 = new getID3;
        $ThisFileInfo = $getID3->analyze("../audio/contributors/" . $_POST['file' . $i]);
        $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $_POST['file' . $i];
        $duration = @$ThisFileInfo['playtime_string'];
        $xml .= "<item>\n<title>" . $title . "</title>\n<enclosure url=\"audio/contributors/" . $_POST['file' . $i] . "\" type=\"audio/mpeg\" length=\"" . filesize("../audio/contributors/" . $_POST['file' . $i]) . "\" />\n<itunes:duration>" . $duration . "</itunes:duration>\n</item>\n";
      }
    }

    $xml .= "</channel>\n</rss>";

    // Actually write the file, finally
    $fp = fopen("../audio/contributors/cont" .  $TheID . ".xml", "w");
    fwrite($fp, $xml);
    fclose($fp);
  }
}

header( "Location: contribindex.php" );
?>