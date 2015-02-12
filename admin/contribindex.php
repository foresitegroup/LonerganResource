<?php
include "login.php";
include "../inc/dbconfig.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <META http-equiv="Content-Type" content="text/html;charset=utf-8">
  <META http-equiv="pragma" content="no-cache">
  <META http-equiv="imagetoolbar" content="no">
  <META name="language" content="en">
  <META name="author" content="Remedi Creative">
  <META name="description" content="">
  <META name="keywords" content="">
  <title>Lonergan Resource Administration | Contributers</title>
  <link rel="shortcut icon" href="../images/favicon.ico">
  <link rel="stylesheet" href="../inc/lr2009.css" type="text/css" media="screen,print">
  <style type="text/css">
    #contact LABEL {
      width: 40px;
    }
  </style>
  <!--[if lt IE 7]>
    <script src="../inc/IE8.js" type="text/javascript"></script>
  <![endif]-->
  <script type="text/javascript" src="inc/datepicker.js"></script>
  <link rel="stylesheet" href="inc/datepicker.css" type="text/css" media="screen">
</head>
<body>

<!-- BEGIN menubar -->
<div class="menubar-l" style="width: 100%;"></div>
<div class="menubar-fl"></div>
<!-- END menubar -->

<div id="wrap">
  <?php include "menu.php"; ?>

  <div id="content-top" style="margin-top: 75px;"></div>
  <div id="content-sides">

    <div style="float: left; width: 50%;">
      <h1>Add Contributor</h1>

      <form action="contribdb.php?a=add" method="POST">
        <div id="contact">
          <label style="width: 85px;">Conference</label>
          <select name="conference" style="width: 315px;">
            <option value="">Select...</option>
            <?php
            $cresult = mysql_query("SELECT * FROM conference ORDER BY startdate ASC");
            while($crow = mysql_fetch_array($cresult)) {
              $cdatestr = date("M d", $crow['startdate']);
              if (($crow['enddate'] == "") || ($crow['enddate'] == $crow['startdate'])) {
                $cdatestr .= ", " . date("Y", $crow['startdate']);
              } else {
                if (date("Y", $crow['startdate']) != date("Y", $crow['enddate'])) { $cdatestr .= ", " . date("Y", $crow['startdate']); }
                $cdatestr .= (date("M", $crow['startdate']) == date("M", $crow['enddate'])) ? "-" . date("d, Y", $crow['enddate']) : "-" . date("M d, Y", $crow['enddate']);
              }

              echo "<option value=\"" . $crow['id'] . "\">" . $cdatestr . " - " . $crow['title'] . "</option>\n";
            }
            ?>
          </select><br>
          <br>
          <label>Date</label> <input type="text" name="date" size="8" class="dateformat-m-sl-d-sl-Y fill-grid" id="dateformat" style="width: 80px;">
          <label style="margin-left: 65px; width: 40px;">Time</label>
          <select name="hour">
            <option value="">H</option>
            <?php
            for ($hour = 1; $hour <= 12; $hour++) {
              echo "<option value=\"" . $hour . "\">" . $hour . "</option>\n";
            }
            ?>
          </select>
          <select name="minute">
            <option value="">M</option>
            <?php
            for ($minute = 0; $minute <= 55; $minute=$minute+5) {
              echo "<option value=\"" . str_pad($minute, 2, "0", STR_PAD_LEFT) . "\">" . str_pad($minute, 2, "0", STR_PAD_LEFT) . "</option>\n";
            }
            ?>
          </select>
          <select name="ap">
            <option value="">A/P</option>
            <option value="AM">AM</option>
            <option value="PM">PM</option>
          </select>
          <br>
          <br>
          <label>Name</label> <input type="text" name="name" style="width: 355px;"><br>
          <br>
          <label>Title</label> <input type="text" name="title" style="width: 355px;"><br>
          <br>
          <label>Abstract</label><br>
          <textarea name="abstract" rows="6" cols="35" style="width: 400px; height: 600px;"></textarea><br>
          <br>
          <label>File 1</label> <input type="text" name="file1" style="width: 355px;"><br>
          <br>
          <label>File 2</label> <input type="text" name="file2" style="width: 355px;"><br>
          <br>
          <label>File 3</label> <input type="text" name="file3" style="width: 355px;"><br>
          <br>
          <label>File 4</label> <input type="text" name="file4" style="width: 355px;"><br>
          <br>
          <label>File 5</label> <input type="text" name="file5" style="width: 355px;"><br>
          <br>
          <label>File 6</label> <input type="text" name="file6" style="width: 355px;"><br>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>

    <div style="float: right; width: 50%;">
      <h1>Available Contributors</h1>

      <?php
      $result = mysql_query("SELECT * FROM contributors ORDER BY name ASC");
      while($row = mysql_fetch_array($result)) {
        echo "
        <div style=\"margin-left: 90px;\">
          <div style=\"float: left; width: 90px; margin-left: -90px;\">
            <a href=\"contribedit.php?id=" . $row['id'] . "\">edit</a> |
            <a href=\"contribdb.php?a=delete&id=" . $row['id'] . "\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\">delete</a>
          </div>
          " . $row['name'] . ", \"" . $row['title'] . "\" (" . date("M d, Y", $row['datetime']) . ")
        </div><br>
        ";
      }
      ?>
    </div>

    <div style="clear: both;"></div>

  </div> <!-- END content-sides -->
  <div id="content-bot"></div>
</div> <!-- END wrap -->

</body>
</html>