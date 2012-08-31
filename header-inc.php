<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<?php if(isset($auto_reload)) { ?>
  <script type="text/javascript">
    function reload() {
      window.location.reload()
    }
    function pageLoad() {
      setInterval ( "reload()", 30000 );
    }
  </script>
<?php } ?>
  <style type="text/css">
    #autodetect { display: block; color: #666; }
    .macaddr { color: #666; }
  </style>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
</head>

<body <?php if(isset($auto_reload)){ ?>onLoad="pageLoad()"<?php } ?>>
<div id="header">
  <div id="header_middle">
    <img src="/static/images/logo.png" />
    <div id="header_buttons">
      <h2>Local Network</h2>
      <p>See if there are people at the space!<br/> 
      If the feed is broken, please contact <a href="#">someone</a>.</p>
      <p>Nobody here? Check the <a href="#">Website</a>.</p>
    </div>
  </div>
  <div id="header_menu">
    <a href="/">See Who's Here</a>
    <a href="/associate.php">Register your device!</a>
  </div>
</div>
<div id="content">
