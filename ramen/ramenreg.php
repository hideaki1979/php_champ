<?php
    session_start();    // セッション開始
    require_once(dirname(__FILE__)."/../common/config.php"); // 共通定数用PHP
    require_once(COM_DB_PHP); // DB接続用phpを読みこむ
    require_once(COM_RAMENSQL_PHP); // ラーメン情報SQL用PHPを読み込む

    $pdo = getPdoConnection();  // DB接続
    // 食券買うタイミング用リスト取得
    $tickets = getCdMasterAll($pdo, "01");
    // 事前コールタイミング用リスト取得
    $advCalls = getCdMasterAll($pdo, "02");
    // 画像タイプ用リスト取得
    $imageTypes = getCdMasterAll($pdo, "03");

    $message = "";
    if(isset($_SESSION["message"])){
        $message = nl2br(htmlspecialchars($_SESSION["message"], ENT_QUOTES, "UTF-8"));
    }
    unset($_SESSION["message"]);   // セッション情報破棄
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include(COM_HEAD_REGDETAIL_HTML) ?>
</head>
<body>
    <?php include(COM_HEADER_PHP) ?>
    <div class="form-container">
        <p><?php echo $message; ?></p>
        <!-- タブエリア -->
        <div class="tab-container">
            <button class="tab-button active" data-tab="basic-info">基本情報</button>
            <button class="tab-button" data-tab="image-info">画像情報</button>
        </div>
        <h1>店舗情報登録</h1>
        <form action="rameninsert.php" method="POST" enctype="multipart/form-data">
            <!-- 基本情報タブエリア -->
            <div id="basic-info" class="tab-content active">
                <h2>■基本情報</h2>
                <div class="form-group">
                    <label for="store_name">店名</label>
                    <input type="text" name="store_name" id="store_name" placeholder="（例：ラーメン二郎）" required>
                </div>
                <div class="form-group">
                    <label for="branch_name">支店名</label>
                    <input type="text" name="branch_name" id="branch_name" placeholder="（例：上野毛店）">
                </div>
                <div class="form-group-inline-post">
                    <div class="form-group">
                        <label for="post_code">郵便番号</label>
                        <input type="text" name="post_code" id="post_code" placeholder="ハイフン無し7桁">
                    </div>
                    <button type="button" id="search_address">郵便番号検索</button>
                </div>
                <div class="form-group">
                    <label for="address1">都道府県</label>
                    <input type="text" name="address1" id="address1">
                </div>
                <div class="form-group">
                    <label for="address2">市区町村</label>
                    <input type="text" name="address2" id="address2">
                </div>
                <div class="form-group">
                    <label for="address3">番地</label>
                    <input type="text" name="address3" id="address3">
                </div>
                <div class="form-group">
                    <label for="address4">建物名</label>
                    <input type="text" name="address4" id="address4">
                </div>
                <div class="form-group">
                    <label for="business_hour">営業時間</label>
                    <textarea name="business_hour" id="business_hour" placeholder="開始時間～終了時間、補足があれば追加入力。"></textarea>
                </div>
                <div class="form-group">
                    <label for="holiday">定休日</label>
                    <textarea name="holiday" id="holiday" placeholder="曜日を入力、補足があれば追加入力してください。"></textarea>
                </div>
                <div class="form-group">
                    <label for="near_station">最寄り駅</label>
                    <input type="text" name="near_station" id="near_station" placeholder="沿線と駅名を入力">
                </div>
                <div class="form-group">
                    <label for="menu">メニュー</label>
                    <textarea name="menu" id="menu" placeholder="メニュー名と金額を入力、補足があれば追加入力"></textarea>
                </div>
                <div class="form-group-inline">
                    <div class="form-group">
                        <label for="noodle_amount_s">麺量（少な目）単位：g</label>
                        <input type="number" name="noodle_amount_s" id="noodle_amount_s">
                    </div>
                    <div class="form-group">
                        <label for="noodle_amount_m">麺量（普通）単位：g</label>
                        <input type="number" name="noodle_amount_m" id="noodle_amount_m">
                    </div>
                    <div class="form-group">
                        <label for="noodle_amount_l">麺量（大盛）単位：g</label>
                        <input type="number" name="noodle_amount_l" id="noodle_amount_l">
                    </div>
                </div>
                <div class="form-group">
                        <label for="ticket_timing">食券を買うタイミング</label>
                        <select name="ticket_timing" id="ticket_timing">
                            <option value=""></option>
                            <?php foreach($tickets as $ticket): ?>
                                <option value=<?= h($ticket["cd_key"]) ?>>
                                    <?= h($ticket["cd_value"]) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                </div>
                <div class="form-group">
                        <label for="adv_call_timing">事前コールのタイミング</label>
                        <select name="adv_call_timing" id="adv_call_timing">
                            <option value=""></option>
                            <?php foreach($advCalls as $advCall): ?>
                                <option value=<?= h($advCall["cd_key"]) ?>>
                                    <?= h($advCall["cd_value"]) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                </div>
                <div class="form-group">
                    <label for="adv_call">事前コール内容</label>
                    <textarea name="adv_call" id="adv_call" placeholder="例：麺固め、麺少な目、脂少な目など"></textarea>
                </div>
                <div class="form-group">
                    <label for="bef_offer_call">提供直前コール内容</label>
                    <textarea name="bef_offer_call" id="bef_offer_call" placeholder="例：野菜（野菜（野菜）・マシ・マシマシ）、ニンニク（ニンニク（普通）・マシ・マシマシ）、脂（アブラ（普通）・マシ・マシ）、カラメ（カラメ（普通）・マシ・マシマシ）、トッピング無しの場合は「普通で」とコールなど"></textarea>
                </div>
                <div class="form-group">
                    <label for="main_image">メイン画像</label>
                    <input type="file" name="main_image" id="main_image" accept="image/*">
                    <img id="image-prev" alt="画像プレビュー">
                </div>
                <div class="form-group">
                    <label for="all_more_flg">全マシ有無</label>
                    <input type="checkbox" name="all_more_flg" id="all_more_flg" value="1">
                </div>
                <div class="form-group">
                    <label for="tbl_seasoning">卓上調味料</label>
                    <input type="text" name="tbl_seasoning" id="tbl_seasoning" placeholder="">
                </div>
                <div class="form-group">
                    <label for="remarks">備考</label>
                    <textarea name="remarks" id="remarks" placeholder="例：酢、唐辛子酢、GABANブラックペッパーなど"></textarea>
                </div>
            </div>
            <!-- 画像情報タブエリア -->
            <div id="image-info" class="tab-content">
                <h2>■画像情報</h2>
                <div id="image-section">
                    <button id="add-image-button" type="button">画像追加</button>
                    <div class="image-entry">
                        <div class="form-group">
                            <label for="img_type">画像タイプ</label>
                            <select name="img_type[]">
                                <option value=""></option>
                                <?php foreach($imageTypes as $imageType): ?>
                                    <option value=<?= h($imageType["cd_key"]) ?>>
                                        <?= h($imageType["cd_value"]) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image_url">画像（ラーメン、メニュー（券売機）、列の並び方など）</label>
                            <input type="file" name="image_url[]" accept="image/*">
                            <img class="preview" alt="画像プレビュー">
                        </div>
                        <div class="form-group">
                            <label for="img_name">画像の説明</label>
                            <textarea name="img_name[]" class="img_name" placeholder="メニュー名、料金、トッピング（野菜マシ、脂マシなど）、列の並び方など何の写真わかるように記入してください"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="submit-area">
                <button type="submit" class="formsubmit">登録</button>
            </div>
        </form>
    </div>
    <script type="module">
        import { slideMenu } from "../js/slidemenu.js";
        // DOMContentLoaded：要素が完全にロードされた後にイベントリスナーを実行
        document.addEventListener("DOMContentLoaded", () => {
            slideMenu();
            const postSearchBtn = document.getElementById("search_address");    // 郵便番号検索ボタン
            const imageFileBtn = document.getElementById("main_image"); // メイン画像選択ボタン
            const addImageBtn = document.getElementById("add-image-button");    // 画像追加ボタン

            // 郵便番号検索ボタン押下時のイベント（住所検索して表示する）
            postSearchBtn.addEventListener("click", () => {
                const postCode = document.getElementById("post_code").value;
                // 郵便番号検索（zipcloud）APIから住所情報を取得する
                fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postCode}`)
                    .then((response) => response.json())
                    .then((data) => {
                        if(data.results) {
                            // 住所データを取得し、画面の住所項目に設定する
                            const address = data.results[0];
                            document.getElementById("address1").value = address.address1;   // 都道府県
                            document.getElementById("address2").value = address.address2;   // 市区町村
                            document.getElementById("address3").value = address.address3;   // 番地
                        } else {
                            alert("該当する住所がみつかりません。郵便番号をご確認ください。");
                        }
                    })
                    .catch((error) => console.error("住所検索エラー：", error));
            });

            // 画像プレビューの変更イベント（選択画像のプレビュー表示）
            imageFileBtn.addEventListener("change", (event) => {
                const file = event.target.files[0];
                const preview = document.getElementById("image-prev");
                const reader = new FileReader();

                reader.onload = () => {
                    preview.src = reader.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            });

            // タブの切り替え
            document.querySelectorAll(".tab-button").forEach((button) => {
                button.addEventListener("click", () => {
                    const tab = button.getAttribute("data-tab");
                    // タブボタンのアクティブ切り替え
                    document.querySelectorAll(".tab-button").forEach((btn) => btn.classList.remove("active"));
                    button.classList.add("active");

                    // タブコンテンツの切り替え
                    document.querySelectorAll(".tab-content").forEach((content) => content.classList.remove("active"));
                    document.getElementById(tab).classList.add("active");
                });
            });

            // 画像追加ボタン押下時（画像タイプ、画像、画像の説明の1セット項目追加）
            addImageBtn.addEventListener("click", () => {
                event.preventDefault(); // フォーム送信を防止
                const imageSection = document.getElementById("image-section");
                const newImageEntry = document.querySelector(".image-entry").cloneNode(true);

                // newImageEntryが値の入っている状態からcloneを行うためコピー対象の要素について初期化を行う。
                newImageEntry.querySelectorAll("input, textarea, select")
                .forEach((field) => {
                    field.value = "";
                });
                newImageEntry.querySelector(".preview").style.display = "none";

                // image-section子要素（image-entry）エリアを追加
                imageSection.appendChild(newImageEntry);
            });

            // （画像情報）画像ファイル選択時
            document.addEventListener("change", (event) => {
                if(event.target.type === "file") {
                    const fileInput = event.target; //画像ファイル選択ボタンの要素
                    const previewImage = fileInput.nextElementSibling;   //画像ファイル選択ボタンの次要素（imgタグ）
                    const file = fileInput.files[0];
                    console.log(fileInput);
                    console.log(previewImage);
                    console.log(file);
                    if(file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewImage.src = e.target.result;
                            previewImage.style.display = "block";
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewImage.style.display = "none";
                    }
                }
            });
        });
    </script>
</body>
</html>