<?php
include "inc/dbconfig.php";
if ($_SERVER['QUERY_STRING'] != "") {
  $result = mysql_query("SELECT * FROM press WHERE id = '" . $_SERVER['QUERY_STRING'] . "'");
  $row = mysql_fetch_array($result);
  $Title = " | " . strip_tags(htmlspecialchars_decode($row['title'], ENT_QUOTES)) . " (" . $row['date'] . ")";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <META http-equiv="Content-Type" content="text/html;charset=utf-8" >
  <META Name="author" Content="Mark Lippert">
  <title>Press<?php echo $Title; ?></title>
  <link rel="stylesheet" href="inc/pat2008.css" type="text/css" media="screen">
  <link rel="shortcut icon" href="http://www.patmccurdy.com/favicon.ico">
  <META HTTP-EQUIV="pragma" CONTENT="no-cache">
</head>
<body>

<!-- Begin Header -->
<div id="header">
  <div id="header-left">
    <img src="images/header_logo.gif" USEMAP="#logo" border="0" alt="Pat McCurdy">
  </div>
  <div id="header-right">
    <img src="images/header_menu.gif" USEMAP="#menu" border="0"  alt="">
  </div>
</div>
<MAP NAME="logo">
  <AREA SHAPE="poly" COORDS="0,0,0,52,125,52,125,30,80,0" HREF="http://www.patmccurdy.com" ALT="Main Page">
</MAP>

<!-- Menu -->
<script type="text/javascript" language="JavaScript1.2" src="inc/coolmenus4.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="inc/menu_pat.js"></script>
<noscript>
  <MAP NAME="menu">
    <AREA SHAPE="rect" COORDS="5,5,70,20" HREF="schedule.php" ALT="Schedule">
    <AREA SHAPE="rect" COORDS="80,5,122,20" HREF="music.htm" ALT="Music">
    <AREA SHAPE="rect" COORDS="132,5,176,20" HREF="visual.htm" ALT="Visual">
    <AREA SHAPE="rect" COORDS="188,5,268,20" HREF="info.htm" ALT="Information">
    <AREA SHAPE="rect" COORDS="277,5,351,20" HREF="inter.htm" ALT="Interactive">
    <AREA SHAPE="rect" COORDS="359,5,397,20" HREF="buystuff.htm" ALT="Shop">
  </MAP>
</noscript>
<!-- End Header -->

<br>

<div id="wrapper">
  <!-- BEGIN top scoop -->
  <div id="topscoop-wrap">
    <div id="topscoop-left"><img src="images/top_l.gif" alt=""></div>
    <div id="topscoop-right"><img src="images/top_r.gif" alt=""></div>
    <div id="topscoop-center"><img src="images/press.gif" alt="Press"></div>
  </div>
  <!-- END top scoop -->
  
  <div id="twocol">
    <div id="sidebar" style="width: 142px;">
      <!-- BEGIN sidebar content -->
      <img src="images/pat_main.jpg" alt="" width="142">
      <!-- END sidebar content -->
    </div>
    
    <div id="main" style="margin-left: 142px; min-height: 186px;">
      <!-- BEGIN main content -->
      <?php
      if ($_SERVER['QUERY_STRING'] != "") {
        // Display single article
        echo "<strong>";
        
        if ($row['source_url'] != "") { echo "<a href=\"" . $row['source_url'] . "\">"; }
        echo $row['source'];
        if ($row['source_url'] != "") { echo "</a>"; }
        
        echo " " . $row['date'];
        
        if ($row['title'] != "") { echo "<br>\n<br>\n<big>" . htmlspecialchars_decode($row['title'], ENT_QUOTES) . "</big>"; }
        
        if ($row['subtitle'] != "") { echo "<br>\n" . htmlspecialchars_decode($row['subtitle'], ENT_QUOTES); }
        
        echo "</strong><br>\n";
        
        if ($row['author'] != "") { echo "by " . $row['author'] . "<br>\n"; }
        
        echo "<br>\n" . htmlspecialchars_decode(str_replace("\r", "<br>", $row['text']), ENT_QUOTES);
      } else {
        // Display main index
        $result = mysql_query("SELECT * FROM press ORDER BY sort_date DESC");
        
        while($row = mysql_fetch_array($result)) {
          echo "<a href=\"press.php?" . $row['id'] . "\"><strong>" . $row['source'] . "</strong> " . $row['date'];
          if ($row['title'] != "") { echo "<br>\n<em>" . htmlspecialchars_decode($row['title'], ENT_QUOTES) . "</em>"; }
          echo "</a><br>
          <br>\n";
        }
        
        echo "Have you stumbled across an interview or article about Pat?  Send it to <a href=\"mailto:we&#98;&#109;&#97;&#115;&#116;&#101;&#114;&#64;&#112;a&#116;&#109;&#99;&#99;&#117;&#114;&#100;&#121;&#46;&#99;&#111;&#109;\">&#119;e&#98;&#109;&#97;&#115;&#116;&#101;&#114;&#64;&#112;&#97;&#116;&#109;&#99;&#99;&#117;&#114;&#100;&#121;&#46;&#99;&#111;m</a> or at least let me know about it.  Try to include the publication, author, date, etc.; basically, everything.  (Pretend you're back in school and writing a research paper.)  Thanks.";
      }
      ?>
      <!-- END main content -->
    </div>
  </div>
  
  <!-- BEGIN bottom scoop -->
  <div id="botscoop-left"><img src="images/bottom_l.gif" alt=""></div>
  <div id="botscoop-right"><img src="images/bottom_r.gif" alt=""></div>
  <div id="botscoop-center">&nbsp;</div>
  <!-- END bottom scoop -->
</div>

<!-- BEGIN Footer -->
<p style="text-align: center;">
  <a href="index.htm">Home</a> | 
  <a href="schedule.php">Schedule</a> | 
  <a href="music.htm">Music</a> | 
  <a href="visual.htm">Visual</a> | 
  <a href="info.htm">Information</a> | 
  <a href="inter.htm">Interactive</a> | 
  <a href="buystuff.htm">Shop</a>
</p>

<p class="small" style="text-align: center;"><!--#exec cgi="cgi-bin/inc/copyright.cgi" --></p><br>
<!-- END Footer -->

</body>
</html>