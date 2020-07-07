<?php
function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

session_start();

require_once 'common.php';
require_once './twitteroauth-1.0.1/autoload.php';//この辺りはディレクトリ設定によって適宜変えてください

use Abraham\TwitterOAuth\TwitterOAuth;

//セッションに入れておいたさっきの配列
$access_token = $_SESSION['access_token'];

//OAuthトークンとシークレットも使って TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
//var_dump($connection);


//$home = $connection->get('statuses/home_timeline', array('count' => 10));
//$connection->post('statuses/update', ["status" => "Hello world"]);
//$home = $connection->get("search/tweets", ["q" => "#春から静大","count"=>"120"]); //,"until"=>"2019-04-03"

//$home=(array)$home;

print(CONSUMER_KEY."\n".CONSUMER_SECRET."\n".$access_token['oauth_token']."\n".$access_token['oauth_token_secret']);

$tweet = "てすとのつぶやきです。".rand(0,99);
$result = $connection->post("statuses/update",["status"=>$tweet]);
/*
$i=0;
for (; $i < count($home["statuses"]); $i++) { 
    $tweet=(array)$home["statuses"][$i];
    $user=(array)$tweet["user"];
    if(!startsWith($tweet["text"],"RT")){ //RTでなかったら
        echo"<div>";
        print("名前：".$user["name"]."　ID：".$user["screen_name"]."\n");
        print($tweet["text"]);
        $relation=$connection->get("friendships/show", ["source_screen_name"=>"kurvan1112","target_screen_name" => $user["screen_name"]]);
        $relation=(array)$relation;
        $relation=(array)$relation["relationship"];
        $relation=(array)$relation["source"];
        if($relation["following"]){ //フォロー済みだったら
            print('<font color="#ff0000">フォロー済みです</font>');
        }else{
            $connection->post("friendships/create", ["screen_name" => $user["screen_name"],"follow"=>"false"]);
            print('<font color="#0000ff">フォローしました！</font>');
        }
        echo"</div><br>";        
    }    
}
print("検索結果総数：".$i);*/
?>