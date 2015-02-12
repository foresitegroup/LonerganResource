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
  <title>Lonergan Resource Administration | Edit Journal</title>
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
  
    <h1>Edit Journal</h1>
      
    <?php
    $result = mysql_query("SELECT * FROM journals WHERE id = '" . $_GET['id'] . "'");
    $row = mysql_fetch_array($result);
    ?>
    
    <form action="journaldb.php?a=edit" method="POST">
      <div id="contact">
        <label>Title</label>
        <select name="titleid" style="width: 345px;">
          <option value="">Select...</option>
          <?php
          $tresult = mysql_query("SELECT * FROM journaltitles ORDER BY title ASC");
          while($trow = mysql_fetch_array($tresult)) {
            echo "<option value=\"" . $trow['id'] . "\"";
            if ($trow['id'] == $row['titleid']) echo " selected";
            echo ">" . $trow['title'] . "</option>\n";
          }
          ?>
        </select><br>
        <br>
        <label style="margin-left: 50px; width: 55px;">Volume</label> <input type="text" name="volume" style="width: 30px;" value="<?php echo $row['volume']; ?>">
        <label style="margin-left: 40px; width: 60px;">Number</label> <input type="text" name="number" style="width: 30px;" value="<?php echo $row['number']; ?>"><br>
        <br>
        <label>Description</label><br>
        <textarea name="description" rows="6" cols="35" style="width: 400px; height: 300px;"><?php echo $row['description']; ?></textarea><br>
        <br>
        <label>File</label>
        <select name="file1" style="width: 345px;">
          <option value="">Select...</option>
          <?php
          $dir = opendir("../pdf/journals");
          while (false != ($file = readdir($dir))) { if (($file != ".") and ($file != "..")) { $files[] = $file; } }
          closedir($dir);
          natcasesort($files);
          
          foreach ($files as $file) {
            echo "<option value=\"$file\"";
            if ($file == $row['file1']) echo " selected";
            echo ">$file</option>\n";
          }
          ?>
        </select><br>
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