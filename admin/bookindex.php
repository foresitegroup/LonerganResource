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
  <title>Lonergan Resource Administration | Books</title>
  <link rel="shortcut icon" href="../images/favicon.ico">
  <link rel="stylesheet" href="../inc/lr2009.css" type="text/css" media="screen,print">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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

    <a href="bookexport.php" style="float: right;">Export Books</a>
    <div style="clear: both;"></div><br>
    
    <div style="float: left; width: 50%;">
      <h1>Add Book</h1>
      
      <form action="bookdb.php?a=add" method="POST">
        <div id="contact">
          Do not display publically <input type="checkbox" name="display" value="no" style="vertical-align: middle; width: auto;"><br>
          <br>

          <label>Date</label> <input type="text" name="date"><br>
          <br>
          <label>Author</label> <input type="text" name="name"><br>
          <br>
          <label>Title</label> <input type="text" name="title"><br>
          <br>
          <label>Description</label><br>
          <textarea name="description" rows="6" cols="35" style="width: 400px; height: 300px;"></textarea><br>
          <br>
          <div style="width: 400px; font-size: 80%;">
            Any MP3s or PDFs associated with this course will be attached automatically on the front end, provided they are placed in the correct directory.
          </div>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>
    
    <div style="float: right; width: 50%;">
      <h1>Available Book</h1>
      
      <?php
      $result = $mysqli->query("SELECT * FROM books ORDER BY name,date ASC");
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "
        <div style=\"margin-left: 90px;\">
          <div style=\"float: left; width: 90px; margin-left: -90px; font-size: 120%;\">
            <a href=\"bookedit.php?id=" . $row['id'] . "\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
            <a href=\"bookdb.php?a=delete&id=" . $row['id'] . "\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\" title=\"Delete\"><i class=\"fa fa-trash-o\"></i></a> &nbsp;
            <a href=\"../book.php?" . $row['id'] . "\" target=\"new\" title=\"View\"><i class=\"fa fa-eye\"></i></a>
          </div>
          " . $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em> <span style=\"font-size: 80%;\">(ID: " . $row['id'] . ")</span>
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