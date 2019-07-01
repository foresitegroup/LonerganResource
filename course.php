<?php
include("inc/dbconfig.php");
require_once("inc/getid3/getid3/getid3.php");
$result = $mysqli->query("SELECT * FROM courses WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
$row = $result->fetch_array(MYSQLI_ASSOC);

$PageTitle = $row['name'] . ", " . $row['date'] . ", " . $row['title'];
include "header.php";
?>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" href="inc/jplayer/jplayer.lonergan.css" rel="stylesheet">
<script type="text/javascript" src="inc/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="inc/jplayer/jplayer.playlist.min.js"></script>

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
    $pext = explode(".", $file);
    if (end($pext) == "pdf") $results[] = $file;
  }
  
  closedir($handler);
  
  sort($results);
  
  foreach ($results as $value) {
    $document = file_get_contents("pdf/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value);

    preg_match_all("/\/Author\((.*?)\)/",$document,$aarr);
    $aarr_last = end($aarr);
    $pdfauthor = end($aarr_last);

    preg_match_all("/\/Title\((.*?)\)/",$document,$tarr);
    $tarr_last = end($tarr);
    $pdftitle = end($tarr_last);
    if ($pdftitle == "") $pdftitle = $value;

    $pdf = ($pdfauthor != "" && $pdftitle != $value) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
    
    echo "<br><a href=\"pdf/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a>\n";
  }
}

echo "<br><br>";

if (file_exists("audio/courses/" . $_SERVER['QUERY_STRING'])) {
  // Get all MP3s for this course
  $results = array();
  $handler = opendir("audio/courses/" . $_SERVER['QUERY_STRING']);
  
  while ($file = readdir($handler)) {
    $mext = explode(".", $file);
    if (end($mext) == "mp3") $results[] = $file;
  }
  
  closedir($handler);
  
  sort($results);

  $playlist = "";
  $tracks = 0;
  $mp3 = "";
  
  foreach ($results as $value) {
    // Get ID3 info if available
    $getID3 = new getID3;
    $ThisFileInfo = $getID3->analyze("audio/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value);
    
    $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $value;
    
    $length = gmdate("G:i:s", @$ThisFileInfo['playtime_seconds']);

    $playlist .= "{ title: \"" . htmlspecialchars($title) . "\", mp3: \"audio/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\", artist: \"" . $length . "\", free: true },\n";

    $tracks++;

    // Create download links while we're at it.  We'll display them after the playlist
    $mp3 .= "<br><a href=\"audio/courses/" . $_SERVER['QUERY_STRING'] . "/" . $value . "\"><img src=\"images/mp3.gif\" alt=\"MP3\"> Download <em>" . $title . "</em></a>\n";
  }
  ?>

  <div id="jquery_jplayer_<?php echo $_SERVER['QUERY_STRING']; ?>" class="jp-jplayer"></div>
  <div id="jp_container_<?php echo $_SERVER['QUERY_STRING']; ?>" class="jp-audio" role="application">
    <div class="jp-controls-holder<?php if ($tracks == 1) echo " single"; ?>">
      <div class="jp-controls">
        <button class="jp-play" role="button"></button>
        <button class="jp-previous" role="button"></button>
        <button class="jp-next" role="button"></button>
      </div>
      <div class="jp-progress">
        <div class="jp-current-time" role="timer"></div>
        <div class="jp-seek-bar">
          <div class="jp-play-bar"></div>
        </div>
        <div class="jp-duration" role="timer"></div>
      </div>
      <div class="jp-volume-controls">
        <button class="jp-mute" role="button"></button>
        <div class="jp-volume-bar">
          <div class="jp-volume-bar-value"></div>
        </div>
      </div>
    </div>
    <div class="jp-playlist"><ul></ul></div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      new jPlayerPlaylist({ jPlayer: "#jquery_jplayer_<?php echo $_SERVER['QUERY_STRING']; ?>", cssSelectorAncestor: "#jp_container_<?php echo $_SERVER['QUERY_STRING']; ?>" },
        [ <?php echo $playlist; ?> ], {
        swfPath: "inc/jplayer", useStateClassSkin: true, autoBlur: false,
        smoothPlayBar: true, keyEnabled: true, remainingDuration: true
      });
      $.jPlayer.timeFormat.showHour = true;
    });
  </script>
  <?php
  //echo $mp3;
}
?>

<?php include "footer.php"; ?>