<?php
include "../inc/dbconfig.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <META http-equiv="Content-Type" content="text/html;charset=utf-8" >
  <META http-equiv="pragma" content="no-cache">
  <META name="language" content="en">
  <title>Pat Administration - Press</title>
  <link rel="shortcut icon" href="http://www.patmccurdy.com/favicon.ico">
  <link rel="stylesheet" href="../inc/pat2008.css" type="text/css" media="screen">
</head>
<body>

<div style="width: 90%; margin: 20px auto;">

  <div style="float: left; width: 45%;">
    <h1>Add Article</h1>
    
    <form action="pressdb.php?a=add" method="POST" style="width: 400px;">
      <strong>Date:</strong> <input type="text" name="date" style="width: 400px;"><br>
      <br>
      <strong>Source:</strong> <input type="text" name="source" style="width: 400px;"><br>
      <br>
      <strong>Source URL:</strong> <input type="text" name="source_url" style="width: 400px;"><br>
      <br>
      <strong>Title:</strong> <input type="text" name="title" style="width: 400px;"><br>
      <br>
      <strong>Subtitle:</strong> <input type="text" name="subtitle" style="width: 400px;"><br>
      <br>
      <strong>Author:</strong> <input type="text" name="author" style="width: 400px;"><br>
      <br>
      <strong>Text:</strong><br>
      <textarea rows="15" cols="43" name="text" style="width: 400px;"></textarea><br>
      <br>
      <input type="submit" value="Add" style="display: block; margin: 0 auto;">
    </form>
  </div>
  
  <div style="float: right; width: 54%;">
    <h1>Articles</h1>
    
    <?php
    $result = mysql_query("SELECT * FROM press ORDER BY sort_date DESC");
    
    while($row = mysql_fetch_array($result)) {
      echo "
      <div style=\"margin-left: 75px;\">
        <div style=\"float: left; width: 75px; margin-left: -75px;\">
          <a href=\"pressedit.php?id=" . $row['id'] . "\">edit</a> | 
          <a href=\"pressdb.php?a=delete&id=" . $row['id'] . "\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\">delete</a>
        </div>
        " . $row['date'] . " - <em>" . $row['title'] . "</em>
      </div>
      ";
    }
    ?>
  </div>
  
  <div style="clear: both;"></div>

</div>

</body>
</html>