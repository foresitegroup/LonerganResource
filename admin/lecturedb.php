<?php
include("../inc/dbconfig.php");
require_once("../inc/getid3/getid3/getid3.php");

switch ($_GET['a']) {
  case "add":
    $query = "INSERT INTO lectures (date, name, title, location, description, file1, file2, file3, file4, file5, display) VALUES ('" . $_POST['date'] . "', '" . $_POST['name'] . "', '" . $_POST['title'] . "', '" . $_POST['location'] . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['file1'] . "', '" . $_POST['file2'] . "', '" . $_POST['file3'] . "', '" . $_POST['file4'] . "', '" . $_POST['file5'] . "', '" . $_POST['display'] . "')";
    break;
  case "edit":
    $query = "UPDATE lectures SET date = '" . $_POST['date'] . "', name = '" . $_POST['name'] . "', title = '" . $_POST['title'] . "', location = '" . $_POST['location'] . "', description = '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', file1 = '" . $_POST['file1'] . "', file2 = '" . $_POST['file2'] . "', file3 = '" . $_POST['file3'] . "', file4 = '" . $_POST['file4'] . "', file5 = '" . $_POST['file5'] . "', display = '" . $_POST['display'] . "' WHERE id = '" . $_POST['id'] . "'";
    break;
  case "delete":
    $query = "DELETE FROM lectures WHERE id = '" . $_GET['id'] . "'";
    break;
}

mysql_query($query) or die(mysql_error());

$TheID = ($_GET['a'] == "add") ? mysql_insert_id() : $_REQUEST['id'];

// Delete XML playlist...
if (file_exists("../audio/lectures/cont" .  $TheID . ".xml")) {
  unlink("../audio/lectures/cont" .  $TheID . ".xml");
}

// ...and create a new one
if ($_GET['a'] != "delete") {
  $ext = array(end(explode(".", $_POST['file1'])), end(explode(".", $_POST['file2'])), end(explode(".", $_POST['file3'])), end(explode(".", $_POST['file4'])), end(explode(".", $_POST['file5'])));
  if (in_array("mp3", $ext)) {
    $xml = "<rss version=\"2.0\" xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\">\n<channel>\n<title>Playlist</title>\n";
    
    for ($i = 1; $i <= 5; $i++) {
      if (end(explode(".", $_POST['file' . $i])) == "mp3") {
        $getID3 = new getID3;
        $ThisFileInfo = $getID3->analyze("../audio/lectures/" . $_POST['file' . $i]);
        $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $_POST['file' . $i];
        $duration = @$ThisFileInfo['playtime_string'];
        $xml .= "<item>\n<title>" . $title . "</title>\n<enclosure url=\"audio/lectures/" . $_POST['file' . $i] . "\" type=\"audio/mpeg\" length=\"" . filesize("../audio/lectures/" . $_POST['file' . $i]) . "\" />\n<itunes:duration>" . $duration . "</itunes:duration>\n</item>\n";
      }
    }
    
    $xml .= "</channel>\n</rss>";
    
    // Actually write the file, finally
    $fp = fopen("../audio/lectures/lect" .  $TheID . ".xml", "w");
    fwrite($fp, $xml);
    fclose($fp);
  }
}

header( "Location: lectureindex.php" );
?>