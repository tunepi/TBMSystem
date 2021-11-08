<?php
##############################################
### 初期設定
 
//セッションスタート
session_start();
 
//文字セット
header("Content-type: text/html; charset=utf-8"); 
 
//インクルード
require_once(ROOT_PATH.'ca-bundle-main/src/CaBundle.php');
require_once(ROOT_PATH.'Views/Logins/config.php');
require_once(ROOT_PATH.'twitteroauth/autoload.php');

 
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;
 
##############################################
### oauthトークン確認
if(empty($_SESSION['twOauthToken']) || empty($_SESSION['twOauthTokenSecret']) || empty($_REQUEST['oauth_token']) || empty($_REQUEST['oauth_verifier'])){
 echo 'error token!!';
 exit;
}
if($_SESSION['twOauthToken'] !== $_REQUEST['oauth_token']) {
 echo 'error token incorrect!!';
 exit;
}
 
##############################################
### アクセストークン作成
 
//取得したoauthトークンでTwitterOAuthクラスをインスタンス化
$objTwitterConection = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret,
 $_SESSION['twOauthToken'],
 $_SESSION['twOauthTokenSecret']
 );
 
//アクセストークンの取得
$_SESSION['twAccessToken'] = $objTwitterConection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
 
//メンバーページへリダイレクト
header('location: /Main/main.php');
