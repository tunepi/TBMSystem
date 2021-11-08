<?php
require_once(ROOT_PATH.'/Models/Db.php');

class Main extends Db { //Dbクラスを継承

    public function __construct($dbh = null){
        parent::__construct($dbh);//親クラス（Db）のコンストラクトを引数$dbhで呼び出す
    }

    //ユーザ名の取得
    public function getUsername($data){
        try{
            $this->dbh->beginTransaction();
            $sql = 'SELECT name FROM users WHERE mail = :mail ';
            $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':mail',$data,PDO::PARAM_STR);
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetch();//resultに取り出したデータを格納
            return $result;
            if($res){
                $this->dbh->commit();
            }
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
    }

    //ユーザ情報取得
    public function getUserDetail($data){
        try{
            $this->dbh->beginTransaction();
            $sql = 'SELECT * FROM users WHERE mail = :mail ';
            $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':mail',$data,PDO::PARAM_STR);
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetch();//resultに取り出したデータを格納
            return $result;
            if($res){
                $this->dbh->commit();
            }
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
        
    }

    
    //大会の追加処理
    public function tourAdd($userData){
        try{
            $this->dbh->beginTransaction();
            $sql = "INSERT INTO 
                    tournament (tournament_name,date_time,field,address,sports_name,licence,expense,mail,tel,limit_datetime) 
                    VALUES (:tournament_name,:date_time,:field,:address,:sports_name,:licence,:expense,:mail,:tel,:limit_datetime)";
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            //プレースホルダ
            $sth->bindValue(':tournament_name',$userData['tournament_name'],PDO::PARAM_STR);
            $sth->bindValue(':date_time',date("Y-m-d H:i:s", strtotime($userData['date_time'])),PDO::PARAM_STR);
            $sth->bindValue(':field',$userData['field'],PDO::PARAM_STR);
            $sth->bindValue(':address',$userData['address'],PDO::PARAM_STR);
            $sth->bindValue(':sports_name',$userData['sports_name'],PDO::PARAM_STR);
            $sth->bindValue(':licence',$userData['licence'],PDO::PARAM_STR);
            $sth->bindValue(':expense',(int)$userData['expense'],PDO::PARAM_INT);
            $sth->bindValue(':tel',$userData['tel'],PDO::PARAM_STR);
            $sth->bindValue(':mail',$userData['mail'],PDO::PARAM_STR);
            $sth->bindValue(':limit_datetime',date("Y-m-d H:i:s",strtotime($userData['limit_datetime'])),PDO::PARAM_STR);
            $res = $sth->execute();//sqlを実行
            if($res){
                $this->dbh->commit();
            }
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
         
    }
    //大会の編集後更新処理
    public function tourUpdate($userData){
        try{
            $this->dbh->beginTransaction();   
            $sql = " UPDATE tournament 
                 SET tournament_name = :tournament_name ,date_time = :date_time ,field = :field, address = :address ,sports_name = :sports_name ,licence = :licence, expense = :expense,tel = :tel,mail=:mail,limit_datetime =:limit_datetime";
            $sql .= " WHERE id = :tournament_id";
            $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':tournament_id', $userData['tournament_id'], PDO::PARAM_INT);
            $sth->bindValue(':tournament_name',$userData['tournament_name'],PDO::PARAM_STR);
            $sth->bindValue(':date_time',date("Y-m-d H:i:s", strtotime($userData['date_time'])),PDO::PARAM_STR);
            $sth->bindValue(':field',$userData['field'],PDO::PARAM_STR);
            $sth->bindValue(':address',$userData['address'],PDO::PARAM_STR);
            $sth->bindValue(':sports_name',$userData['sports_name'],PDO::PARAM_STR);
            $sth->bindValue(':licence',$userData['licence'],PDO::PARAM_STR);
            $sth->bindValue(':expense',(int)$userData['expense'],PDO::PARAM_INT);
            $sth->bindValue(':tel',$userData['tel'],PDO::PARAM_STR);
            $sth->bindValue(':mail',$userData['mail'],PDO::PARAM_STR);
            $sth->bindValue(':limit_datetime',date("Y-m-d H:i:s",strtotime($userData['limit_datetime'])),PDO::PARAM_STR);  
            $res = $sth->execute();//sqlを実行
            if($res){
                $this->dbh->commit();
            }
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }

    }
    //大会情報の削除
    public function tourDelete($id){
        try{
            $this->dbh->beginTransaction();
            $sql  = 'DELETE FROM tournament WHERE id = :id';//as シングルクォーテーション
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindParam(':id', $id, PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//sqlを実行 
            
            $sql  = 'DELETE FROM tournament_player WHERE tournament_id = :id';//as シングルクォーテーション
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindParam(':id', $id, PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res2 = $sth->execute();//sqlを実行 
            
            $sql  = 'DELETE FROM tournament_group WHERE tournament_id = :id';//as シングルクォーテーション
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindParam(':id', $id, PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res3 = $sth->execute();//sqlを実行
            if($res && $res2 && $res3){
                $this->dbh->commit();
            }
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
         
    }

    //個人の追加処理
    public function singleAdd($userData){
        try{
            $this->dbh->beginTransaction();
            $sql = 'INSERT INTO 
                        players (name ,kana ,age ,team_name ,sex ,tel ,users_id) 
                        VALUES (:name , :kana, :age, :team_name, :sex, :tel, :users_id)';
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            //プレースホルダ
            $sth->bindValue('name',$userData['name'],PDO::PARAM_STR);
            $sth->bindValue('kana',$userData['kana'],PDO::PARAM_STR);
            $sth->bindValue(':age',(int)$userData['age'],PDO::PARAM_INT);
            $sth->bindValue('team_name',$userData['team_name'],PDO::PARAM_STR);
            $sth->bindValue(':sex',(int)$userData['sex'],PDO::PARAM_INT);
            $sth->bindValue(':tel',$userData['tel'],PDO::PARAM_STR);
            $sth->bindValue(':users_id',(int)$userData['user_id'], PDO::PARAM_INT);
            $res = $sth->execute();//sqlを実行  
            //INSERTしたIDを取得
            $sql = 'SELECT LAST_INSERT_ID()';
            $sth = $this->dbh->prepare($sql);//sql文を$sthにセットする
            $res2 = $sth->execute();//sqlを実行 
            $id = $sth->fetch();
            //tournament_playerにIDを登録
            $sql = 'INSERT INTO 
                        tournament_player (player_id,tournament_id) 
                        VALUES(:player_id,:tournament_id)';
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            $sth->bindValue(':player_id',(int)$id[0], PDO::PARAM_INT);
            $sth->bindValue(':tournament_id',(int)$userData['tournament_id'], PDO::PARAM_INT);
            $res3 = $sth->execute();//sqlを実行 
            if($res && $res2 && $res3){
                $this->dbh->commit();
            }  
            
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
    }
    //個人の編集後更新処理
    public function singleUpdate($userData){
        try{
            $this->dbh->beginTransaction();
            $sql = 'UPDATE players SET name = :name,kana = :kana ,age = :age ,team_name = :team_name ,sex = :sex ,tel = :tel ,users_id = :users_id ';
            $sql .= " WHERE id = :id";
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            //プレースホルダ
            $sth->bindValue(':id', $userData['id'], PDO::PARAM_INT);
            $sth->bindValue('name',$userData['name'],PDO::PARAM_STR);
            $sth->bindValue('kana',$userData['kana'],PDO::PARAM_STR);
            $sth->bindValue(':age',(int)$userData['age'],PDO::PARAM_INT);
            $sth->bindValue('team_name',$userData['team_name'],PDO::PARAM_STR);
            $sth->bindValue(':sex',(int)$userData['sex'],PDO::PARAM_INT);
            $sth->bindValue(':tel',$userData['tel'],PDO::PARAM_STR);
            $sth->bindValue(':users_id',(int)$userData['user_id'], PDO::PARAM_INT);
            $res =$sth->execute();//sqlを実行 
            if($res){
                $this->dbh->commit();
            }   
            
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
    }

    //個人登録情報の削除
    public function singleDelete($id){
        try{
            $this->dbh->beginTransaction();
            $sql  = 'DELETE FROM players WHERE id = :id';
            $sth  = $this->dbh->prepare($sql);
            $sth->bindValue(':id', (int)$id['id'], PDO::PARAM_INT);
            $res = $sth->execute();
            

            $sql  = 'DELETE FROM tournament_player WHERE player_id = :id && tournament_id = :tournament_id';//as シングルクォーテーション
            $sth  = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id['id'], PDO::PARAM_INT);
            $sth->bindValue(':tournament_id',(int)$id['tournament_id'], PDO::PARAM_INT);
            $res1 = $sth->execute();
            if($res && $res1){
                $this->dbh->commit();
            }

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
        
       
    }

    //団体の追加処理
    public function groupAdd($userData){
        try{
            $this->dbh->beginTransaction();
            $sql = 'INSERT INTO 
                        groups (name ,kana ,team_number,man ,woman ,tel, users_id) 
                        VALUES (:name , :kana, :team_number,:man, :woman, :tel, :users_id)';
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            //プレースホルダ
            $sth->bindValue(':name',$userData['name'],PDO::PARAM_STR);
            $sth->bindValue(':kana',$userData['kana'],PDO::PARAM_STR);
            $sth->bindValue(':team_number',(int)$userData['team_number'],PDO::PARAM_INT);
            $sth->bindValue(':man',(int)$userData['man'],PDO::PARAM_INT);
            $sth->bindValue(':woman',(int)$userData['woman'],PDO::PARAM_INT);
            $sth->bindValue(':tel',$userData['tel'],PDO::PARAM_STR);
            $sth->bindValue(':users_id', $userData['user_id'], PDO::PARAM_INT);
            $res = $sth->execute();//sqlを実行 
            //INSERTしたIDを取得
            $sql = 'SELECT LAST_INSERT_ID()';
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            $res1 = $sth->execute();//sqlを実行 
            $id = $sth->fetch();

            //tournament_playerにIDを登録
            $sql = 'INSERT INTO 
                        tournament_group (group_id,tournament_id) 
                        VALUES(:group_id,:tournament_id)';
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            $sth->bindValue(':group_id',(int)$id[0], PDO::PARAM_INT);
            $sth->bindValue(':tournament_id',(int)$userData['tournament_id'], PDO::PARAM_INT);
            $res2 = $sth->execute();//sqlを実行 
            if($res && $res1 && $res2){
                $this->dbh->commit();
            }  

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
    }

    //団体の編集後追加処理
    public function groupUpdate($userData){
        try{
            $this->dbh->beginTransaction();
            $sql = 'UPDATE groups SET name = :name,kana = :kana ,team_number = :team_number ,man = :man ,woman = :woman ,tel = :tel ,users_id = :users_id ';
            $sql .= " WHERE id = :id";
            $sth  = $this->dbh->prepare($sql);//sql文を$sthにセットする
            //プレースホルダ
            $sth->bindValue(':id', $userData['id'], PDO::PARAM_INT);
            $sth->bindValue(':name',$userData['name'],PDO::PARAM_STR);
            $sth->bindValue(':kana',$userData['kana'],PDO::PARAM_STR);
            $sth->bindValue(':team_number',(int)$userData['team_number'],PDO::PARAM_INT);
            $sth->bindValue(':man',(int)$userData['man'],PDO::PARAM_INT);
            $sth->bindValue(':woman',(int)$userData['woman'],PDO::PARAM_INT);
            $sth->bindValue(':tel',$userData['tel'],PDO::PARAM_STR);
            $sth->bindValue(':users_id', $userData['user_id'], PDO::PARAM_INT);
            $res = $sth->execute();//sqlを実行 
            if($res){
                $this->dbh->commit();
            }  
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
    }

    //団体登録情報の削除
    public function groupDelete($id){
        try{
            $this->dbh->beginTransaction();

            //groupsテーブルのデータ削除
            $sql  = 'DELETE FROM groups WHERE id = :id';
            $sth  = $this->dbh->prepare($sql);
            $sth->bindValue(':id', (int)$id['id'], PDO::PARAM_INT);
            $res = $sth->execute();

            //tournament_groupテーブルのデータ削除
            $sql  = 'DELETE FROM tournament_group WHERE group_id = :id && tournament_id = :tournament_id';//as シングルクォーテーション
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindParam(':id', $id['id'], PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $sth->bindValue(':tournament_id',(int)$id['tournament_id'], PDO::PARAM_INT);
            $res1 = $sth->execute();//execute():sqlを実行
            if($res && $res1){
                $this->dbh->commit();
            }  

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
        
    }

    //個人詳細用取得処理
    public function groupDetail($id){
        try{
            $this->dbh->beginTransaction();
            $sql  = 'SELECT * FROM groups  WHERE id = :id';
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':id', (int)$id['id'], PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            if($res){
                $this->dbh->commit(); 
            }  
        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
        
    }
     
     //メインページの大会表
    public function findAll($page = 0):Array {
        try{
            $this->dbh->beginTransaction();
            $sql = 'SELECT id, tournament_name FROM tournament ORDER BY id DESC';
            $sql .= ' LIMIT 9 OFFSET '.(9 * $page); //20行に制限
            $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            if($res){
                $this->dbh->commit(); 
            } 

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
    }

    //ページングの選手数を数える
    public function countAll():Int {
        $sql = 'SELECT count(*) as count FROM tournament';//選手の数を数える
        $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
        $sth->execute();//execute():sqlを実行
        $count = $sth->fetchColumn();//引数＝カラムの番号、文字列で取得
        return $count;
    }
    
    //選手詳細抽出（1選手のデータ取り出し）
    public function findById($id = 0):Array {
        try{
            $sql  = 'SELECT * FROM tournament WHERE id = :id';//as シングルクォーテーション
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindParam(':id', $id, PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC:連想配列のスタイルにする
            return $result; //fetchAll():全データを配列で返す

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            
        } 
    }

    public function detail_get($data):Array{
        try{
            $sql  = 'SELECT * FROM tournament WHERE id = :id';//as シングルクォーテーション
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':id', (int)$data, PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC:連想配列のスタイルにする
            return $result; //fetchAll():全データを配列で返す

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            
        } 

    }
    //個人登録の一覧用取得処理
    public function singleRegister($id,$page){
        try{
            $this->dbh->beginTransaction();
            $sql  = 'SELECT p.* FROM tournament_player t LEFT JOIN players p ON t.player_id = p.id WHERE tournament_id = :tournament_id';
            $sql .= ' LIMIT 4 OFFSET '.(4 * $page); //20行に制限
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':tournament_id', (int)$id['id'], PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            if($res){
                $this->dbh->commit(); 
            } 

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
    }
    //ページングの選手数を数える
    public function singleAll($id):Int {
        $sql = 'SELECT count(*) as count FROM tournament_player t LEFT JOIN players p ON t.player_id = p.id WHERE tournament_id = :tournament_id';//選手の数を数える
        $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
        $sth->bindValue(':tournament_id', (int)$id['id'], PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
        $sth->execute();//execute():sqlを実行
        $count = $sth->fetchColumn();//引数＝カラムの番号、文字列で取得
        return $count;
    }

    
    //個人詳細用取得処理
    public function singleDetail($id){
        try{
            $this->dbh->beginTransaction();

            $sql  = 'SELECT * FROM players  WHERE id = :id';
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':id', (int)$id['id'], PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            if($res){
                $this->dbh->commit(); 
            }

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }
        
    }

    //団体登録の一覧用取得処理
    public function groupRegister($id,$page){
        try{
            $this->dbh->beginTransaction();

            $sql  = 'SELECT p.* FROM tournament_group t LEFT JOIN groups p ON t.group_id = p.id WHERE tournament_id = :tournament_id';
            $sql .= ' LIMIT 4 OFFSET '.(4 * $page); //20行に制限
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':tournament_id', (int)$id['id'], PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            if($res){
                $this->dbh->commit(); 
                
            }else{
                echo '失敗';
            }

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }    
    }
    //ページングの選手数を数える
    public function groupAll($id):Int {
        $sql = 'SELECT count(*) as count FROM tournament_player t LEFT JOIN groups p ON t.group_id = p.id WHERE tournament_id = :tournament_id';//選手の数を数える
        $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
        $sth->bindValue(':tournament_id', (int)$id['id'], PDO::PARAM_INT);//SQLに対してパラメーターをセットする。
        $sth->execute();//execute():sqlを実行
        $count = $sth->fetchColumn();//引数＝カラムの番号、文字列で取得
        return $count;
    }

    //日付による検索
    public function tourDate($date,$page=0){
        try{
            $this->dbh->beginTransaction();

            $format='%Y-%m-%d';
            $sql = 'SELECT * FROM tournament WHERE DATE_FORMAT(date_time, :form) = DATE_FORMAT(:date_time,:form)';
            $sql .= ' LIMIT 4 OFFSET '.(4 * $page); //20行に制限
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $sth->bindValue(':date_time',date("Y-m-d", strtotime($date['date'])),PDO::PARAM_STR);
            $sth->bindValue(':form',$format,PDO::PARAM_STR);
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;


            if($res){
                $this->dbh->commit(); 
            }

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();
        }    
    }
    //ページングの選手数を数える
    public function dateAll($date):Int {
        $format='%Y-%m-%d';
        $sql = 'SELECT count(*) as count FROM tournament WHERE DATE_FORMAT(date_time, :form) = DATE_FORMAT(:date_time,:form)';//選手の数を数える
        $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
        $sth->bindValue(':date_time',date("Y-m-d", strtotime($date['date'])),PDO::PARAM_STR);
        $sth->bindValue(':form',$format,PDO::PARAM_STR);
        $sth->execute();//execute():sqlを実行
        $count = $sth->fetchColumn();//引数＝カラムの番号、文字列で取得
        return $count;
    }

    //検索ボックスによる検索
    public function search($data,$page=0){
        try{
            $this->dbh->beginTransaction();

            $sql  = 'SELECT * FROM tournament  WHERE tournament_name LIKE :search';
            $sql .= ' LIMIT 4 OFFSET '.(4 * $page); //20行に制限
            $sth  = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
            $data = '%'.$data['search'].'%';
            $sth->bindValue(':search', $data, PDO::PARAM_STR);//SQLに対してパラメーターをセットする。
            $res = $sth->execute();//execute():sqlを実行
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;

            if($res){
                $this->dbh->commit(); 
            }

        }catch(Exception $e){
            echo $e->getMessage()."\n";
            $this->dbh->rollBack();

        
        }
    }    
    //ページングの選手数を数える
    public function searchAll($data):Int {
        $sql = 'SELECT count(*) as count FROM tournament WHERE tournament_name LIKE :search';//大会の数を数える
        $sth = $this->dbh->prepare($sql);//prepare($sql):＄sqlを$sthにセットする
        $data = '%'.$data['search'].'%';
        $sth->bindValue(':search', $data, PDO::PARAM_STR);//SQLに対してパラメーターをセットする。
        $sth->execute();//execute():sqlを実行
        $count = $sth->fetchColumn();//引数＝カラムの番号、文字列で取得
        return $count;
    }

}    

?>