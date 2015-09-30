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
  <title>Lonergan Resource Administration | Contributor Edit</title>
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

    <h1>Edit Contributor</h1>

    <?php
    $result = mysql_query("SELECT * FROM contributors WHERE id = '" . $_GET['id'] . "'");
    $row = mysql_fetch_array($result);
    ?>

    <form action="contribdb.php?a=edit" method="POST">
      <div id="contact">
        Do not display publically <input type="checkbox" name="display" value="no" style="vertical-align: middle; width: auto;"<?php if($row['display'] != "") echo " checked"; ?>><br>
        <br>
        <label style="width: 85px;">Conference</label>
          <select name="conference" style="width: 315px;">
            <option value="">Select...</option>
            <?php
            $cresult = mysql_query("SELECT * FROM conference ORDER BY startdate ASC");
            while($crow = mysql_fetch_array($cresult)) {
              $cdatestr = date("M d", $crow['startdate']);
              if (($crow['enddate'] == "") || ($crow['enddate'] == $crow['startdate'])) {
                $cdatestr .= ", " . date("Y", $row['cstartdate']);
              } else {
                if (date("Y", $crow['startdate']) != date("Y", $crow['enddate'])) { $cdatestr .= ", " . date("Y", $crow['startdate']); }
                $cdatestr .= (date("M", $crow['startdate']) == date("M", $crow['enddate'])) ? "-" . date("d, Y", $crow['enddate']) : "-" . date("M d, Y", $crow['enddate']);
              }

              echo "<option value=\"" . $crow['id'] . "\"";
              if ($crow['id'] == $row['conference']) { echo " selected"; }
              echo ">" . $cdatestr . " - " . $crow['title'] . "</option>\n";
            }
            ?>
          </select><br>
          <br>
          <label>Date</label> <input type="text" name="date" size="8" class="dateformat-m-sl-d-sl-Y fill-grid" id="dateformat" style="width: 80px;" value="<?php echo date("m/d/Y",$row['datetime']); ?>">
          <label style="margin-left: 65px; width: 40px;">Time</label>
          <select name="hour">
            <option value="">H</option>
            <?php
            for ($hour = 1; $hour <= 12; $hour++) {
              echo "<option value=\"" . $hour . "\"";
              if ($hour == date("g",$row['datetime'])) { echo " selected"; }
              echo ">" . $hour . "</option>\n";
            }
            ?>
          </select>
          <select name="minute">
            <option value="">M</option>
            <?php
            for ($minute = 0; $minute <= 55; $minute=$minute+5) {
              echo "<option value=\"" . str_pad($minute, 2, "0", STR_PAD_LEFT) . "\"";
              if ($minute == date("i",$row['datetime'])) { echo " selected"; }
              echo ">" . str_pad($minute, 2, "0", STR_PAD_LEFT) . "</option>\n";
            }
            ?>
          </select>
          <select name="ap">
            <option value="">A/P</option>
            <option value="AM"<?php if (date("A",$row['datetime']) == "AM") { echo " selected"; } ?>>AM</option>
            <option value="PM"<?php if (date("A",$row['datetime']) == "PM") { echo " selected"; } ?>>PM</option>
          </select>
          <br>
          <br>
          <label>Name</label> <input type="text" name="name" value="<?php echo $row['name']; ?>" style="width: 355px;"><br>
          <br>
          <label>Title</label> <input type="text" name="title" value="<?php echo $row['title']; ?>" style="width: 355px;"><br>
          <br>
          <label>Abstract</label><br>
          <textarea name="abstract" rows="6" cols="35" style="width: 400px; height: 600px;"><?php echo $row['abstract']; ?></textarea><br>
          <br>
          <label>File 1</label> <input type="text" name="file1" value="<?php echo $row['file1']; ?>" style="width: 355px;"><br>
          <br>
          <label>File 2</label> <input type="text" name="file2" value="<?php echo $row['file2']; ?>" style="width: 355px;"><br>
          <br>
          <label>File 3</label> <input type="text" name="file3" value="<?php echo $row['file3']; ?>" style="width: 355px;"><br>
          <br>
          <label>File 4</label> <input type="text" name="file4" value="<?php echo $row['file4']; ?>" style="width: 355px;"><br>
          <br>
          <label>File 5</label> <input type="text" name="file5" value="<?php echo $row['file5']; ?>" style="width: 355px;"><br>
          <br>
          <label>File 6</label> <input type="text" name="file6" value="<?php echo $row['file6']; ?>" style="width: 355px;"><br>
        <br>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="submit" name="submit" value="Update" class="button">
      </div>
    </form>

  </div> <!-- END content-sides -->
  <div id="content-bot"></div>
</div> <!-- END wrap -->

</body>
</html>