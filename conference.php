<?php
include("inc/dbconfig.php");
require_once("inc/getid3/getid3/getid3.php");
$result = mysql_query("SELECT * FROM conference WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
$row = mysql_fetch_array($result);

$datestr = date("M d", $row['startdate']);
if (($row['enddate'] == "") || ($row['enddate'] == $row['startdate'])) {
  $datestr .= ", " . date("Y", $row['startdate']);
} else {
  if (date("Y", $row['startdate']) != date("Y", $row['enddate'])) { $datestr .= ", " . date("Y", $row['startdate']); }
  $datestr .= (date("M", $row['startdate']) == date("M", $row['enddate'])) ? "-" . date("d, Y", $row['enddate']) : "-" . date("M d, Y", $row['enddate']);
}

$PageTitle = $datestr . " - " . $row['title'];
include "header.php";
?>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" href="inc/jplayer/jplayer.lonergan.css" rel="stylesheet">
<script type="text/javascript" src="inc/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="inc/jplayer/jplayer.playlist.min.js"></script>

<h1><?php echo $datestr . "<br>" . $row['title'] . "<br>" . $row['location']; ?></h1>

<?php
echo str_replace("\n", "<br>", $row['description']);

$result = mysql_query("SELECT * FROM contributors WHERE display = '' AND conference = '" . $_SERVER['QUERY_STRING'] . "' ORDER BY datetime ASC");
if (mysql_num_rows($result) > 0) {
  echo "<br><br>Available contributions from this conference:\n<ol>\n";

  mysql_data_seek($result, 0);

  while($row = mysql_fetch_array($result)) {
    
?>
    <li>
      <a href="javascript:toggle('<?php echo $row['id']; ?>')"><?php echo $row['name']; ?>, <em><?php echo $row['title']; ?></em></a>
      <div id="<?php echo $row['id']; ?>" style="display: none; font-size: 90%; padding: 0 0 15px 10px;">
        <?php
        echo str_replace("\n", "<br>", $row['abstract']);

        // Create playlist and download links
        $playlist = "";
        $tracks = 0;
        $mp3 = "";
        for ($i = 1; $i <= 6; $i++) {
          if (end(explode(".", $row['file' . $i])) == "mp3") {
            $getID3 = new getID3;
            $ThisFileInfo = $getID3->analyze("audio/contributors/" . $row['file' . $i]);

            $title = (@$ThisFileInfo['tags']['id3v2']['title'][0] != "") ? @$ThisFileInfo['tags']['id3v2']['title'][0] : $row['file' . $i];

            $length = gmdate("G:i:s", @$ThisFileInfo['playtime_seconds']);

            $playlist .= "{ title: \"" . htmlspecialchars($title) . "\", mp3: \"audio/contributors/" . $row['file' . $i] . "\", artist: \"" . $length . "\", free: true },\n";

            $tracks++;

            $mp3 .= "<a href=\"audio/contributors/" . $row['file' . $i] . "\"><img src=\"images/mp3.gif\" alt=\"MP3\"> Download <em>" . $title . "</em></a><br>\n";
          }
        }
        ?>

        <div id="jquery_jplayer_<?php echo $row['id']; ?>" class="jp-jplayer"></div>
        <div id="jp_container_<?php echo $row['id']; ?>" class="jp-audio" role="application">
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
            new jPlayerPlaylist({ jPlayer: "#jquery_jplayer_<?php echo $row['id']; ?>", cssSelectorAncestor: "#jp_container_<?php echo $row['id']; ?>" },
              [ <?php echo $playlist; ?> ], {
              swfPath: "inc/jplayer", useStateClassSkin: true, autoBlur: false,
              smoothPlayBar: true, keyEnabled: true, remainingDuration: true
            });
            $.jPlayer.timeFormat.showHour = true;
          });
        </script>

        <?php
        echo "<div style=\"padding-top: 5px;\">\n";
          //echo $mp3;
          
          if ($row['adobe'] == "yes") echo '<br><a href="https://get.adobe.com/reader/">Adobe Reader</a> is required to play embedded media files.';

          // Link to PDFs (if any)
          for ($i = 1; $i <= 6; $i++) {
            if (end(explode(".", $row['file' . $i])) == "pdf") {
              $document = file_get_contents("pdf/contributors/" . $row['file' . $i]);
              $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
              $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $row['file' . $i];
              $pdf = ($pdfauthor != "" && $pdftitle != $row['file' . $i]) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";

              echo "<br><a href=\"pdf/contributors/" . $row['file' . $i] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> View " . $pdf . "</a>\n";
            }
          }
        echo "</div>\n";
        ?>
      </div>
    </li>
<?php
  }

  echo "</ol>\n";
}
?>

<?php include "footer.php"; ?>