#!/bin/bash

echo "Iniciando o setup do Laravel..."

# Verificar se o Laravel já está instalado
if [ ! -f artisan ]; then
    echo "Laravel não encontrado. Baixando o framework..."
    mkdir /tmp/laravel-install
    composer create-project --prefer-dist laravel/laravel /tmp/laravel-install

    echo "Movendo arquivos do Laravel para o diretório de trabalho..."
    mv /tmp/laravel-install/* /var/www/html/
    mv /tmp/laravel-install/.* /var/www/html/ 2>/dev/null || true
    rm -rf /tmp/laravel-install
    echo "Laravel instalado com sucesso!"
fi

# Configurar o arquivo .env
echo "Configurando o arquivo .env..."
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        echo "Copiando .env.example para .env..."
        cp .env.example .env
    else
        echo "Arquivo .env.example não encontrado. Criando um .env padrão..."
        cat <<EOL > .env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="\${APP_NAME}"
EOL
    fi
fi

# Atualizar variáveis no .env
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=laravel/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=laravel/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=secret/' .env
sed -i 's/CACHE_DRIVER=.*/CACHE_DRIVER=redis/' .env
sed -i 's/QUEUE_CONNECTION=.*/QUEUE_CONNECTION=redis/' .env
sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=redis/' .env

echo "Configuração do .env concluída."

# Instalar dependências do Composer
if [ -f composer.json ]; then
    echo "Instalando dependências do Composer..."
    composer install --no-interaction --prefer-dist
else
    echo "Arquivo composer.json não encontrado. Ignorando instalação do Composer."
fi

# Gerar chave da aplicação
if [ -f artisan ]; then
    echo "Gerando chave da aplicação..."
    php artisan key:generate
else
    echo "Arquivo artisan não encontrado. Ignorando geração de chave."
fi

# Executar migrations
if [ -f artisan ]; then
    echo "Executando migrations..."
    php artisan migrate --force
else
    echo "Arquivo artisan não encontrado. Ignorando migrations."
fi

# Verificar Redis
echo "Testando conexão com o Redis..."
if php -r "new Redis();" 2>/dev/null; then
    echo "Redis configurado e funcionando!"
else
    echo "Erro: Redis não configurado corretamente."
fi

# Iniciar o Vite (Frontend)
if [ -f package.json ]; then
    echo "Iniciando o Vite na porta 5173..."
    npm run dev &
else
    echo "Arquivo package.json não encontrado. Ignorando o Vite."
fi

# Iniciar o servidor Laravel
if [ -f artisan ]; then
    echo "Iniciando o servidor Laravel na porta 8000..."
    exec php artisan serve --host=0.0.0.0 --port=8000
else
    echo "Arquivo artisan não encontrado. Servidor não iniciado."
fi
