<?php
//configuration for our PHP server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('client_id', 'a8d1c01a9eb14ad0b9abf3a4e384ccee');
define('client_secret', '976c493b03464f358c136a20015503d5');
define('redirectURL', 'http://localhost:8888/LuisApi/index.php');
define('ImageDirectory', 'pics/');
?>

<!--CLIENT INFO
CLIENT ID
a8d1c01a9eb14ad0b9abf3a4e384ccee
CLIENT SECRET
976c493b03464f358c136a20015503d5
WEBSITE URL
http://localhost:8888/LuisApi/index.php
REDIRECT URI
http://localhost:8888/LuisApi/index.php -->
