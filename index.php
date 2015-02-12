<?php include "header.php"; ?>

<div id="main-left">
  <h1>Bernard Lonergan</h1>
  
  Fr. Bernard Lonergan, S.J. was a Canadian Jesuit Priest born in Buckingham, Quebec. He was a philosopher-theologian, an economist, and a student of methodology. Lonergan is the author of <em>Insight: A Study of Human Understanding</em> (1957) and <em>Method in Theology</em> (1972).  In <em>Insight</em> he worked out what he called a Generalized Empirical Method, and in <em>Method in Theology</em> he showed how this method elucidated the structure and process of work in theology.<br>
  <br>
  
  Frederick Crowe began collecting what would become Lonergan's archival materials in 1953, and continued for many years to assemble what became the Archives. Father Crowe died on Easter Sunday, 2012. <a href="frederick-crowe.php">View an obituary and the homily delivered at his funeral.</a>
</div> <!-- END main-left -->

<div id="main-mid">
  <h1>News &amp; Announcements</h1>
  
  <?php
  $result = mysql_query("SELECT * FROM news ORDER BY id DESC");
  $oe = "odd";
  while($row = mysql_fetch_array($result)) {
    echo "<div class=\"news";
    if ($oe == "odd") { echo "-b"; $oe = "even"; } else { $oe = "odd"; }
    echo "\">\n";
    
    echo "<a href=\"news.php#" . $row['id'] . "\" class=\"newslink\">read more</a>";
    
    echo "<h2 style=\"display: inline;\">";
    if (strlen($row['title']) > 35) {
      echo substr($row['title'], 0, 35) . "...</h2>";
    } else {
      echo $row['title'] . ":</h2> ";
      echo substr($row['description'], 0, 35 - strlen($row['title'])) . "...";
    }
    echo "\n</div>\n";
  }
  ?>
</div> <!-- END main-mid -->

<?php include "footer.php"; ?>