<?php

if ($_POST) {
  $text = preg_replace("/\s{2}/i","\n",$_POST['text']);
  file_put_contents("mac_log.csv",$text);
  header ("Location: ".$_SERVER['PHP_SELF']."?saved=true");
  exit;
}
$text = htmlspecialchars(file_get_contents("mac_log.csv"));

if($_GET['saved'] == "true") {
  $message = "Saved successfully.";
}


?><html>
<head>
  <style type="text/css">
    textarea { height: 600px; width: 400px; }
  </style>
</head>
<body>
<span class="message">
  <?php echo $message; ?>
</span>
<form method="POST">
<textarea name="text"><?php echo $text; ?></textarea>
<input type="submit" value="Save">
</form>
</body>
</html>
