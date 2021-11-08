<?php
session_start();
// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

//カレンダー処理
// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // 今月の年月を表示
    //date('Y-m')は日本の年、月を文字列で取得している
    $ym = date('Y-m');
}

// タイムスタンプを作成し、フォーマットをチェックする
//strtotime($ym . '-01')は＆ym-01の意味、つまり今月の1日のUNIX時間を取得
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// 今日の日付 フォーマット
$today = date('Y-m-j');

// カレンダーのタイトルを作成
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か 0:日 1:月 2:火 ... 6:土
$youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
$week .= str_repeat('<td></td>', $youbi);

for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

    // 2021-06-3
    $date = $ym . '-' . $day;
    
    if ($today == $date) {
        // 今日の日付の場合は、class="today"をつける
        $week .= '<td class="today">' . '<a href="tour_date.php?date= ' . $date . '">'.$day;
    } else {
        $week .= '<td><a href="tour_date.php?date= ' . $date . '">' . $day;
    }
    $week .= '</a></td>';

    // 週終わり、または、月終わりの場合
    if ($youbi % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // 月の最終日の場合、空セルを追加
            // 例）最終日が水曜日の場合、木・金・土曜日の空セルを追加
            $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }

        // weeks配列にtrと$weekを追加する
        $weeks[] = '<tr>' . $week . '</tr>';

        // weekをリセット
        $week = '';
    }
}

//インクルード
require_once(ROOT_PATH.'ca-bundle-main/src/CaBundle.php');
require_once(ROOT_PATH.'Views/Logins/config.php');
require_once(ROOT_PATH.'twitteroauth/autoload.php');
 
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;
 

//アクセストークン確認
if(isset($_SESSION['twAccessToken'])){
 
//TwitterOAuthクラスをインスタンス化
$objTwitterConection = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret,
 $_SESSION['twAccessToken']['oauth_token'],
 $_SESSION['twAccessToken']['oauth_token_secret']
 );
 
//ユーザー情報を取得
$objTwUserInfo = $objTwitterConection->get("account/verify_credentials");
$array = json_decode(json_encode($objTwUserInfo), true);
$_SESSION['array'] = $array;

}elseif(isset($_SESSION['facebook_access_token'])) { 
    $accessToken = $_SESSION['facebook_access_token']; 
    $fb->setDefaultAccessToken($accessToken);
         
        try {
            //取得するユーザ情報の指定
            $response = $fb->get('/me?fields=id,name,first_name,last_name,email,gender');
            $profile = $response->getGraphUser();
            
            $_SESSION['fb_name'] = $profile['name'];
            $_SESSION['fb_id'] = $profile['id'];
            $_SESSION['fb_first_name'] = $profile['first_name'];
            $_SESSION['fb_last_name'] = $profile['last_name'];
            
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
}elseif(isset($_SESSION['login_user'])){

}else{
    header("Location: /Logins/login.php");
       exit();
}        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>トップページ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Bootstrap CSS --> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/index.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!--#_=_を排除する-->
<script type="text/javascript">
if (window.location.hash && window.location.hash == '#_=_') {
  if (window.history && history.pushState) {
      window.history.pushState("", document.title, window.location.pathname);
  } else {
    // Prevent scrolling by storing the page's current scroll offset
    var scroll = {
        top: document.body.scrollTop,
      left: document.body.scrollLeft
    };
    window.location.hash = '';
    // Restore the scroll offset, should be flicker free
    document.body.scrollTop = scroll.top;
    document.body.scrollLeft = scroll.left;
  }
}
</script>
<!-- ヘッダー読み込み --> 
<?php require_once(ROOT_PATH.'Views/Main/header.php');?>

<?php

//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//大会の名前の取得
$tournaments = $main->tournament();

//ダイレクトアクセス禁止フラグ
$_SESSION['flg'] = 0;
$_SESSION['flg1'] = 0;
$_SESSION['flg2'] = 0;
$_SESSION['flg3'] = 0;
$_SESSION['flg4'] = 0;
$_SESSION['flg5'] = 0;
$_SESSION['flg6'] = 0;

?>

<div class="back_box">
    <div class="main_box">
        <!-- カレンダー --> 
        <div class="container">
            <h3 class="mb-5" style="padding-top: 48px;"><a href="?ym=<?php echo $main->h($prev); ?>">&lt;</a> <?php echo $main->h($html_title); ?> <a href="?ym=<?php echo $main->h($next); ?>">&gt;</a></h3>
            <table class="table table-bordered">
                <tr>
                    <th>日</th>
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th>土</th>
                </tr>
                <?php
                    foreach ($weeks as $week) {
                        echo $week;
                    }
                ?>
            </table>
        </div>
        <div>
            <!-- 検索ボックス、追加ボタン --> 
            <div class="search">
                <form action="tour_research.php" method="post">
                <input type="text" placeholder="キーワード検索" name = "search">
                    <input type="submit" value="検索" style="background-color:royalblue; color:white;">
                </form>
            </div>
            <!-- 大会一覧表示 --> 
            <div class="tournament" style="text-align: right;">
                <div class="tour_line">
                    <div class="tour_mark">
                        <!-- 管理者なら表示 -->
                        <?php if(!empty($_SESSION ["login_user"]['role']) && $_SESSION ["login_user"]['role'] === "1"):?>
                        <a href="./add_tour.php" class="btn btn-outline-primary">大会追加</a>
                        <?php endif;?> 
                    </div>
                    <!-- データ数の制限したものを表示する -->
                    <div class = "arrow">
                        <div>  
                            <?php
                                if(isset($_GET['page']) && $_GET['page'] !== '0'){
                                    $page = $_GET['page'] - 1;
                                    echo "<a href='./main.php?page=".$page."'>&lt;</a>";
                                }else{
                                    echo "<a style='color:lightgray;' >&lt;</a>";
                                }
                            ?>  
                        </div> 
                        <div>
                            <?php
                            if(isset($_GET['page']) &&  $_GET['page']  < $tournaments['pages']-1 ){
                                $page = $_GET['page'] + 1;
                                echo "<a href='./main.php?page=".$page."'>&gt;</a>";
                            }elseif(!isset($_GET['page']) || $_GET['page'] === '0'){
                                echo "<a href='./main.php?page=1'>&gt;</a>";
                            }else{
                                echo "<a style='color:lightgray;' >&gt;</a>";
                            }
                            ?>  
                        </div>
                    </div>
                    
                </div>
                <!-- 大会名の表示 -->
                <h2>大会一覧</h2>
                <?php foreach($tournaments['tournaments'] as $tournament ): ?>    
                <div class="tournament_name"><a href="./tour_detail.php?id=<?php echo $main->h($tournament['id'])?>">■<?php echo $main->h($tournament['tournament_name']) ?></a></div>
                <?php endforeach;?> 
            </div>
        </div>
    </div>
</div>    
</body>
</html>