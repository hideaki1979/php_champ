<?php
    require_once("config.php"); // 定数管理用PHP
    require_once("db.php"); //DB接続用PHP読み込み
    require_once("commonfunc.php"); // SQLエラー、リダイレクトなど共通関数読み込み

    //エラー表示
    ini_set("display_errors", 1);

    // 食券を買うタイミング全件取得
    // 事前コールタイミング全件取得
    // 画像種別全件取得
    function getCdMasterAll($pdo, $iden_cd) {
        $sql = "SELECT * FROM code_master WHERE iden_cd = :iden_cd";
        $stmt = $pdo->prepare($sql);
        // 条件値をバインド変数に格納
        $stmt->bindValue(":iden_cd", $iden_cd, PDO::PARAM_STR);
        $status = $stmt->execute();
        $values = "";
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            sql_error($stmt);
        }
        // 全データ取得
        $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
        return $values;
    }

    // ラーメン基本情報全件取得
    function getRamenBaseAll($pdo) {
        $sql = "SELECT * FROM ramen_basic";
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute();
        $values = "";
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            sql_error($stmt);
        }
        // 全データ取得
        $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
        return $values;
    }

    // ラーメン基本情報キー取得
    function getRamenBaseKey($pdo, $id) {
        $sql = "SELECT BASE.*, TICKET.cd_value AS ticket_value, 
                ADVCALL.cd_value AS advcall_value, 
                CASE 
                    WHEN BASE.all_more_flg = 0 THEN '全マシNG'
                    WHEN BASE.all_more_flg = 1 THEN '全マシOK'
                    ELSE ''
                END AS all_more_name 
                FROM ramen_basic AS BASE, code_master AS TICKET,
                code_master AS ADVCALL 
                WHERE BASE.id=:id 
                AND TICKET.iden_cd = '01'
                AND BASE.ticket_timing = TICKET.cd_key 
                AND ADVCALL.iden_cd = '02' 
                AND BASE.adv_call_timing = ADVCALL.cd_key";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $status = $stmt->execute();

        //データ表示
        $value = "";
        if($status==false) {
            sql_error($stmt);
        }
        // データ取得
        $value =  $stmt->fetch(); //fetch（1行上の一行）
        $json = json_encode($value,JSON_UNESCAPED_UNICODE);
        return $value;
    }

    // ラーメン画像情報キー取得
    function getRamenImageAll($pdo, $ramenId) {
        $sql = "SELECT * FROM ramen_img WHERE ramen_id=:ramenId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":ramenId", $ramenId, PDO::PARAM_INT);
        $status = $stmt->execute();
        $values = "";
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            sql_error($stmt);
        }
        // 全データ取得
        $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
        return $values;
    }

    // ラーメンMAPAPI情報キー取得
    function getRamenMapApiKey($pdo, $ramenId) {
        $sql = "SELECT * FROM ramen_map_api WHERE ramen_id=:ramenId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":ramenId", $ramenId, PDO::PARAM_INT);
        $status = $stmt->execute();

        //データ表示
        $value = "";
        if($status==false) {
            sql_error($stmt);
        }
        // データ取得
        $value =  $stmt->fetch(); //fetch（1行上の一行）
        $json = json_encode($value,JSON_UNESCAPED_UNICODE);
        return $value;
    }

    // ラーメン基本情報キーワード取得
    function getRamenBaseKeyword($pdo, $post) {
        $keyword = $post["keyword"];
        $sql = "SELECT * FROM ramen_basic 
                WHERE store_name LIKE :keyword 
                OR branch_name LIKE :keyword 
                OR address1 LIKE :keyword 
                OR address2 LIKE :keyword 
                OR near_station LIKE :keyword";
        $stmt = $pdo->prepare($sql);
        $likeKeyword = '%'.$keyword.'%';
        $stmt->bindValue(":keyword", $likeKeyword, PDO::PARAM_STR);
        $status = $stmt->execute();
        $values = "";
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            sql_error($stmt);
        }
        // 全データ取得
        $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
        return $values;
    }
?>