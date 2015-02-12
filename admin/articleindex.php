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
  <title>Lonergan Resource Administration | Articles</title>
  <link rel="shortcut icon" href="../images/favicon.ico">
  <link rel="stylesheet" href="../inc/lr2009.css" type="text/css" media="screen,print">
  <style type="text/css">
    #contact LABEL {
      width: 50px;
    }
    #contact INPUT {
      width: 345px;
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
      <h1>Add Article</h1>
      
      <form action="articledb.php?a=add" method="POST">
        <div id="contact">
          <label>Author</label> <input type="text" name="name"><br>
          <br>
          <label>Title</label> <input type="text" name="title"><br>
          <br>
          <label>Description</label><br>
          <textarea name="description" rows="6" cols="35" style="width: 400px; height: 300px;"></textarea><br>
          <br>
          <label>File</label> <input type="text" name="file1"><br>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>
    
    <div style="float: right; width: 50%;">
      <h1>Available Articles</h1>
      
      <?php
      $result = mysql_query("SELECT * FROM articles ORDER BY name ASC");
      while($row = mysql_fetch_array($result)) {
        echo "
        <div style=\"margin-left: 90px;\">
          <div style=\"float: left; width: 90px; margin-left: -90px;\">
            <a href=\"articleedit.php?id=" . $row['id'] . "\">edit</a> | 
            <a href=\"articledb.php?a=delete&id=" . $row['id'] . "\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\">delete</a>
          </div>
          " . $row['name'] . ", <em>" . $row['title'] . "</em>
        </div>
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