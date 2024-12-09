<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include("common/head_index.html") ?>
</head>
<body>
    <!-- 動画再生用セクション -->
    <div class="video-container" id="video-container">
        <video class="chakudon-video" id="chakudon-video" autoplay muted>
            <source src="videos/chakudon.mp4" type="video/mp4">
            ご使用されているブラウザが動画再生に対応しておりません。
        </video>
    </div>
    <!-- メインセクション -->
    <div class="main" id="main-content" style="display: none;">
        <?php include("common/header_index.php") ?>
        <div class="maintitle">
            <h1>MIRRORMAN JIROTYPE DB</h1>
            <h2>～ニンニク入れますか？～</h2>
            <h2><a class="enter" href="ramen/main.php">－JOROTYPE DBへ－</a></h2>
        </div>
        <img class="mainimg" src="images/jiroumori.jpg" alt="MirrorMan JiroTypeDBのメイン画像">
    </div>

    <script type="module">
        import { slideMenu } from "./js/slidemenu.js";
        // 画面表示時に動画が自動再生され、再生終了後にメインコンテンツを表示する。
        const videoContainer = document.getElementById("video-container");
        const video = document.getElementById("chakudon-video");
        const mainContent = document.getElementById("main-content");
        // 動画再生終了後
        video.addEventListener("ended", () => {
            // 動画セクションを非表示
            videoContainer.style.display = "none";
            // メインコンテンツを表示
            mainContent.style.display = "block";
        })
        slideMenu();
    </script>
</body>
</html>