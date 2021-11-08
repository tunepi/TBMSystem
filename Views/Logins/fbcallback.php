<?php
session_start();

header("Content-type: text/html; charset=utf-8");
 
//設定ファイル
require_once(ROOT_PATH.'/Views/Logins/config.php');
 
//タイムゾーンの設定
date_default_timezone_set('asia/tokyo');
 
$helper = $fb->getRedirectLoginHelper();
//stateを$_SESSIONへセット
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}


 
try {
    if (isset($_SESSION['facebook_access_token'])) {
        //アクセストークンを取得する
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
        $accessToken = $helper->getAccessToken('http://localhost:8888/Logins/fbcallback.php');
		
	} 
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
    var_dump($_GET);
	exit;
}
 
if (isset($accessToken)) {
	//アクセストークンをセッションに保存
	$_SESSION['facebook_access_token'] = (string) $accessToken;
	
	header('Location: /Main/main.php');
	exit();
}else{
	echo "<a href='./login.php'>はじめのページへ</a>";
}