<?php include_once "inc/dbconfig.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <META http-equiv="Content-Type" content="text/html;charset=utf-8">
  <META http-equiv="pragma" content="no-cache">
  <META http-equiv="imagetoolbar" content="no">
  <META name="language" content="en">
  <META name="author" content="Foresite Group">
  <META name="description" content="Lonergan Resource is a repository of secondary-source materials valuable for Lonergan Studies. To include major papers and articles on Lonergan, recordings of major lectures and conferences, and longer monographs republished from books or composed for this website.">
  <META name="keywords" content="Bernard Lonergan, Insight, Method in Theology, Lonergan, theology, philosophy, economics, consciousness, knowledge, systematic theology, cognitional theory, epistemology, metaphysics, functional specialties, method, macroeconomics, interiority, differentiation of consciousness, generalized empirical method, emergent probability, meaning, human good, values, religion, question of God, scientific method, historical method, hermeneutics, logic, Aquinas, Aristotle, Augustine, Newman, existentialism">
  <title>Lonergan Resource<?php if (isset($PageTitle)) echo " | " . $PageTitle; ?></title>
  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="stylesheet" href="inc/lr2009.css" type="text/css" media="screen,print">
  
  <!--[if lt IE 7]>
    <script src="inc/IE8.js" type="text/javascript"></script>
  <![endif]-->
  <script type="text/JavaScript">
    function borderheight() {
      var cHeight = document.getElementById('content-sides').offsetHeight - 68 + "px";
      document.getElementById('sidebar').style.height = cHeight;
      <?php if (!isset($PageTitle)) { ?>document.getElementById('main-mid').style.height = cHeight;<?php } ?>
    }
    function toggle(obj) {
      document.getElementById(obj).style.display = (document.getElementById(obj).style.display != 'none' ? 'none' : '' );
    }
  </script>
  
  <script type="text/javascript" src="inc/jquery-1.12.4.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("a[href^='http'], a[href$='.pdf']").not("[href*='" + window.location.host + "']").attr('target','_blank');
    });
  </script>
  
  <!-- BEGIN Google Analytics -->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-31808906-1', 'auto');
    ga('send', 'pageview');
  </script>
  <!-- END Google Analytics -->

  <!-- Global site tag (gtag.js) - Google Analytics (Greg) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159303635-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-159303635-1');
  </script>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-NPTG44D');</script>
  <!-- End Google Tag Manager -->
</head>
<body onLoad="borderheight()"<?php if (!isset($PageTitle)) { echo " id=\"main\""; } ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NPTG44D"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- BEGIN menubar -->
<div class="menubar-l"></div>
<div class="menubar-r"></div>
<div class="menubar-b"></div>
<div class="menubar-fl"></div>
<div id="logo-bg"><img src="images/background-logo<?php if (!isset($PageTitle)) { echo "-main"; } ?>.jpg" alt=""></div>
<!-- END menubar -->

<div id="wrap">
  <div id="header<?php if (!isset($PageTitle)) { echo "-main"; } ?>">
    <div id="top">
      <div id="topmenu">
        <a href="contact.php">contact</a>
        <a href=".">home</a>
        <a href="news.php">news &amp; events</a>
      </div> <!-- END topmenu -->
      
      <form action="search.php" method="POST">
        <div id="search">
          <input type="text" name="search" id="input" value="search resources" onClick="if(this.value=='search resources')this.value='';" onBlur="if(this.value=='')this.value='search resources';">
          <input type="image" name="Submit" src="images/search.jpg" id="button">
        </div> <!-- END search -->
      </form>
    </div> <!-- END top -->
    
    <a href="."><img src="images/logo.png" alt="Lonergan Resource" id="logo"></a>
    
    <div id="menu" style="position: relative;">
      <ul>
        <li><a href=".">home</a></li>
        <li><a href="about.php">about</a></li>
        <li><a href="#">events</a>
          <ul>
            <li><a href="conferences.php">Conferences &amp; Seminars</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="lectures.php">Lectures</a></li>
          </ul>
        </li>
        <li><a href="#">scholarly works</a>
          <ul>
            <li><a href="articles.php">Articles</a></li>
            <li><a href="books.php">Books</a></li>
            <li><a href="dissertations.php">Dissertations</a></li>
            <li><a href="journals.php">Journals</a></li>
          </ul>
        </li>
        <li><a href="links.php">links</a></li>
        <li><a href="contact.php">contact</a></li>
      </ul>
      
      <a href="http://www.marquette.edu" id="marquette"></a>
    </div>
    
    <div style="clear: both;"></div>
    
    <?php if (!isset($PageTitle)) { ?>
    <div id="header-text">
      <div class="headline">
        LONERGAN <div>RESOURCE</div>
      </div>
      <br>
      Lonergan Resource is a repository of secondary-source materials that could prove to be valuable for Lonergan Studies. It will include major papers and articles on Lonergan, recordings of major lectures and conferences, and longer monographs that are either republished from books or composed for this website itself. 
      <br><br>
      <a href="conferences.php" id="explore"></a>
    </div> <!-- END header-text -->
    <?php } ?>
  </div> <!-- END header -->
  
  <div id="content-top"></div>
  
  <div id="content-sides">
    <?php if (isset($PageTitle)) { echo "<div id=\"content\">"; } ?>
      