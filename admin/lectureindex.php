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
  <title>Lonergan Resource Administration | Lectures</title>
  <link rel="shortcut icon" href="../images/favicon.ico">
  <link rel="stylesheet" href="../inc/lr2009.css" type="text/css" media="screen,print">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <style type="text/css">
    #contact LABEL {
      width: 70px;
    }
    #contact INPUT {
      width: 325px;
    }
  </style>
  <!--[if lt IE 7]>
    <script src="../inc/IE8.js" type="text/javascript"></script>
  <![endif]-->
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
      <h1>Add Lecture</h1>
      
      <form action="lecturedb.php?a=add" method="POST">
        <div id="contact">
          Do not display publically <input type="checkbox" name="display" value="no" style="vertical-align: middle; width: auto;"><br>
          <br>

          <label>Date</label> <input type="text" name="date"><br>
          <br>
          <label>Presenter</label> <input type="text" name="name"><br>
          <br>
          <label>Title</label> <input type="text" name="title"><br>
          <br>
          <label>Location</label> <input type="text" name="location"><br>
          <br>
          <label>Description</label><br>
          <textarea name="description" rows="6" cols="35" style="width: 400px; height: 300px;"></textarea><br>
          <br>
          <label>File 1</label> <input type="text" name="file1"><br>
          <br>
          <label>File 2</label> <input type="text" name="file2"><br>
          <br>
          <label>File 3</label> <input type="text" name="file3"><br>
          <br>
          <label>File 4</label> <input type="text" name="file4"><br>
          <br>
          <label>File 5</label> <input type="text" name="file5"><br>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>
    
    <div style="float: right; width: 50%;">
      <h1>Available Lectures</h1>
      
      <?php
      $result = mysql_query("SELECT * FROM lectures ORDER BY name+0 ASC");
      while($row = mysql_fetch_array($result)) {
        echo "
        <div style=\"margin-left: 90px;\">
          <div style=\"float: left; width: 90px; margin-left: -90px; font-size: 120%;\">
            <a href=\"lectureedit.php?id=" . $row['id'] . "\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
            <a href=\"lecturedb.php?a=delete&id=" . $row['id'] . "\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\" title=\"Delete\"><i class=\"fa fa-trash-o\"></i></a> &nbsp;
            <a href=\"../lectures.php?" . $row['id'] . "\" target=\"new\" title=\"View\"><i class=\"fa fa-eye\"></i></a>
          </div>
          " . $row['name'] . ", <em>" . $row['title'] . "</em>
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