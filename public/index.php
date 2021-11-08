<?php
//define(定数名, 値 [, 大文字と小文字の区別])=定数の定義  
//str_replace("検索文字列", "置換え文字列", "対象文字列")=対象文字列内から検索文字列を検索し、置き換えしその値を返す
define('ROOT_PATH', str_replace('public','',$_SERVER["DOCUMENT_ROOT"]));
//parse_url()=URLの構成要素のうち特定できるものに関しては連想配列で返す=URLを分解して返す
$parse = parse_url($_SERVER["REQUEST_URI"]);
//ファイル名が省略されていた場合、index.phpを補填する
//mb_substr(対象文字列, 取得開始位置の数値, 取得する長さの数値 バイト)=文字列の指定した位置からバイト数分の文字列を取得する
if(mb_substr($parse['path'],-1) === '/'){
    $parse['path'] .= $_SERVER["SCRIPT_NAME"];//.=文字の連結
}
//require_once()=ファイルを読み込む。また、既に読み込まれているかをチェックする
require_once(ROOT_PATH.'Views'.$parse['path']);
?>