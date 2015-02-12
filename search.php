<?php
$PageTitle = "Search Results";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
$search = trim($_REQUEST['search']);

// Conferences and contributors...do contributors first
$confs = array();
$result = mysql_query("SELECT * FROM contributors WHERE title LIKE '%" . $search . "%' OR abstract LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    $confs[] = $row['conference'];
  }
}

// Now search conferences and merge with contributors results
echo "<strong>Conferences</strong><br>\n";
$result = mysql_query("SELECT * FROM conference WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    $confs[] = $row['id'];
  }
  
  // Get rid of duplicates
  $conf = array_unique($confs);
  
  // Do a query for each result and format output
  foreach ($conf as $con) {
    $cresult = mysql_query("SELECT * FROM conference WHERE id = '" . $con . "'");
    $crow = mysql_fetch_array($cresult);
    
    $datestr = date("M d", $crow['startdate']);
    if (($crow['enddate'] == "") || ($crow['enddate'] == $crow['startdate'])) {
      $datestr .= ", " . date("Y", $crow['startdate']);
    } else {
      if (date("Y", $crow['startdate']) != date("Y", $crow['enddate'])) { $datestr .= ", " . date("Y", $crow['startdate']); }
      $datestr .= (date("M", $crow['startdate']) == date("M", $crow['enddate'])) ? "-" . date("d, Y", $crow['enddate']) : "-" . date("M d, Y", $crow['enddate']);
    }
    
    echo "<a href=\"conference.php?" . $crow['id'] . "\">" . $datestr . " - " . $crow['title'] . "</a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Courses
echo "<br><strong>Courses</strong><br>\n";
$result = mysql_query("SELECT * FROM courses WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<a href=\"course.php?" . $row['id'] . "\">" . $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Lectures
echo "<br><strong>Lectures</strong><br>\n";
$result = mysql_query("SELECT * FROM lectures WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<a href=\"lectures.php?" . $row['id'] . "\">" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Articles
echo "<br><strong>Articles</strong><br>\n";
$result = mysql_query("SELECT * FROM articles WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<a href=\"articles.php?" . $row['id'] . "\">" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Books
echo "<br><strong>Books</strong><br>\n";
$result = mysql_query("SELECT * FROM books WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<a href=\"book.php?" . $row['id'] . "\">" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Dissertations
echo "<br><strong>Dissertations</strong><br>\n";
$result = mysql_query("SELECT * FROM dissertations WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    echo "<a href=\"dissertations.php?" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Journals
echo "<br><strong>Journals</strong><br>\n";
$result = mysql_query("SELECT * FROM journals WHERE description LIKE '%" . $search . "%'");
if (mysql_num_rows($result) != 0) {
  while($row = mysql_fetch_array($result)) {
    //echo "<a href=\"journals.php?" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
    $document = file_get_contents("pdf/journals/" . $row['file1']);
    $pdfauthor = (preg_match_all("/\/Author\((.*?)\)/",$document,$match)) ? end(end($match)) : "";
    $pdftitle = (preg_match_all("/\/Title\((.*?)\)/",$document,$match)) ? end(end($match)) : $row['file1'];
    $pdf = ($pdfauthor != "" && $pdftitle != $row['file1']) ? $pdfauthor . ", <em>" . $pdftitle . "</em>" : "<em>" . $pdftitle . "</em>";
    echo "<a href=\"pdf/journals/" . $row['file1'] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> " . $pdf . "</a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}
?>

<?php include "footer.php"; ?>