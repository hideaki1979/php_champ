<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//画面遷移（リダイレクト）関数: $file_name画面名、$message画面に表示するメッセージ、$idテーブルのID（クエリパラメータにIDを入れない場合は0を指定する）
function scrRedirect($file_name, $message, $id){
    session_start();
    $message ? $_SESSION["message"] = $message : "";
    $id !== 0 ? $_SESSION["keyId"] = $id : "";
    header("Location: $file_name");
    exit();
}

// Session Check
function sschk() {
    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
        exit("ログインしてください！");
    } else {
        session_regenerate_id(true);    // セッションハイジャック対策！必ずtrue指定すること！
        $_SESSION["chk_ssid"] = session_id();
    }
}

// Google Static Maps APIでMAP生成
function getStaticMap($latitude, $longitude, $zoom, $size, $apiKey) {
    // Google Static Maps APIのURLを生成
    $mapUrl = "https://maps.googleapis.com/maps/api/staticmap";
    $mapUrl .= "?center={$latitude},{$longitude}";
    $mapUrl .= "&zoom={$zoom}";
    $mapUrl .= "&size={$size}";
    $mapUrl .= "&markers=color:yellow|{$latitude},{$longitude}";
    $mapUrl .= "&key={$apiKey}";

    // cURLを使ってAPIリクエストを送信
    $ch = curl_init();  // cURLセッションを初期化
    // データ取得のオプション設定
    curl_setopt($ch, CURLOPT_URL, $mapUrl); //接続先URL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // curl_exec() の戻り値を 文字列で返す。
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // SSL証明書確認（HTTPでは不要）
    $mapRes = curl_exec($ch);
    // エラーチェック
    if(curl_errno($ch)) {
        echo "cURLエラー：".curl_error($ch);
    }
    curl_close($ch);

    return $mapRes;
}

?>