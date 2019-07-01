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
  <title>Lonergan Resource Administration | Links</title>
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
      <h1>Add Link</h1>
      
      <form action="linksdb.php?a=add" method="POST">
        <div id="contact">
          <label>Title</label> <input type="text" name="title"><br>
          <br>
          <label>Link</label> <input type="text" name="link"><br>
          <br>
          <label>Description</label><br>
          <textarea name="description" rows="6" cols="6" style="width: 400px; height: 100px;"></textarea><br>
          <br>
          <input type="submit" name="submit" value="Add" class="button">
        </div>
      </form>
    </div>
    
    <div style="float: right; width: 50%;">
      <h1>Available Links</h1>
      
      <?php
      $result = $mysqli->query("SELECT * FROM links ORDER BY sort+0 ASC");
      
      $rownum = 1;
      
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        ?>
        <div style="margin: 0 0 10px 120px;">
          <div style="float: left; width: 120px; margin-left: -120px;">
            <a href="linksedit.php?id=<?php echo $row['id']; ?>">edit</a> | 
            <a href="linksdb.php?a=delete&id=<?php echo $row['id']; ?>" onClick="return(confirm('Are you sure you want to delete this record?'));">delete</a> &nbsp;
            
            <?php
            echo ($rownum != "1") ? "<a href=\"linksdb.php?id=" . $row['id'] . "&s=" . $row['sort'] . "&a=sort&d=u\"><img src=\"images/move-u.png\" alt=\"^\" title=\"Move up\"></a>" : "<img src=\"images/blank.gif\" alt=\"\" style=\"width: 12px; height: 10px;\">";
            echo "&nbsp;";
            echo ($rownum != $result->num_rows) ? "<a href=\"linksdb.php?id=" . $row['id'] . "&s=" . $row['sort'] . "&a=sort&d=d\"><img src=\"images/move-d.png\" alt=\"v\" title=\"Move down\"></a>" : "<img src=\"images/blank.gif\" alt=\"\" style=\"width: 12px; height: 10px;\">";
            ?>
            
          </div>
          
          <a href="<?php echo $row['link']; ?>"><?php echo $row['title']; ?></a>
          
          <?php if ($row['description'] != "") echo "<br><div style=\"font-size: 80%;\">" . $row['description'] . "</div>\n"; ?>
          
        </div>
        
        <?php
        $rownum++;
      }
      ?>
    </div>
    
    <div style="clear: both;"></div>
    
  </div> <!-- END content-sides -->
  <div id="content-bot"></div>
</div> <!-- END wrap -->

</body>
</html>