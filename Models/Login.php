<?php
require_once(ROOT_PATH.'/Models/Db.php');

class Login extends Db { //Dbクラスを継承
    public function __construct($dbh = null){
        parent::__construct($dbh);//親クラス（Db）のコンストラクトを引数$dbhで呼び出す
    }

    //emailからデータをとってくる
    public function getUserByEmail($data){
        $result = false;
        $sql = 'SELECT * FROM users WHERE mail = :email'; 

        try{
        $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
        $sth->bindValue(':email',$data,PDO::PARAM_STR);
        $sth->execute();//execute():sqlを実行
        $result = $sth->fetch();//resultに取り出したデータを格納
        return $result;
        }catch(Exception $e){
            //falseを返す
            return $result;
        }
        
    }

    //ユーザ登録処理
    public function userRegister($userData){
        //パスワードのハッシュ化
        $password = password_hash($userData['password'],PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (name, mail, password) VALUE (:name , :email , :password)';
        $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
        //プレースホルダ
        $sth->bindValue(':name',$userData['name'],PDO::PARAM_STR);
        $sth->bindValue(':email',$userData['email'],PDO::PARAM_STR);
        $sth->bindValue(':password',$password,PDO::PARAM_STR);
        $sth->execute();//sqlを実行 
    }

    //パスワードリセット
    public function passReset($userData){
        //パスワードのハッシュ化
        $password = password_hash($userData['password'],PASSWORD_DEFAULT);
        $sql = 'UPDATE users SET password = :password WHERE mail = :email';
        $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
        //プレースホルダ
        $sth->bindValue(':email',$userData['email'],PDO::PARAM_STR);
        $sth->bindValue(':password',$password,PDO::PARAM_STR);
        $sth->execute();//sqlを実行 
    }
    
}    

?>