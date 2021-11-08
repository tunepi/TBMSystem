<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_SESSION['flg']) || $_SESSION['flg'] !== 0){
    header("Location: ./main.php");
       exit();
} 
//大会のあいまい検索処理
if(!empty($_POST)){
    $tourDates = $main->search($_POST);
    $_SESSION['search'] = $_POST['search'] ;
}else{
    $tourDates = $main->search($_SESSION);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>大会一覧</title>
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
<!-- ヘッダー読み込み --> 
<?php require_once(ROOT_PATH.'Views/Main/header.php');?>

<div class="detail_back">
    <div class="detail_box">
        <div class="header_middle">
            <div>
                <h2>大会一覧</h2>
                <p>検索ワード：<?php if(!empty($_POST['search'])){echo $main->h($_POST['search']);}else{echo $main->h($_SESSION['search']);}?></p>
            </div>
            <div class="header_link">
                <div class="arrow_link">
                    <?php
                    if(isset($_GET['page']) && $_GET['page'] !== '0'){
                        $page = $_GET['page'] - 1;
                        echo "<a href='./tour_research.php?page=".$page."'>&lt;</a>";
                    }else{
                        echo "<a style='color:lightgray;' >&lt;</a>";
                    }
                    ?>  
                    <?php
                    if(isset($_GET['page']) &&  $_GET['page']  < $tourDates['pages']-1 ){
                        $page = $_GET['page'] + 1;
                        echo "<a href='./tour_research.php?page=".$page."'>&gt;</a>";
                    }elseif(!isset($_GET['page']) || $_GET['page'] === '0'){
                        echo "<a href='./tour_research.php?page=1'>&gt;</a>";
                    }else{
                        echo "<a style='color:lightgray;' >&gt;</a>";
                    }
                    ?>
                </div>
                <div class="top_link">
                    <a href="./main.php">トップページへ</a>
                </div>
            </div>
        </div>

        <div class="tournament_date_box">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th style="color:black;">大会名</th>
                    <th>種目</th>
                    <th>会場</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tourDates['Info'] as $tourDate):?>
                    <tr>
                    <td><a href="tour_detail.php?id=<?php echo $main->h($tourDate['id']);?>"><?php echo $main->h($tourDate['tournament_name']);?></a></td>
                    <td><?php echo $main->h($tourDate['sports_name']);?></td>
                    <td><?php echo $main->h($tourDate['field']);?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>