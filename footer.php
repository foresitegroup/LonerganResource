    <?php if ($PageTitle != "") { echo "</div>  <!-- END content -->"; } ?>
    
    <div id="sidebar">
      <h1>Newsletter</h1>
      
      Sign up today to receive periodic announcements, new material offerings and news.
      <br><br>
      <a href="newsletter.php" id="signup"></a>
      
      <br><br>
      
      <h1>Calendar</h1>
      <div id="calendar">
        <?php
        $calresult = mysql_query("SELECT * FROM calendar WHERE date >= '" . strtotime("Today") . "' ORDER BY date ASC");
        while($calrow = mysql_fetch_array($calresult)) {
          echo "<a href=\"calendar.php?" . $calrow['id'] . "\"><strong>" . date("M d", $calrow['date']) . ":</strong> " . $calrow['event'] . "</a><br>\n";
        }
        ?>
        <a href="calendar.php" id="cal"></a>
        <div style="height: 19px;"></div>
      </div> <!-- END calendar -->
      
      <br><br>
      <a href="pdf/Fund_Letter_2011.pdf">2011 Report from the Marquette Lonergan Project</a> <img src="images/pdf.gif" alt="PDF">
    </div> <!-- END sidebar -->
    
    <div style="clear: both;"></div>
  </div> <!-- END content -->
  
  <div id="content-bot"></div>
</div> <!-- END wrap -->

<div style="text-align: center; color: #242323; font-size: 80%; padding: 15px 0;">
  Website created and maintained by <a href="http://www.foresitegrp.com" style="color: #242323;">Foresite Group</a>
</div>

<div id="preload">
  <img src="images/signup-h.png" alt="">
  <?php if ($PageTitle == "") { ?>
  <img src="images/explore-h.png" alt="">
  <img src="images/background-logo.png" alt="">
  <img src="images/background.png" alt="">
  <?php } ?>
</div> <!-- END preload -->

<!-- BEGIN Google Analytics -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5868819-28");
pageTracker._trackPageview();
} catch(err) {}</script>
<!-- END Google Analytics -->

</body>
</html>