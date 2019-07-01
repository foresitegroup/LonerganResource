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
  <title>Lonergan Resource Administration | Calendar Event Edit</title>
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
  
    <h1>Edit Calendar Event</h1>
    
    <?php
    $result = $mysqli->query("SELECT * FROM calendar WHERE id = '" . $_GET['id'] . "'");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    ?>
    
    <form action="caldb.php?a=edit<?php if (!empty($_GET['b'])) { echo "&b=" . $_GET['b']; } ?>" method="POST" onSubmit="return checkform(this)">
      <div id="contact">
        <label>Date</label> <input type="text" name="date" size="8" class="dateformat-m-sl-d-sl-Y fill-grid" id="dateformat" style="width: 80px;" value="<?php echo date("m/d/Y",$row['date']); ?>"><br>
        <br>
        <label>Event</label> <input type="text" name="event" value="<?php echo $row['event']; ?>"><br>
        <br>
        <label>Description</label><br>
        <textarea name="description" rows="6" cols="35" style="width: 360px; height: 100px;"><?php echo $row['description']; ?></textarea><br>
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