<?php
    session_start();    // セッション開始
    require_once(dirname(__FILE__)."/../common/config.php"); // 共通定数用PHP
    require_once(COM_DB_PHP); // DB接続用phpを読みこむ
    require_once(COM_RAMENSQL_PHP); // ラーメン情報SQL用PHPを読み込む
    require_once(COM_FUNC_PHP); // SQLエラー、リダイレクトなど共通関数読み込み

    $pdo = getPdoConnection();  // DB接続
    $ramenBasic = getRamenBaseKey($pdo, $_GET["id"]);   // ラーメン基本情報取得
    $ramenImgs = getRamenImageAll($pdo, $_GET["id"]);   // ラーメン画像情報取得
    $ramenMap = getRamenMapApiKey($pdo, $_GET["id"]);   // ラーメンMAPAPI情報取得

    // 郵便番号にハイフンを付加
    $postalCode = substr($ramenBasic["post_code"], 0, 3)."-".substr($ramenBasic["post_code"], 3);

    // Google Static Maps APIからMAP情報を取得する。
    $latitude = $ramenMap["latitude"];  // 緯度
    $longitude = $ramenMap["longitude"]; // 緯度
    $zoom = 15;
    $size = "400x300";
    $apiKey = GOOGLE_API_KEY;
    $gMapImage = getStaticMap($latitude, $longitude, $zoom, $size, $apiKey);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include(COM_HEAD_REGDETAIL_HTML) ?>
