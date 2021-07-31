## セットアップ

- git clone
```
git clone git@github.com:YukaIshida/laravel_vue_part1.git
cd laravel_vue_part1
cp .env.example .env
```

- composerインストール
```
composer install
```

- 初回起動
```
./vendor/bin/sail up
```

- 初回以降の起動は以下でOK
```
docker-compose up -d
```

- コンテナ停止
```
docker-compose down
```