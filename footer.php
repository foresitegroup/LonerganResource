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
      <a href="pdf/2018_Letter_from_Robert_M._Doran.pdf" style="font-weight: bold; font-size: 170%;">2018 Letter from Robert M. Doran</a> <img src="images/pdf.gif" alt="PDF">
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
  <?php } ?>
</div> <!-- END preload -->

<!-- BEGIN Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-5868819-28', 'auto');
  ga('send', 'pageview');
</script>
<!-- END Google Analytics -->

</body>
</html>