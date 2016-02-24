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
  <title>Lonergan Resource Administration | Conferences</title>
  <link rel="shortcut icon" href="../images/favicon.ico">
  <link rel="stylesheet" href="../inc/lr2009.css" type="text/css" media="screen,print">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <style type="text/css">
    #contact LABEL {
      width: 70px;
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

    <a href="conexport.php" style="float: right;">Export Conferences</a>
    <div style="clear: both;"></div><br>
    
    <div style="float: left; width: 50%;">
      <h1>Add Conference</h1>
      
      <form action="condb.php?a=add" method="POST">
        <div id="contact">
          Do not display publically <input type="checkbox" name="display" value="no" style="vertical-align: middle; width: auto;"><br>
          <br>
          <label>Start Date</label> <input type="text" name="startdate" size="8" class="dateformat-m-sl-d-sl-Y fill-grid" id="dateformat-s" style="width: 80px;"><br>
          <br>
          <label>End Date</label> <input type="text" name="enddate" size="8" class="dateformat-m-sl-d-sl-Y fill-grid" id="dateformat-e" style="width: 80px;"><br>
          <br>
          <label>Title</label> <input type="text" name="title"><br>
          <br>
          <label>Location</label> <input type="text" name="location"><br>
          <br>
          <label>Description</label><br>
          <textarea name="description" rows="6" cols="35" style="width: 400px; height: 600px;"></textarea><br>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>
    
    <div style="float: right; width: 50%;">
      <h1>Available Conferences</h1>
      
      <?php
      $result = mysql_query("SELECT * FROM conference ORDER BY startdate + 0 ASC");
      while($row = mysql_fetch_array($result)) {
        $datestr = date("M d", $row['startdate']);
        if (($row['enddate'] == "") || ($row['enddate'] == $row['startdate'])) {
          $datestr .= ", " . date("Y", $row['startdate']);
        } else {
          if (date("Y", $row['startdate']) != date("Y", $row['enddate'])) { $datestr .= ", " . date("Y", $row['startdate']); }
          $datestr .= (date("M", $row['startdate']) == date("M", $row['enddate'])) ? "-" . date("d, Y", $row['enddate']) : "-" . date("M d, Y", $row['enddate']);
        }
        
        echo "
        <div style=\"margin-left: 90px;\">
          <div style=\"float: left; width: 90px; margin-left: -90px; font-size: 120%;\">
            <a href=\"conedit.php?id=" . $row['id'] . "\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
            <a href=\"condb.php?a=delete&id=" . $row['id'] . "\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\" title=\"Delete\"><i class=\"fa fa-trash-o\"></i></a> &nbsp;
            <a href=\"../conference.php?" . $row['id'] . "\" target=\"new\" title=\"View\"><i class=\"fa fa-eye\"></i></a>
          </div>
          <strong>" . $datestr . "</strong> " . $row['title'] . "
          ";

          if (!empty($row['display'])) echo "<br><em>[Not displayed publically]</em>";

          echo "
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