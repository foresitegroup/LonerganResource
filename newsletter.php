<?php
$PageTitle = "Newsletter Sign-Up";
include "header.php";
?>


<script type="text/javascript">
  <!--
  function checkform (form) {
    if (form.email.value == "") {
      alert('E-mail required.');
      form.email.focus();
      return false ;
    }
    return true ;
  }
  //-->
</script>

<?php
if (isset($_POST['submit'])) {
  include "inc/dbconfig.php";
  mysql_query("INSERT INTO newsletter (email) VALUES ('" . $_POST['email'] . "')");
  
  echo "<h1>You are now subscribed</h1>\n\nThank you for your interest in Lonergan Resource.";
} else {
?>

<h1><?php echo $PageTitle; ?></h1>

Please include your email address in the space provided to receive periodic announcements, new material offerings and news.<br>
<br>

<form action="newsletter.php" method="POST" onSubmit="return checkform(this)">
  <div id="contact">
    <label>Email</label> <input type="text" name="email"><br>
    <br>
    <input type="submit" name="submit" value="Signup" class="button">
  </div>
</form>

<br>
<br>
<a href="privacy.php">Internet Privacy Policy</a>
<?php } ?>

<?php include "footer.php"; ?>