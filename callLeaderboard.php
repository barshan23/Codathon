
<?php
// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/Codathon/leaderBoard.php");
//curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
curl_exec($ch);
echo "called";

// close cURL resource, and free up system resources
curl_close($ch);
?>
