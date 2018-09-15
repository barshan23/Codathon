<?php
require_once 'core/init.php';

$curl = curl_init();

//curl -sX POST api.hackerrank.com/checker/submission.json -d 'source=print 1&lang=5&testcases=["1"]&api_key=yourapikeyfoobarbaz'



$api_key = "hackerrank|560736-1840|00c7057e5f357723c9d843707160a49392fdb0e0";

$source = "print 'Meow'";

$curlConfig = array(
    CURLOPT_URL            => "api.hackerrank.com/checker/submission.json",
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => array(
        'source' => $source,
        'lang' => "5",
        'testcases' => "[\"1\"]",
        'api_key' => $api_key,
        'wait' => "true",
        'format' => "json"
    )
);
curl_setopt_array($curl, $curlConfig);
$result = curl_exec($curl);
curl_close($curl);


//http_get_contents($q);

//var_dump($result);
?>




