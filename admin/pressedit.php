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

<div style="width: 400px; margin: 20px auto;">

  <h1>Edit Article</h1>
    
  <?php
  $result = mysql_query("SELECT * FROM press WHERE id = '" . $_GET['id'] . "'");
  $row = mysql_fetch_array($result);
  ?>
  
  <form action="pressdb.php?a=edit" method="POST" style="width: 400px;">
    <strong>Date:</strong> <input type="text" name="date" value="<?php echo $row['date']; ?>" style="width: 400px;"><br>
    <br>
    <strong>Source:</strong> <input type="text" name="source" value="<?php echo $row['source']; ?>" style="width: 400px;"><br>
    <br>
    <strong>Source URL:</strong> <input type="text" name="source_url" value="<?php echo $row['source_url']; ?>" style="width: 400px;"><br>
    <br>
    <strong>Title:</strong> <input type="text" name="title" value="<?php echo $row['title']; ?>" style="width: 400px;"><br>
    <br>
    <strong>Subtitle:</strong> <input type="text" name="subtitle" value="<?php echo $row['subtitle']; ?>" style="width: 400px;"><br>
    <br>
    <strong>Author:</strong> <input type="text" name="author" value="<?php echo $row['author']; ?>" style="width: 400px;"><br>
    <br>
    <strong>Text:</strong><br>
    <textarea rows="15" cols="43" name="text" style="width: 400px;"><?php echo $row['text']; ?></textarea><br>
    <br>
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <input type="submit" value="Update" style="display: block; margin: 0 auto;">
  </form>
  
</div>

</body>
</html>