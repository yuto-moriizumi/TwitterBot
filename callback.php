<?php
session_start();require_once 'common.php';require_once './twitteroauth-1.0.1/autoload.php'; //この辺りはディレクトリ設定によって適宜変えてください
use Abraham\TwitterOAuth\TwitterOAuth;
//login.phpでセットしたセッション
$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {die('Error!');}
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
$_SESSION['access_token'] = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

session_regenerate_id();

header('location: /TwitterBot/main.php');
