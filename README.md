### わんダムウォークとは？
　わんダムウォークは飼い犬の認知症を予防するための散歩補助アプリです。毎日違う経路を散歩することで飼い犬の脳を刺激できます。いつもと違う経路を散歩しようと思っても考えるのが面倒だから結局同じ道に…なんてことはよくあること。このアプリはボタンを押すだけで経路を生成してくれます。また、散歩した日がカレンダーに記録されるので、塗り絵感覚で散歩を楽しむこともできます。
　ちなみにアプリ名は、毎日異なるランダムな経路を散歩するという点から「ランダムウォーク」と考えましたが、ちょっと味気ないので犬のためのアプリであることに着目して「ラン」を泣き声の「わん」にして、「わんダムウォーク」となりました。
### URL
https://wandom-walk.com
### 画面キャプチャ

### 仕様技術
- JavaScript
- PHP(8.1.29)/Laravel(10.48.15)
- MySQL(8.0.37)
- AWS(VPC/EC2/RDS/Route53/ACM/ELB)
- Google Maps API(Maps JavaScript API/Directions API)
- その他：AOS.js/Prettier/ESLint/Larastan
### ER図
<img width="400" alt="ER図" src="https://github.com/user-attachments/assets/bf5d35e4-fa69-43eb-922b-14ab614f0adc">

### システム構成図
<img width="500" alt="システム構成図" src="https://github.com/user-attachments/assets/1f2ab734-92b5-41b6-b675-d9c011418e15">

### 機能一覧
- ログイン/新規登録
- パスワード変更
- アカウント削除
- 散歩経路生成（散歩時間の選択が可能）
- 散歩した日を記録
- 持ち物リスト
- ご意見送信フォーム
- アプリ説明
