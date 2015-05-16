<?php
		// Configuration for our PHP Server
		set_time_limit(0);
		ini_set('default_socket_timeout', 300);
		session_start();

		// Make constants using define.
		define('clientID','a8d1c01a9eb14ad0b9abf3a4e384ccee');
		define('clientSecret','976c493b03464f358c136a20015503d5');
		define('redirectURI', 'http://localhost/LuisApi/index.php');
		define('ImageDirectory', 'pics/');

		//function that is going ot connect ot instagram
		function connectToInstagram($url){
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_SSL_VERIFYHOST =>2,
				));
				$result = curl_exec($ch);
				curl_close($ch);
				return $result;
			}
		//function to get userID cuz userName denst allow us to get pictures
		function getUserID($userName){
			$url = 'https://api.instagram.com/v1/users/search?q=\"king_remus\"&client_id='.clientID;
			$instagramInfo = connectToInstagram($url);
			$results = json_decode($instagramInfo, true);
			return $results['data']['0']['id'];
		}
		function printImages($userID){
			$url = 'https://api.instagram.com/v1/users/'.$userID.'/media/recent?client_id='.clientID.'&count=333';
			$instagramInfo = connectToInstagram($url);
			$results = json_decode($instagramInfo, true);
			//parse though the information one by one
			foreach($results['data'] as $items){
				$image_url = $items['images']['low_resolution']['url'];//going to go through all of my results and givemyself back the url of those pictures because we want to save it in the PHP server
				echo '<img align="center" class="image-div" src=" '.$image_url.'"/><br/>';
				savePictures($image_url);
			}
		}
		//function to save image to server
		function savePictures($image_url){
			echo '<head>
							<link rel="stylesheet" href="css/main.css">
							<script src="js/snowstorm-min.js"></script>
					</head>';
			echo '<body class="body-class">';
			echo '<div>
							<a href="index.php" class="login-button"> Back To Login?</a><br/>
							<a href="pics" class="login-button"> Want To See Each Picture?</a>
						</div>';
			echo '<div>'.$image_url.'<br></div>';
			$filename = basename($image_url);//the file name is what we are storing. basename is the php built in methd that we are useing to store image_url
			echo '<div align="center" class="file-name-div">'.$filename.'<br></div>';
			echo '</body>';
			$destination = ImageDirectory.$filename;
			file_put_contents($destination, file_get_contents($image_url));
		}
		//isset function//
		if (isset($_GET['code'])){
			$code = $_GET['code'];
			$url = 'https://api.instagram.com/oauth/access_token';
			$access_token_settings = array('client_id' => clientID,
											'client_secret' => clientSecret,
											'grant_type' => 'authorization_code',
											'redirect_uri' => redirectURI,
											'code' => $code
											);
		//cURL is what  we se in php, it's a library calls to the other API's.
		$curl = curl_init($url); //setting a cURL session and we put in $url because that's where we are getting the data from
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);//setting the POSTFIELDS to the array setup that we created
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//setting it equal to 1 because we are gettting strongs back
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//but in live workd-prodution we want to set this to true
		// $user = 'clientID';
		$result = curl_exec($curl);
		curl_close($curl);
		$results = json_decode($result, true);
		$userName = $results['user']['username'];
		$userID = getUserID($userName);
		printImages($userID);
		}
		else{
		?>
		<!doctype html>
		<html>
			<head>
				<meta charset="utf-8">
				<meta name="description" content="">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title></title>
				<link rel="stylesheet" href="css/main.css">
				<script src="js/snowstorm-min.js"></script>
			<!-- 	<link rel="stylesheet" type="text/css" href="css/main.css"> -->
			</head>
		<body class="body-class">
		<!-- Creating a login for people to go and give approval for our web app to access their Instagram account
			After getting approval we are now going to have the information so that we can play with it
		-->
		<div align="center">
				<div class="login-button-div">
					<div class="login-button-other-div">
							<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID;?>&redirect_uri=<?php echo redirectURI;?>&response_type=code"class="login-button">Login!</a>
					</div>
				</div>
		</div>

		<script type="js/main.js"></script>
		</body>
</html>
<?php
}
 ?>
