<?php
setcookie("LRadmin", "", time() - 3600, "/"); // delete cookie;

header( "Location: index.php" );
?>