</head>
<body>
    <?php include(COM_HEADER_PHP) ?>
    <div class="detail-container">
        <!-- タブエリア -->
        <div class="tab-container">
            <button class="tab-button active" data-tab="basic-info">基本情報</button>
            <button class="tab-button" data-tab="image-info">画像情報</button>
            <button class="tab-button" data-tab="map-info">MAP</button>
        </div>
        <h1>店舗情報詳細</h1>
        <!-- 基本情報タブエリア -->
        <div id="basic-info" class="basic tab-content active">
            <h2>■基本情報</h2>
            <dl>
                <div><dt>店舗名</dt><dd><?=h($ramenBasic["store_name"])."　".h($ramenBasic["branch_name"]) ?></dd></div>
                <div><dt>住所</dt><dd>
                    <?="〒".h($postalCode)."　".h($ramenBasic["address1"]).h($ramenBasic["address2"]).h($ramenBasic["address3"]).h($ramenBasic["address4"]) ?></dd></div>
                <div><dt>営業時間</dt><dd><?=nl2br(h($ramenBasic["business_hour"])) ?></dd></div>
                <div><dt>定休日</dt><dd><?=nl2br(h($ramenBasic["holiday"])) ?></dd></div>
                <div><dt>最寄り駅</dt><dd><?=h($ramenBasic["near_station"]) ?></dd></div>
                <div><dt>メニュー</dt><dd><?=nl2br(h($ramenBasic["menu"])) ?></dd></div>
                <div><dt>麺量（少な目）</dt><dd><?=h($ramenBasic["noodle_amount_s"])."g" ?></dd></div>
                <div><dt>麺量（普通）</dt><dd><?=h($ramenBasic["noodle_amount_m"])."g" ?></dd></div>
                <div><dt>麺量（大盛）</dt><dd><?=h($ramenBasic["noodle_amount_l"])."g" ?></dd></div>
                <div><dt>食券を買うタイミング</dt><dd><?=h($ramenBasic["ticket_value"]) ?></dd></div>
                <div><dt>事前コールのタイミング</dt><dd><?=h($ramenBasic["advcall_value"]) ?></dd></div>
                <div><dt>事前コール内容</dt><dd><?=nl2br(h($ramenBasic["adv_call"])) ?></dd></div>
                <div><dt>提供直前コール内容</dt><dd><?=nl2br(h($ramenBasic["bef_offer_call"])) ?></dd></div>
                <div><dt>全マシ有無</dt><dd><?=h($ramenBasic["all_more_name"]) ?></dd></div>
                <div><dt>卓上調味料</dt><dd><?=h($ramenBasic["tbl_seasoning"]) ?></dd></div>
                <div><dt>備考</dt><dd><?=nl2br(h($ramenBasic["remarks"])) ?></dd></div>
            </dl>
        </div>
        <!-- 画像情報タブエリア -->
        <div id="image-info" class="tab-content">
            <h2>■画像情報</h2>
            <div class="imagearea">
                <!-- レイアウト確認用に固定で8件分表示 -->
                <div class="thumbnail-container">
                    <img src="../bakimg/efu.jpg" alt="" class="thumbnail">
                    <p class="img-name">笑歩の特製中華そば。麺量は145g</p>
                </div>
                <div class="thumbnail-container">
                    <img src="../bakimg/gokokami_seimenjo.jpg" alt="" class="thumbnail">
                    <p class="img-name">五ノ神製作所の特製海老トマトつけ麺（普通：270g）</p>
                </div>
                <div class="thumbnail-container">
                    <img src="../bakimg/butajima_gen_tsuke.jpg" alt="" class="thumbnail">
                    <p class="img-name">ラーメン豚島の限定（つけ麺）麺量は300g、トッピングは普通コール</p>
                </div>
                <div class="thumbnail-container">
                    <img src="../bakimg/butakaze_konbushirunasi.jpg" alt="" class="thumbnail">
                    <p class="img-name">豚風の限定（こんぶの汁なし）麺量は少な目（250g程度）、トッピングコールは「そのまま（無し）」</p>
                </div>
                <div class="thumbnail-container">
                    <img src="../bakimg/butakaze_nagaokasoy.jpg" alt="" class="thumbnail">
                    <p class="img-name">豚風の限定（長岡醤油）麺量は普通（デフォ250g程度）、トッピングコールは「脂」（本限定のトッピングは脂のみ）</p>
                </div>
                <div class="thumbnail-container">
                    <img src="../bakimg/nagi_tonkotsu.jpg" alt="" class="thumbnail">
                    <p class="img-name">この間行った凪のとんこつラーメン</p>
                </div>
                <div class="thumbnail-container">
                    <img src="../bakimg/efu.jpg" alt="" class="thumbnail">
                    <p class="img-name">笑歩の特製中華そば。麺量は145g</p>
                </div>
                <div class="thumbnail-container">
                    <img src="../bakimg/efu.jpg" alt="" class="thumbnail">
                    <p class="img-name">笑歩の特製中華そば。麺量は145g</p>
                </div>
                <!-- ここからDB登録した画像情報データを表示 -->
                <?php foreach($ramenImgs as $ramenImg): ?>
                    <div class="thumbnail-container">
                        <img src="<?=$ramenImg["img_url"] ?>" alt="該当店舗の画像" class="thumbnail">
                        <p class="img-name"><?=$ramenImg["img_name"] ?></p>
                    </div>
                <?php endforeach ?>
            </div>
            <!-- モーダル表示 -->
             <div id="modal" class="modal">
                <span class="close">閉じる</span>
                <img class="modal-content" id="modal-image">
                <div id="caption"></div>
             </div>
        </div>
        <div class="tab-content" id="map-info">
            <h2>■MAP情報</h2>
            <!-- Base64エンコードして画像として表示 -->
            <div id="map">
                <img src="data:image/png;base64,<?= base64_encode($gMapImage) ?>" alt="該当店舗のGoogleMap">
            </div>
        </div>
    </div>
    <script type="module">
        import { slideMenu } from "../js/slidemenu.js";
        // DOMContentLoaded：要素が完全にロードされた後にイベントリスナーを実行
        document.addEventListener("DOMContentLoaded", () => {
            slideMenu();
            // タブ切り替え時
            document.querySelectorAll(".tab-button").forEach((button) => {
                button.addEventListener("click", () => {
                    const tab = button.getAttribute("data-tab");
                    // console.log("あああ");

                    // タブボタンのアクティブ
                    document.querySelectorAll(".tab-button").forEach((btn) => btn.classList.remove("active"));
                    button.classList.add("active");

                    // タブコンテンツの表示切替
                    document.querySelectorAll(".tab-content").forEach((content) => content.classList.remove("active"));
                    document.getElementById(tab).classList.add("active");
                });
            });

            // モーダル表示処理
            // モーダル要素を取得
            const modal = document.getElementById("modal");
            const modalImage = document.getElementById("modal-image");
            const caption = document.getElementById("caption");
            const closeBtn = document.querySelector(".close");

            // 各サムネイル画像要素を取得
            const thumbnails = document.querySelectorAll(".thumbnail-container");

            // 各サムネイルにクリックイベントを設定
            thumbnails.forEach(thumbnail => {
                const image = thumbnail.querySelector(".thumbnail");
                const description = thumbnail.querySelector(".img-name");

                image.addEventListener("click", () => {
                    modal.style.display = "block";
                    modalImage.src = image.src; // モーダル側のsrc属性に画像情報のsrc情報を設定
                    caption.textContent = description.textContent;  // モーダル側の説明に画像情報の説明を設定
                });
            });

            // モーダルの閉じるボタン押下時
            closeBtn.addEventListener("click", () => {
                modal.style.display = "none";
            });

            // モーダルの外をクリックして閉じる動作
            modal.addEventListener("click", () => {
                if(event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>