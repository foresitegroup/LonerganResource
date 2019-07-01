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
  <title>Lonergan Resource Administration | Edit Dissertation</title>
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
  
    <h1>Edit Dissertation</h1>
      
    <?php
    $result = $mysqli->query("SELECT * FROM dissertations WHERE id = '" . $_GET['id'] . "'");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    ?>
    
    <form action="dissdb.php?a=edit" method="POST">
      <div id="contact">
        Do not display publically <input type="checkbox" name="display" value="no" style="vertical-align: middle; width: auto;"<?php if($row['display'] != "") echo " checked"; ?>><br>
        <br>
        
        <label>Author</label> <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
        <br>
        <label>Title</label> <input type="text" name="title" value="<?php echo $row['title']; ?>"><br>
        <br>
        <label>Description</label><br>
        <textarea name="description" rows="6" cols="35" style="width: 400px; height: 300px;"><?php echo $row['description']; ?></textarea><br>
        <br>
        <label>File</label> <input type="text" name="file1" value="<?php echo $row['file1']; ?>"><br>
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