<?php
//session_start();

require_once 'common.php';
require_once './twitteroauth-1.0.1/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//セッションに入れておいたさっきの配列
//$access_token = $_SESSION['access_token'];

//OAuthトークンとシークレットも使って TwitterOAuth をインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, "1146553593526226945-Y3guotU9dOCcrJo7qwGsxybdYGAa0X", "wHrRVskXWXMGm1S05IAPX6ve0iinAQys5YWljk3T2SNyT");

try {
    function fetchTweets($idFile, $query, $connection)
    {
        $lastId = 0;
        $minId = 91203826589957423104;
        $lastId = (int) file_get_contents($idFile);

        function cutePrint($array, $nest, &$lastId, &$minId)
        {
            foreach ($array as $key => $value) {
                if (is_object($value) || is_array($value)) {
                    echo str_repeat('  ', $nest) . '"' . $key . '":{<br>';
                    cutePrint((array) $value, $nest + 1, $lastId, $minId);
                    echo str_repeat('  ', $nest) . '}<br>';
                } else {
                    if (strcmp($key, "id") == 0) {
                        //global $lastId;
                        $lastId = max($lastId, (int) $value);
                        $minId = mix($minId, (int) $value);
                    }
                    echo str_repeat('  ', $nest) . '"' . $key . '":' . $value . '<br>';
                }
            }
        }
        //$result = $connection->get("search/tweets", ["q" => $query, "count" => 100, "since_id" => $lastId,'until'=>'2019-12-09']);
        $result = $connection->get("search/tweets", ["q" => $query, "count" => 100, "max_id" => 1303826589957423104]);

        echo '<pre>';
        echo '{';
        cutePrint((array) $result, 0, $lastId, $minId);
        echo '}';
        echo '</pre>';

        file_put_contents('1komaResult' . date("Y-m-d-H:i:s") . '.json', json_encode((array) $result));
        file_put_contents($idFile, $lastId);
        file_put_contents($idFile . 'MM', $minId);
    }

    //fetchTweets('lastId.txt', "1コマブッチ", $connection);
    //sleep(100);
    //fetchTweets('lastId.txt', "絶起 OR 1コマブッチ OR 一コマブッチ", $connection);
    fetchTweets('lastId2.txt', "遅刻", $connection);
} catch (\Throwable $th) {
    echo $th;
}
