<?php
     require_once(dirname(__FILE__)."/../common/config.php"); // 共通定数用PHP
     require_once(COM_DB_PHP); // DB接続用phpを読みこむ
     require_once(COM_RAMENSQL_PHP);    // ラーメン情報用SQL用phpを読み込む

     $pdo = getPdoConnection();  // DB接続
     
     $ramens = [];
     // GETでの遷移の場合は全件出力
     if($_SERVER["REQUEST_METHOD"] === "GET"){
        $ramens = getRamenBaseAll($pdo); // ラーメン基本情報全件取得
     }

     // POSTでの遷移（キーワード検索）の場合は該当店舗のみ出力
     if($_SERVER["REQUEST_METHOD"] === "POST"){
        $ramens = getRamenBaseKeyword($pdo, $_POST);
     }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include(COM_HEAD_HTML) ?>
</head>
<body>
    <?php include(COM_HEADER_PHP) ?>
    <!-- スマホ専用アイコン領域 -->
    <!-- <div class="mobile-icons">
        <a href="main.php"><img src="" alt="メイン画面"></a>
        <a href="map.php"><img src="" alt="MAP画面"></a>
    </div> -->
    <!-- 検索エリア -->
    <div class="searcharea">
        <form method="post" class="searchform">
            <input type="text" name="keyword" class="keyword" placeholder="キーワード検索（店名、住所、最寄り駅）">
            <input type="submit" value="検索" class="search-btn">
        </form>
        <!-- <a href="map.php" class="map-link">MAP</a> -->
    </div>
    <!-- 商品一覧 -->
    <div class="ramenlist">
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店１</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店２</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店３</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店４</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店５</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店６</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店７</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <div class="ramenarea">
            <img src="../bakimg/jiro_kaminoge.jpg" alt="">
            <div class="storename">ラーメン二郎　上野毛店８</div>
            <a href="detail.php">詳細画面へ</a>
        </div>
        <?php foreach($ramens as $ramen): ?>
            <div class="ramenarea">
                <img src="<?= h($ramen["main_image_url"]) ?>" alt="">
                <div class="storename"><?= h($ramen["store_name"])."　".h($ramen["branch_name"]) ?></div>
                <a href="ramendetail.php?id=<?=h($ramen["id"]) ?>">詳細画面へ</a>
            </div>
        <?php endforeach ?>
    </div>
    <script type="module">
        import { slideMenu } from "../js/slidemenu.js";
        // DOMContentLoaded：要素が完全にロードされた後にイベントリスナーを実行
        document.addEventListener("DOMContentLoaded", () => {
            slideMenu();
        });
    </script>
</body>
</html>