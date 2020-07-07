<?php
//session_start();

require_once 'common.php';
require_once './twitteroauth-1.0.1/autoload.php';//この辺りはディレクトリ設定によって適宜変えてください

use Abraham\TwitterOAuth\TwitterOAuth;

//セッションに入れておいたさっきの配列
//$access_token = $_SESSION['access_token'];

//OAuthトークンとシークレットも使って TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,"1146553593526226945-Y3guotU9dOCcrJo7qwGsxybdYGAa0X" , "wHrRVskXWXMGm1S05IAPX6ve0iinAQys5YWljk3T2SNyT");
//var_dump($connection);

//以下、自分でやりたい動作をさせよう

//$home = $connection->get('statuses/home_timeline', array('count' => 10));
//$connection->post('statuses/update', ["status" => "Hello world"]);
//$home = $connection->get("search/tweets", ["q" => "#春から静大","count"=>"120"]); //,"until"=>"2019-04-03"

//$home=(array)$home;

//print(CONSUMER_KEY.",".CONSUMER_SECRET.",".$access_token['oauth_token'].",".$access_token['oauth_token_secret']);

//$tweet = "てすとのつぶやきです。".rand(0,99);
//$result = $connection->post("statuses/update",["status"=>$tweet]);

//$follows=$connection->get("friends/ids",["screen_name"=>"kurvan1112"]);
//$follows=((array)$follows)["ids"];
//print("Total:".count($follows)."<br>");
//file_put_contents("follows.txt",implode("\n",$follows));

$follows=explode("\n",file_get_contents("follows.txt"));
//var_dump($follows);

$start=file_get_contents("lastLine.txt");
$i=$start;

//print($connection->get("statuses/home_timeline"));

for(;$i-$start<min(100,count($follows)-$start);$i++){
    $relation=$connection->get("friendships/show", ["source_screen_name"=>"volgakurvar","target_id" => $follows[$i],"stringify_ids"=>true]);
    $relation=(array)$relation;
    $relation=(array)$relation["relationship"];
    $relation=(array)$relation["target"];
    //var_dump($relation);
    print("ID:".$follows[$i]." 表示名：".$relation["screen_name"]);
    if($relation["followed_by"]){ //フォロー済みだったら
        print('は<font color="#ff0000">フォロー済みです</font>');
    }else{
        $connection->post("friendships/create", ["screen_name" => $relation["screen_name"],"follow"=>"false"]);
        print('を<font color="#0000ff">フォローしました！</font>');
    }
    echo"<br>";
}

file_put_contents("lastLine.txt",$i);

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