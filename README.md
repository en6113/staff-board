# Staff-board 職員用情報共有ツール

社内のお知らせ・掲示・回覧を共有できるLaravelプロジェクトです。
チャット機能もあり、グループ及び個人間のやり取りが可能で、業務上の情報伝達を集約化することができます。
紙媒体で掲示・回覧していた情報をWeb上で共有することでペーパーレス化を実現します。

## 機能一覧

#### アカウント機能
- ユーザー登録 / ログイン / ログアウト(Laravel Fortify)
#### お知らせ機能
- お知らせ一覧表示 / 詳細表示 / 登録 / 編集 / 削除
#### 掲示・回覧機能
- 掲示・回覧一覧表示 / 詳細表示 / 登録 / 編集 / 削除
#### 送信一覧機能
- 送信一覧表示 / 既読 / 非表示
#### チャット機能
- チャット一覧表示 / グループ作成 / メッセージ送受信

## 使用技術

### 🛠️ バックエンド
- PHP 8.2.x
- Laravel 10.x
  - Laravel Fortify (認証機能)

### 💻 フロントエンド
- Blade(テンプレートエンジン)
- Tailwind CSS 3.4
- Vite（ビルドツール）

### 🗄️ データベース
- MySQL 8.4

### 🐳 インフラ / 開発環境
- Docker / Docker Compose
- Nginx (Webサーバー)
- phpMyAdmin (データベース管理ツール)

## ER図

![ER図](/docs/images/erd_20260804.png)

## 動作環境

- Docker
- Docker Compose

※ Windowsの場合はWSL2の利用を推奨します。

## 環境構築手順

1. **リポジトリのクローン**

    ```bash
    git clone git@github.com:en6113/staff-board.git
    ```

2. **.envファイルの準備**

    `.env.example` をコピーして `.env` を作成します。

    ```bash
    cp .env.example .env
    ```

    `.env` ファイル内の以下のDB接続情報が以下と一致していることを確認してください。

    ```ini
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password
    ```

3. **Composer依存パッケージのインストール**

    プロジェクトの初回セットアップ時は、`vendor` ディレクトリが存在しないため `sail` コマンドを使用できません。
    以下のDockerコマンドを実行して、コンテナ内で `composer install` を実行します。

    ```bash
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer install
    ```

4. **Laravel Sailの起動**

    以下のコマンドでDockerコンテナを起動します。

    ```bash
    ./vendor/bin/sail up -d
    ```

5. **エイリアスの設定**

    ```bash
    alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
    ```

6. **アプリケーションキーの生成**

    ```bash
    sail artisan key:generate
    ```

7. **データベースのマイグレーションと初期データ投入**

    以下のコマンドでテーブルを作成し、ダミーデータを投入します。

    ```bash
    sail artisan migrate:fresh --seed
    ```
    このコマンドの入力後、コンテナ内にデータが残っており、エラーが生じているケースなどがあります。
    その場合は、以下のコマンドを順に実行して各コンテナを再起動して下さい。
    ```bash
    sail down -v
    sail up -d
    sail artisan migrate:fresh --seed
    ```

8. **フロントエンドの準備**

    ```bash
    sail npm install
    sail npm run dev
    ```

    `npm run dev` は開発中は起動したままにしてください。

9. **アプリケーションへのアクセス**

    ブラウザで [http://localhost](http://localhost) にアクセスします。

## 開発環境URL

http://localhost

## 作成者

en6113
