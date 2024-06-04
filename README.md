# Exercicio2

Para executar o projeto é preciso utilizar o docker.

faça a instalação do composer

``docker run --rm \ 
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php83-composer:latest \
composer install --ignore-platform-reqs``

copie o .env

`cp .env.example .env`

inicio o docker, com --build para poder recriar tudo do 0

`./vendor/bin/sail up -d --build`

adicione uma chave de aplicação

`./vendor/bin/sail artisan key:generate`

realize a migração do banco de dados

`./vendor/bin/sail artisan migrate`

pronto agora o sistema está rodando.

---------------------

para realizar o teste antes é preciso realizar a migração

`./vendor/bin/sail artisan migrate --env=testing`

depois execute o pest

`./vendor/bin/sail pest`
