<?php

$message = "";
  if(isset($_POST['submit'])) {

    $mac = csv_filter($_POST['macaddress']);
    $name = csv_filter($_POST['name']);

    if($mac != "" && $name != null) {
      if(is_mac($mac)) {
        file_put_contents("mac_log.csv","$mac,$name\n",FILE_APPEND);
        $message = "Registered, thanks! It might take a few minutes for your name to show up.";
      }
      else {
        $message = "The MAC address doesn't look right. MAC addresses look like this: 00:1a:2b:3c:4d:5e";
      }
    }
    else {
      $message = "Please enter a MAC address and name.";
    }

  }


  function csv_filter($value) {
    return preg_replace('/[^a-z0-9:]/i','',$value);
  }

  function is_mac($mac) {
    if(preg_match('/^([0-9a-f]{2}([:-]|$)){6}$/i',$mac) > 0){
    return true;}
    else { return false; }  
  }

$arp_found = false;

  function arp_lookup($ip) {
    global $arp_found;

    $arp = shell_exec("/usr/sbin/arp -a | grep $ip");
    preg_match('/at ([0-9a-f]{2}[: ]){6}/i',$arp,$matches);
    if(sizeof($matches) > 0) {
      $mac = split(" ",$matches[0]);
      $arp_found = true;
      return $mac[1];
    }
    else {
      $arp_found = false;
      return "";
    }
  }
include('header-inc.php');
?>
  <span class="message">
  <?php echo $message; ?>
  </span>

  <div id="content">
    <h2>Register Your Device</h2>
    <div class="caption">
      <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <h3>Your computer or mobile device's MAC address can be found under your network info!</h3>
        <table>
          <tr><td><label for="name">Your Name:</label></td><td><input type="text" id="name" name="name" /></td></tr>
          <tr><td><label for="macaddress">MAC Address:</label></td><td><input type="text" id="macaddress" name="macaddress" value="<?php echo arp_lookup($_SERVER['REMOTE_ADDR']); ?>" />
            <span id="autodetect"><?php if($arp_found) { echo "(Autodetected MAC from IP address ".$_SERVER['REMOTE_ADDR'].")"; } ?></span>
          </td></tr>
        </table>
        <input type="submit" id="submit" name="submit" value="Register" />
      </form>
    </div>
  </div>

</div>
</body>
</html>

