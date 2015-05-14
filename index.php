<?php
//configuration for our PHP server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('clientID', 'a8d1c01a9eb14ad0b9abf3a4e384ccee');
define('client_secret', '976c493b03464f358c136a20015503d5');
define('redirectURI', 'http://localhost/LuisApi/index.php');
define('ImageDirectory', 'pics/');

//function that is going to connect to Instagram
function connectionToInstagram($url){
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 2,
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


if (isset($_GET['code'])){
  $code = ($_GET['code']);
  $url = 'https://api.instagram.com/oauth/access_token';
  $access_token_settings = array('client_id' => clientID,
                                  'client_secret' => client_secret,
                                  'grant_type' => 'authorization_code',
                                  'redirect_uri' => redirectURI,
                                  'code' => $code
                                  );
//cURL is what we use in PHP, it's a library calls to other API'S
$curl = curl_init($url); //setting a cURL session and we put in $url because that's where we're getting the date from
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings); //setting the POSTFIELDS to the array setup that we created
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//setting it equal to 1 because we are getting strings back.
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//but in live work-production, we want to set this to true.

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result, true);
echo $result['user']['username'];
}
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
