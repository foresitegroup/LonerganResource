<?php
include("inc/dbconfig.php");

$PageTitle = "Books";
include "header.php";
?>

<h1><?php echo $PageTitle ?></h1>

<ul style="margin: 0 0 0 0.5em; padding: 0 0 0 0.5em;">
<?php
$result = $mysqli->query("SELECT * FROM books WHERE display = '' ORDER BY name,date,title");
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
  echo "<li style=\"padding-bottom: 5px;\"><a href=\"book.php?" . $row['id'] . "\">" . $row['name'] . ", " . $row['date'] . ", <em>" . $row['title'] . "</em></a></li>\n";
}
?>
</ul>

<?php include "footer.php"; ?>