# ①課題名
- MIRRORMAN JIROTYPE DB　～ニンニク入れますか？～

# ②課題内容（どんな作品か）
- ラーメンデータベースの二郎系特化したアプリです。  

## ③アプリのデプロイURL  
  https://kagami-hide.sakura.ne.jp/php_championship

## ④アプリのログイン用IDまたはPassword（ある場合）
- ID: なし
- PW: なし  
  ※ユーザ管理未実装

## ⑤工夫した点・こだわった点
- レスポンシブ対応（まだ完全ではない）
- 入力・詳細画面をタブ構造で実装（ただ見た目はボタン・・・）  
- 郵便番号検索（zipcloud）APIから住所情報を取得して画面表示  
- GoogleMaps APIを使って登録画面で入力した住所をベースにMAP表示  
　（Geocoding API、Maps Static API）
- ラーメンなどの画像を複数ファイル登録可能とするUI
- 表示項目は二郎系に特化した項目を用意
- 画像をクリックするとモーダル表示で画像拡大
- DB登録処理は一度に3テーブル登録のためトランザクション制御を入れております。

## ⑥難しかった点・次回トライしたいこと（又は機能）
【難しかった点】  
- 単純にDB項目数が多いので画面作成やDB登録処理など  
　個々の作業に時間がかかってしまいました。  
- DBのinsertも1度に3テーブルの登録を行う必要があり、  
　そのうちの1つはGeocoding APIから緯度・経度を取得してDB登録のため 
　エラー調査・対応に時間がかかってしまった。（原因はほぼタイポ）
  
【次回トライしたいこと】  
- ラーメン情報のUD機能、ユーザ管理機能、クラス設計・実装（今回も余裕がなかった・・・）  
- Composer（インストールエラーが出て調査中）からのphpdotenvでAPIキーなど重要情報を隠す実装  
→（今回も余裕がなかった・・・）
- まだまだ未実装機能があるので、それを実装したい。

## ⑦フリー項目（感想、シェアしたいこと等なんでも）
- 今回は初めてWhyMe（自分自身の実体験）をもとに作った課題のため、  
　思い入れが今まで作成した課題より強いと感じております。  
　まだまだ未実装の機能もあり、完成には程遠い状態ですが、  
　選手権で見せれるプロトレベルまでには実装出来たかなと思います。  

- [参考記事]
  - 1. [Google Maps Geocoding API](https://developers.google.com/maps/documentation/geocoding/start?hl=ja)
  - 2. [Google Maps Static API](https://developers.google.com/maps/documentation/maps-static/start?hl=ja)
  - 3. [郵便番号検索API（zipcloud）](https://zipcloud.ibsnet.co.jp/doc/api)