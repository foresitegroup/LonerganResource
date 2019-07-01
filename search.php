<?php
$PageTitle = "Search Results";
include "header.php";
?>

<h1><?php echo $PageTitle; ?></h1>

<?php
$search = trim($_REQUEST['search']);

// Conferences and contributors...do contributors first
$confs = array();
$result = $mysqli->query("SELECT * FROM contributors WHERE title LIKE '%" . $search . "%' OR abstract LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $confs[] = $row['conference'];
  }
}

// Now search conferences and merge with contributors results
echo "<strong>Conferences</strong><br>\n";
$result = $mysqli->query("SELECT * FROM conference WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $confs[] = $row['id'];
  }
  
  // Get rid of duplicates
  $conf = array_unique($confs);
  
  // Do a query for each result and format output
  foreach ($conf as $con) {
    $cresult = $mysqli->query("SELECT * FROM conference WHERE id = '" . $con . "'");
    $crow = $cresult->fetch_array(MYSQLI_ASSOC);
    
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
$result = $mysqli->query("SELECT * FROM courses WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<a href=\"course.php?" . $row['id'] . "\">" . $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Lectures
echo "<br><strong>Lectures</strong><br>\n";
$result = $mysqli->query("SELECT * FROM lectures WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<a href=\"lectures.php?" . $row['id'] . "\">" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Articles
echo "<br><strong>Articles</strong><br>\n";
$result = $mysqli->query("SELECT * FROM articles WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<a href=\"articles.php?" . $row['id'] . "\">" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Books
echo "<br><strong>Books</strong><br>\n";
$result = $mysqli->query("SELECT * FROM books WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<a href=\"book.php?" . $row['id'] . "\">" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Dissertations
echo "<br><strong>Dissertations</strong><br>\n";
$result = $mysqli->query("SELECT * FROM dissertations WHERE title LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    echo "<a href=\"dissertations.php?" . $row['name'] . ", <em>" . $row['title'] . "</em></a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}

// Journals
echo "<br><strong>Journals</strong><br>\n";
$result = $mysqli->query("SELECT * FROM journals WHERE description LIKE '%" . $search . "%'");
if ($result->num_rows != 0) {
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $document = file_get_contents("pdf/journals/" . $row['file1']);
    
    preg_match_all("/\/Title\((.*?)\)/",$document,$tarr);
    $tarr_last = end($tarr);
    $pdftitle = end($tarr_last);
    if ($pdftitle == "") $pdftitle = $row['file1'];

    $pdf = "<em>" . $pdftitle . "</em>";

    echo "<a href=\"pdf/journals/" . $row['file1'] . "\"><img src=\"images/pdf.gif\" alt=\"PDF\"> " . $pdf . "</a><br>\n";
  }
} else {
  echo "No results.<br>\n";
}
?>

<?php include "footer.php"; ?>