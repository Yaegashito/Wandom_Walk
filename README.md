# わんダムウォークとは？
　わんダムウォークは飼い犬の認知症を予防するための散歩補助アプリです。毎日違う経路を散歩することで飼い犬の脳を刺激できます。いつもと違う経路を散歩しようと思っても考えるのが面倒だから結局同じ道に…なんてことはよくあること。このアプリはボタンを押すだけで経路を生成してくれます。また、散歩した日がカレンダーに記録されるので、塗り絵感覚で散歩を楽しむこともできます。
　ちなみにアプリ名は、毎日異なるランダムな経路を散歩するという点から「ランダムウォーク」と考えましたが、ちょっと味気ないので犬のためのアプリであることに着目して「ラン」を泣き声の「わん」にして、「わんダムウォーク」となりました。
# URL
https://wandom-walk.com

# アプリ紹介記事
詳しい使い方や、開発においてこだわったポイント、苦労したポイントなどをまとめております。
https://qiita.com/tomoyaApp/items/a8a84202a8d1d6c66e3c

# 画面キャプチャ
### ログイン画面
　ログイン、新規登録、アプリ説明があります。新規登録時には利用上の注意に同意していただくようになっています。
　ログインフォームを一番最初に表示することで、利用までの手間ができるだけ少なくなるようにしています。

<img width="300" alt="ログイン画面" src="https://github.com/user-attachments/assets/3f043fc2-8ec6-4aff-b762-8ea887a73505">

### 散歩画面
　散歩時間を選択して散歩経路を生成します。散歩時間は１０～１５分（老犬）、２０～３０分（小型犬）、４０～６０分（大型犬）から選択します。散歩開始直前に持ち物リストを確認します。散歩終了ボタンで散歩が記録されるようになっており、散歩中にブラウザバック等をするとアラートが出るようになっています。

<img width="300" alt="散歩画面" src="https://github.com/user-attachments/assets/18c8a523-b15a-46ee-9f7b-a7d5f00865ed">

### カレンダー
　シンプルなカレンダーです。

<img width="300" alt="カレンダー" src="https://github.com/user-attachments/assets/aa3c2b93-3985-4d9a-84e0-3b68df9f2c87">

### 持ち物リスト
　持ち物リストの追加・削除ができます。

<img width="300" alt="持ち物リスト" src="https://github.com/user-attachments/assets/52ad0f9a-11a4-493e-9913-e8b4d9eec6c0">

### その他
　アプリ説明、ご意見送信フォーム、プロフィール欄、パスワード変更、アカウント削除の項目があります。

<img width="300" alt="その他" src="https://github.com/user-attachments/assets/044a3c36-d850-479e-b65f-03253d0ab6a8">

# 仕様技術
- JavaScript
- PHP(8.1.29)/Laravel(10.48.15)
- MySQL(8.0.37)
- AWS(VPC/EC2/RDS/Route53/ACM/ELB)
- Google Maps API(Maps JavaScript API/Directions API)
- その他：AOS.js/Prettier/ESLint/Larastan
# ER図
<img width="400" alt="ER図" src="https://github.com/user-attachments/assets/bf5d35e4-fa69-43eb-922b-14ab614f0adc">

# システム構成図
<img width="500" alt="システム構成図" src="https://github.com/user-attachments/assets/1f2ab734-92b5-41b6-b675-d9c011418e15">

# 機能一覧
- ログイン/新規登録
- パスワード変更
- アカウント削除
- 散歩経路生成（散歩時間の選択が可能）
- 散歩した日を記録
- 持ち物リスト
- ご意見送信フォーム
- アプリ説明
