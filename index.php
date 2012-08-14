<?php
$auto_reload = true;
include('header-inc.php');


$result = http_parse_message(http_get("http://localhost/pamela/data.php"));
$result = preg_replace("/[\r|\n]/","",$result->body); // get rid of linebreaks

$decode = json_decode($result);
$decode = preg_replace("/^([0-9a-f]{2}([:]|$)){6}$/i",'{$0}',$decode);
sort($decode,SORT_STRING | SORT_FLAG_CASE);

$array = preg_grep("/^(?!\.)/",$decode);

echo "<h2>Who's here right now?</h2>";
echo "<ul>";
foreach($array as $entry) {
  if(substr($entry,0,1) == "{") {
    if($_GET['showmacs'] == "1") {
      echo "<li class='macaddr'>".$entry."</li>";
    }
  }
  else{
    echo "<li>".$entry."</li>";
  }
}
if($_GET['showmacs'] == "1") {
  echo "<li>&nbsp;<br/><a href=\"?showmacs=0\">Hide people who haven't registered yet</a>";
}
else {
  echo "<li>&nbsp;<br/><a href=\"?showmacs=1\">Show people who haven't registered yet</a>";
}
echo "</ul>";

?>
</div>
</body>
</html>
