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
  <title>Lonergan Resource Administration | Journals</title>
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
    
    <div style="text-align: center;">
      <a href="journaltitleindex.php">Add / Edit Journal Titles</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
      <a href="journalexport.php">Export Journals</a>
    </div>
    <br>
    
    <div style="float: left; width: 50%;">
      <h1>Add Journal</h1>
      
      <form action="journaldb.php?a=add" method="POST">
        <div id="contact">
          <!-- Do not display publically <input type="checkbox" name="display" value="no" style="vertical-align: middle; width: auto;"><br>
          <br> -->

          <label>Title</label>
          <select name="titleid" style="width: 345px;">
            <option value="">Select...</option>
            <?php
            $tresult = $mysqli->query("SELECT * FROM journaltitles ORDER BY title ASC");
            while($trow = $tresult->fetch_array(MYSQLI_ASSOC)) {
              echo "<option value=\"" . $trow['id'] . "\">" . $trow['title'] . "</option>\n";
            }
            ?>
          </select><br>
          <br>
          <label style="margin-left: 50px; width: 55px;">Volume</label> <input type="text" name="volume" style="width: 30px;">
          <label style="margin-left: 40px; width: 60px;">Number</label> <input type="text" name="number" style="width: 30px;"><br>
          <br>
          <label>Description</label><br>
          <textarea name="description" rows="6" cols="35" style="width: 400px; height: 300px;"></textarea><br>
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
              echo "<option value=\"$file\">$file</option>\n";
            }
            ?>
          </select><br>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>
    
    <div style="float: right; width: 50%;">
      <h1>Available Journals</h1>
      
      <?php
      //$result = $mysqli->query("SELECT * FROM journals JOIN journaltitles ON journals.titleid = journaltitles.id ORDER BY title, volume+0, number+0 ASC");
      $result = $mysqli->query("SELECT * FROM journaltitles,journals WHERE journals.titleid = journaltitles.id ORDER BY title, volume+0, number+0 ASC");
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "
        <div style=\"margin-left: 90px;\">
          <div style=\"float: left; width: 90px; margin-left: -90px; font-size: 120%;\">
            <a href=\"journaledit.php?id=" . $row['id'] . "\" title=\"Edit\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
            <a href=\"journaldb.php?a=delete&id=" . $row['id'] . "\" onClick=\"return(confirm('Are you sure you want to delete this record?'));\" title=\"Delete\"><i class=\"fa fa-trash-o\"></i></a> &nbsp;
            <a href=\"../journals.php?" . $row['id'] . "\" target=\"new\" title=\"View\"><i class=\"fa fa-eye\"></i></a>
          </div>";
          
          echo "<em>" . $row['title'] . "</em>";
          
          if ($row['volume'] != "" || $row['number'] != "") {
            echo ",";
            if ($row['volume'] != "") echo " Vol. " . $row['volume'];
            if ($row['volume'] != "" && $row['number'] != "") echo ",";
            if ($row['number'] != "") echo " No. " . $row['number'];
          }

          if (!empty($row['display'])) echo "<br><em>[Not displayed publically]</em>";
        echo "</div><br>\n";
      }
      ?>
    </div>
    
    <div style="clear: both;"></div>
    
  </div> <!-- END content-sides -->
  <div id="content-bot"></div>
</div> <!-- END wrap -->

</body>
</html>