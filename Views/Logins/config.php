<?php
//アプリケーションの Consumer Key と Consumer Secret
$sTwitterConsumerKey = 't3qXM1MYzWjtaZARbjpPj0GlL'; //Consumer Key (API Key)
$sTwitterConsumerSecret = 'cPTEsdzZtSXk7o1duBehl6tAABhPE43udSBnSSJZvMHyR4qNjR'; //Consumer Secret (API Secret)
 
//アプリケーションのコールバックURL
$sTwitterCallBackUri = 'http://localhost:8888/Logins/callback.php'; //コールバックURL
 
//変数初期化
$objTwitterConection = NULL; //TwitterOAuthクラスのインスタンス化
$aTwitterRequestToken = array(); //リクエストトークン
$sTwitterRequestUrl = ''; //認証用URL
$objTwitterAccessToken = NULL; //アクセストークン
$objTwUserInfo = NULL; //ユーザー情報

require_once(ROOT_PATH.'php-graph-sdk-5.x/src/Facebook/autoload.php');
 
$fb = new Facebook\Facebook([
  'app_id' => '871571993480034',
  'app_secret' => '4e3c44bc1c23d97114d54b48bc24d2de',
  'default_graph_version' => 'v12.0',
]);
?>