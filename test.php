<?php

print("aaa");

require_once "twitteroauth-1.0.1/autoload.php";  
 
// ツイートの実行               
$tweet = "てすとのつぶやきです。";
$twObj = new TwitterOAuth("hhYBDvLE2ka5j0a4mEnxasi69","OHW2h9nMEFbtmsnXUsZudfYDIfWT2bE7JK2ts5CmBdNiOCLzkx","2993483719-zTGnAgAB7gI3JlDrfC68cXZ7fB1m214BIZptEzq","xTh1jqDNsIYdvegAMZsgWUZodOlCIhyB4ZldDmVxJRoFg");
$result = $twObj->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$tweet));

print($result);

?>