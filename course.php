<?php
include("inc/dbconfig.php");
require_once("inc/getid3/getid3/getid3.php");
$result = mysql_query("SELECT * FROM courses WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
$row = mysql_fetch_array($result);

$PageTitle = $row['name'] . ", " . $row['date'] . ", " . $row['title'];
include "header.php";
?>

<h1><?php echo $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em><br>" . $row['location']; ?></h1>

<?php
function Linkify($text) {
  $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\">$3</a>", $text);  
  $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\">$3</a>", $text);  
  $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
  return $text;
}

echo str_replace("\n", "<br>", Linkify($row['description'])) . "<br>\n";

if (file_exists("pdf/courses/" . $_SERVER['QUERY_STRING'])) {
  // Get all PDFs for this course
  $results = array();
  $handler = opendir("pdf/courses/" . $_SERVER['QUERY_STRING']);
  
  while ($file = readdir($handler)) {
    if (end(explode(".", $file)) == "pdf")
      $results[] = $file;
  }
  
  closedir($handler);
  
  sort($results);
  
  foreach ($results as $value) {
    $document = file_get_contents("pdf/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value);
    $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
    $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $value;
    $pdf = ($pdfauthor != "" && $pdftitle != $value) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
    
    echo "<br><a href=\"pdf/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a>\n";
  }
}

if (file_exists("audio/courses/" . $_SERVER['QUERY_STRING'])) {
// Get all MP3s for this course
  $results = array();
  $handler = opendir("audio/courses/" . $_SERVER['QUERY_STRING']);
  
  while ($file = readdir($handler)) {
    if (end(explode(".", $file)) == "mp3")
      $results[] = $file;
  }
  
  closedir($handler);
  
  sort($results);
  
  // Delete XML playlist...
  if (file_exists("audio/courses/" .  $_SERVER['QUERY_STRING'] . "/playlist.xml")) {
    unlink("audio/courses/" .  $_SERVER['QUERY_STRING'] . "/playlist.xml");
  }
  
  // ...and create a new one
  $xml = "<rss version=\"2.0\" xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\">\n<channel>\n<title>Playlist</title>\n";
  
  $playlistheight = 0;
  $mp3 = "";
  
  foreach ($results as $value) {
    // Count MP3s and adjust playlist height accordingly
    $playlistheight = $playlistheight + 24;
    
    // Get ID3 info if available
    $getID3 = new getID3;
    $ThisFileInfo = $getID3->analyze("audio/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value);
    $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $value;
    $duration = @$ThisFileInfo['playtime_string'];
    
    // Add item
    $xml .= "<item>\n<title>" . $title . "</title>\n<enclosure url=\"audio/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\" type=\"audio/mpeg\" length=\"" . filesize("audio/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value) . "\" />\n<itunes:duration>" . $duration . "</itunes:duration>\n</item>\n";
    
    // Create download links while we're at it.  We'll display them after the playlist
    $mp3 .= "<br><a href=\"audio/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\"><img src=\"images/mp3.gif\" alt=\"MP3\"> Download <em>" . $title . "</em></a>\n";
  }
  
  $xml .= "</channel>\n</rss>";
      
  // Finally create the XML file
  $fp = fopen("audio/courses/" .  $_SERVER['QUERY_STRING'] . "/playlist.xml", "w");
  fwrite($fp, $xml);
  fclose($fp);
  
  // If there's more than 10 mp3s, they can scroll the playlist
  if ($playlistheight > 240) { $playlistheight = 240; }
  
  if (file_exists("audio/courses/" .  $_SERVER['QUERY_STRING'] . "/playlist.xml")) {
  ?>
  <div id="audio<?php echo $row['id']; ?>" style="padding-top: 10px;">You don't have Flash installed or your version is too old.  Please <a href="http://get.adobe.com/flashplayer/">download</a> a newer version.</div>
  <script type="text/javascript">
    var so = new SWFObject("inc/player.swf", "player", "600", "<?php echo 32 + $playlistheight; ?>", "9");
    so.addVariable("skin", "inc/playerskin.swf");
    so.addVariable("backcolor", "#4F4D4D");
    so.addVariable("playlist", "bottom");
    so.addVariable("playlistsize", "<?php echo $playlistheight; ?>");
    so.addVariable("playlistfile", "audio/courses/<?php echo $_SERVER['QUERY_STRING']; ?>/playlist.xml");
    so.write("audio<?php echo $_SERVER['QUERY_STRING']; ?>");
  </script>
  <?php
  }
  
  echo $mp3;
}
?>

<?php include "footer.php"; ?>