<?php
$PageTitle = "Contact";
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
    if (form.comment.value == "") {
      alert('Comment required.');
      form.comment.focus();
      return false ;
    }
    return true ;
  }
  //-->
</script>

<?php
if (isset($_POST['submit'])) {
  $SendTo = "bdoranca@yahoo.ca";
  $Subject = "Comment From Lonergan Resource";
  $From = "From: Contact Form <contactform@lonerganresource.com>\r\n";
  $From .= "Reply-To: " . $_POST['email'] . "\r\n";
  
  $Message = "Comment from " . $_POST['email'] . "\n\n";
  
  $Message .= $_POST['comment'] . "\n";
  
  $Message = stripslashes($Message);
  
  mail($SendTo, $Subject, $Message, $From);
  
  echo "<h1>Your message has been sent!</h1>\n\nThank you for your interest in Lonergan Resource.  You will be contacted shortly.";
} else {
?>

<h1><?php echo $PageTitle; ?></h1>

To contact the Lonergan Resource please use the contact form provided below. The information you send us will not be shared with any third party.<br>
<br>

<form action="contact.php" method="POST" onSubmit="return checkform(this)">
  <div id="contact">
    <label>Your Comments</label><br>
    <textarea name="comment" rows="6" cols="35"></textarea><br>
    <br>
    <label>Email</label><br>
    <input type="text" name="email"><br>
    <br>
    <input type="submit" name="submit" value="Send" class="button">
  </div>
</form>

<br>
<br>

If you wish to contribute to the Marquette Lonergan Project, visit the <a href="https://muconnect.marquette.edu/SSLPage.aspx?pid=191">Marquette University giving site</a>. Click on the link, and then on the drop down table click on Other and then fill in the space with Lonergan Fund.<br>
<br>
Alternatively, you may make a check payable to Marquette University and send it to the following address:
<div style="padding-left: 30px;">
  Robert M. Doran, S.J.<br>
  Theology Department<br>
  Coughlin Hall 100<br>
  Marquette University<br>
  Milwaukee, WI 53201-1881 USA
</div>
<br>

You will be sent a receipt for tax purposes.<br>
<br>
<a href="privacy.php">Internet Privacy Policy</a>

<?php } ?>

<?php include "footer.php"; ?>