<?php
//configuration for our PHP server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('clientID', 'a8d1c01a9eb14ad0b9abf3a4e384ccee');
define('client_secret', '976c493b03464f358c136a20015503d5');
define('redirectURI', 'http://localhost:8888/LuisApi/index.php');
define('ImageDirectory', 'pics/');
?>

<!DOCTYPE html>
<html>
  <head>
    <title></title>
  </head>
  <body>
    <!-- Creating a Login for people to go and give approval for our web app to access their Instagram Account
    After getting approval we are now going to habe the information so that we can play with it.
    -->
    <a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI?>&response_type=code">LOGIN</a>
  </body>
</html>
