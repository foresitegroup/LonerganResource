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
  <title>Lonergan Resource Administration | Calendar</title>
  <link rel="shortcut icon" href="../images/favicon.ico">
  <link rel="stylesheet" href="../inc/lr2009.css" type="text/css" media="screen,print">
  <!--[if lt IE 7]>
    <script src="../inc/IE8.js" type="text/javascript"></script>
  <![endif]-->
  <script type="text/javascript" src="inc/datepicker.js"></script>
  <link rel="stylesheet" href="inc/datepicker.css" type="text/css" media="screen">
  <script type="text/javascript">
    <!--
    function checkform (form) {
      if (form.date.value == "mm/dd/yyyy") {
        alert('Please use a proper date.');
        form.date.focus();
        return false ;
      }
      return true ;
    }
    //-->
  </script>
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
      <h1>Add Calendar Event</h1>
      
      <form action="caldb.php?a=add<?php if (!empty($_GET['b'])) { echo "&b=" . $_GET['b']; } ?>" method="POST" onSubmit="return checkform(this)">
        <div id="contact">
          <label>Date</label> <input type="text" name="date" size="8" class="dateformat-m-sl-d-sl-Y fill-grid" id="dateformat" style="width: 80px;" value="mm/dd/yyyy" onClick="if(this.value=='mm/dd/yyyy')this.value='';" onBlur="if(this.value=='')this.value='mm/dd/yyyy';"><br>
          <br>
          <label>Event</label> <input type="text" name="event"><br>
          <br>
          <label>Description</label><br>
          <textarea name="description" rows="6" cols="35" style="width: 360px; height: 100px;"></textarea><br>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>
    
    <div style="float: right; width: 50%;">
      <?php
      if (!empty($_GET['b'])) {
        $date = mktime(0,0,0,substr($_GET['b'],-2), 1, substr($_GET['b'],0,4));
        $title = date("F Y",$date);
        $lastmonth = mktime(0,0,0,substr($_GET['b'],-2)-1, 1, substr($_GET['b'],0,4));
        $nextmonth = mktime(0,0,0,substr($_GET['b'],-2)+1, 1, substr($_GET['b'],0,4));
        $prev = date("Ym",$lastmonth);
        $next = date("Ym",$nextmonth);
        $first_day = mktime(0,0,0,date("m", $date), 1, date("Y", $date));
        $last_day = mktime(23,59,59,date("m", $date), cal_days_in_month(0, date("m", $date), date("Y", $date)), date("Y", $date));
      } else {
        $title = date("F Y");
        $prev = date("Ym",strtotime("last month"));
        $next = date("Ym",strtotime("next month"));
        $first_day = mktime(0,0,0,date("m"), 1, date("Y"));
        $last_day = mktime(23,59,59,date("m"), cal_days_in_month(0, date("m"), date("Y")), date("Y"));
      }
      ?>
      
      <div style="float: left; text-align: right; font-weight: bold;"><a href="calindex.php?b=<?php echo $prev; ?>"><<</a></div>
      <h1 style="float: left; text-align: center; width: 200px;"><?php echo $title; ?></h1>
      <div style="float: left; text-align: left; font-weight: bold;"><a href="calindex.php?b=<?php echo $next; ?>">>></a></div>
      <div style="clear: both;"></div>
      
      <?php
      if (!empty($_GET['b'])) {
        $TheB = "&b=" . $_GET['b'];
      }
      
      $result = $mysqli->query("SELECT * FROM calendar WHERE date >= '$first_day' AND date <= '$last_day' ORDER BY date ASC");
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "<a href=\"caledit.php?id=" . $row['id'] . "$TheB\">edit</a> | 
        <a href=\"caldb.php?a=delete&id=" . $row['id'] . "$TheB\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\">delete</a> &nbsp; &nbsp; <strong>" . date("M d", $row['date']) . "</strong> " . $row['event'] . "<br>\n";
      }
      ?>
    </div>
    
    <div style="clear: both;"></div>
    
  </div> <!-- END content-sides -->
  <div id="content-bot"></div>
</div> <!-- END wrap -->

</body>
</html>