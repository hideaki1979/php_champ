<?php
    require_once(dirname(__FILE__)."/../common/config.php"); // 共通定数用PHP
    require_once(COM_DB_PHP); // DB接続用phpを読みこむ
    require_once(COM_FUNC_PHP); // SQLエラー、リダイレクトなど共通関数読み込み

    // HTMLからPOSTで送られた値を受け取る
    // ラーメン基本情報
    $storeName = $_POST["store_name"];
    $branchName = $_POST["branch_name"];
    $postCode = $_POST["post_code"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $address3 = $_POST["address3"];
    $address4 = $_POST["address4"];
    // 改行コード付きのものは\nに統一する。（OS間で改行コードが異なるため）
    $businessHour = $_POST["business_hour"];
    $businessHour = str_replace("\r\n", "\n", $businessHour);
    $holiday = $_POST["holiday"];
    $holiday = str_replace("\r\n", "\n", $holiday);
    $nearStation = $_POST["near_station"];
    $menu = $_POST["menu"];
    $menu = str_replace("\r\n", "\n", $menu);
    $noodleAmountS = $_POST["noodle_amount_s"];
    $noodleAmountM = $_POST["noodle_amount_m"];
    $noodleAmountL = $_POST["noodle_amount_l"];
    $ticketTiming = $_POST["ticket_timing"];
    $advCallTiming = $_POST["adv_call_timing"];
    $advCall = $_POST["adv_call"];
    $advCall = str_replace("\r\n", "\n", $advCall);
    $befOfferCall = $_POST["bef_offer_call"];
    $befOfferCall = str_replace("\r\n", "\n", $befOfferCall);
    $allMoreFlg = isset($_POST["all_more_flg"]) ? 1 : 0;
    $tblSeasoning = $_POST["tbl_seasoning"];
    $remarks = $_POST["remarks"];
    $remarks = str_replace("\r\n", "\n", $remarks);
    $mainImageUrl = "";

    // ラーメン画像情報（複数）
    $imgTypes = $_POST["img_type"];
    $imageFiles = $_FILES["image_url"];
    $imgNames = $_POST["img_name"];

    // ファイルアップロードチェック
    // アップロード対象ファイルが正常にアップロードされたかをチェック。
    // リクエストメソッドがPOSTか。画像ファイルか。アップロードエラーがないか。
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // メイン画像用
        if(isset($_FILES["main_image"]) && $_FILES["main_image"]["error"] == UPLOAD_ERR_OK) {
            // フォームで指定されたアップロードデータを取得（tmp_nameはアップロード時の一時保管先）
            $mainImageTmp = $_FILES["main_image"]["tmp_name"];
            // 正規にHTTP POSTでアップロードされたかをチェック
            if(is_uploaded_file($mainImageTmp)){
                $uploadDir = "../ramenimages/";
                $mainImageUrl = $uploadDir.$_FILES["main_image"]["name"];
                move_uploaded_file($mainImageTmp, $mainImageUrl);
            } else {
                scrRedirect(RAMEN_REGIST_SC, HTTP_POST_UPLOAD_ERR, 0);
            }
        } else {
            scrRedirect(RAMEN_REGIST_SC, FILE_UNSPECIFIED_ERR, 0);
        }

        // ラーメン画像情報（複数）
        if (isset($_FILES["image_url"])) {
            foreach($_FILES["image_url"]["tmp_name"] as $index => $tmpName) {
                if ($_FILES["image_url"]["error"][$index] != UPLOAD_ERR_OK || !is_uploaded_file($tmpName)) {
                    scrRedirect(RAMEN_REGIST_SC, HTTP_POST_UPLOAD_ERR, 0);
                }
            }
        } else {
            scrRedirect(RAMEN_REGIST_SC, FILE_UNSPECIFIED_ERR, 0);
        }
    }
    // DB接続
    try {
        $pdo = getPdoConnection();  // DB接続
        $pdo->beginTransaction();   // トランザクション開始

        // ラーメン基本情報TBLのSQL文作成
        $basicSql = "INSERT INTO ramen_basic (
        store_name, branch_name, post_code, address1, address2, address3, address4, business_hour,
        holiday, near_station, menu, noodle_amount_s, noodle_amount_m, noodle_amount_l,
        ticket_timing, adv_call_timing, adv_call, bef_offer_call, all_more_flg, tbl_seasoning,
        remarks, main_image_url, indate
        ) VALUES (
        :store_name, :branch_name, :post_code, :address1, :address2, :address3, :address4, 
        :business_hour, :holiday, :near_station, :menu, :noodle_amount_s, :noodle_amount_m, 
        :noodle_amount_l, :ticket_timing, :adv_call_timing, :adv_call, :bef_offer_call, 
        :all_more_flg, :tbl_seasoning, :remarks, :main_image_url, sysdate()
        )";
        $stmt = $pdo->prepare($basicSql);
        // 登録する値をバインド変数に格納
        $stmt->bindValue(":store_name", $storeName, PDO::PARAM_STR);
        $stmt->bindValue(":branch_name", $branchName, PDO::PARAM_STR);
        $stmt->bindValue(":post_code", $postCode, PDO::PARAM_STR);
        $stmt->bindValue(":address1", $address1, PDO::PARAM_STR);
        $stmt->bindValue(":address2", $address2, PDO::PARAM_STR);
        $stmt->bindValue(":address3", $address3, PDO::PARAM_STR);
        $stmt->bindValue(":address4", $address4, PDO::PARAM_STR);
        $stmt->bindValue(":business_hour", $businessHour, PDO::PARAM_STR);
        $stmt->bindValue(":holiday", $holiday, PDO::PARAM_STR);
        $stmt->bindValue(":near_station", $nearStation, PDO::PARAM_STR);
        $stmt->bindValue(":menu", $menu, PDO::PARAM_STR);
        $stmt->bindValue(":noodle_amount_s", $noodleAmountS, PDO::PARAM_INT);
        $stmt->bindValue(":noodle_amount_m", $noodleAmountM, PDO::PARAM_INT);
        $stmt->bindValue(":noodle_amount_l", $noodleAmountL, PDO::PARAM_INT);
        $stmt->bindValue(":ticket_timing", $ticketTiming, PDO::PARAM_STR);
        $stmt->bindValue(":adv_call_timing", $advCallTiming, PDO::PARAM_STR);
        $stmt->bindValue(":adv_call", $advCall, PDO::PARAM_STR);
        $stmt->bindValue(":bef_offer_call", $befOfferCall, PDO::PARAM_STR);
        $stmt->bindValue(":all_more_flg", $allMoreFlg, PDO::PARAM_INT);
        $stmt->bindValue(":tbl_seasoning", $tblSeasoning, PDO::PARAM_STR);
        $stmt->bindValue(":remarks", $remarks, PDO::PARAM_STR);
        $stmt->bindValue(":main_image_url", $mainImageUrl, PDO::PARAM_STR);
        $status = $stmt->execute();

        //データ登録処理後
        if($status==false){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            sql_error($stmt);
        }

        // ラーメン基本情報のIDを取得
        $ramenId = $pdo->lastInsertId();
        // GoogleMaps Geocoding APIで経度・緯度を取得
        $fullAddress = $address1.$address2.$address3;
        $gMapApiUrl = GOOGLE_MAPS_API_URL.urlencode($fullAddress)."&key=".GOOGLE_API_KEY;
        $apiResponse = file_get_contents($gMapApiUrl);
        $gMapData = json_decode($apiResponse, true);

        // GoogleMaps Geocoding API取得結果チェック（住所不正チェック）
        // 結果が正常に返っていれば緯度・経度をラーメンMAP情報テーブルに登録する。
        if(isset($gMapData["results"][0]["geometry"]["location"])) {
            $latitude = $gMapData["results"][0]["geometry"]["location"]["lat"];
            $longitude = $gMapData["results"][0]["geometry"]["location"]["lng"];
            $mapApiSql = "INSERT INTO ramen_map_api (ramen_id, latitude, longitude, indate) 
            VALUES (:ramen_id, :latitude, :longitude, sysdate())";
            $stmt = $pdo->prepare($mapApiSql);
            $stmt->bindValue(":ramen_id", $ramenId, PDO::PARAM_INT);
            $stmt->bindValue(":latitude", $latitude, PDO::PARAM_STR);
            $stmt->bindValue(":longitude", $longitude, PDO::PARAM_STR);
            $status = $stmt->execute();

            //データ登録処理後
            if($status==false){
                //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
                sql_error($stmt);
            }
        } else {
            throw new Exception("GoogleMaps Geocoding APIにてエラーが発生しました。");
        }

        // ラーメン画像情報の登録処理
        foreach($imgTypes as $index => $imgType) {
            if(!empty($imageFiles["tmp_name"][$index])) {
                $imageUrl = $uploadDir.$imageFiles["name"][$index];
                move_uploaded_file($imageFiles["tmp_name"][$index], $imageUrl);
                $imgNames[$index] = str_replace("\r\n", "\n", $imgNames[$index]);

                $imageSql = "INSERT INTO ramen_img (ramen_id, img_type, img_url, img_name, indate) 
                VALUES (:ramen_id, :img_type, :img_url, :img_name, sysdate())";
                $stmt = $pdo->prepare($imageSql);
                $stmt->bindValue(":ramen_id", $ramenId, PDO::PARAM_INT);
                $stmt->bindValue(":img_type", $imgType, PDO::PARAM_STR);
                $stmt->bindValue(":img_url", $imageUrl, PDO::PARAM_STR);
                $stmt->bindValue(":img_name", $imgNames[$index], PDO::PARAM_STR);
                $status = $stmt->execute();
    
                //データ登録処理後
                if($status==false){
                    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
                    sql_error($stmt);
                }
            }
        }
        // コミット
        $pdo->commit();
        // 登録完了メッセージを店舗情報登録画面に表示する。
        scrRedirect(RAMEN_REGIST_SC, INSERT_COMP, 0);

    } catch(PDOException $e) {
        // ロールバック
        $pdo->rollBack();
        exit("DB接続・登録処理エラー：".$e->getMessage());
    } catch(Exception $e) {
        exit("異常終了：".$e->getMessage());
    }


?>