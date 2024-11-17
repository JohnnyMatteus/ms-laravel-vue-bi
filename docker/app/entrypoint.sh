#!/bin/bash

echo "Iniciando o setup do Laravel..."

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
REDIS_PORT=6379
SESSION_LIFETIME=120
FILESYSTEM_DISK=local

MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"
EOL
    fi
fi

# Atualizar variáveis no .env
sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
sed -i 's/DB_HOST=.*/DB_HOST=db/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=laravel/' .env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=laravel/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=secret/' .env

echo "Configuração do .env concluída."

# Verificar se o banco de dados está pronto
echo "Aguardando conexão com o banco de dados..."
until php -r "new PDO('mysql:host=db;port=3306;dbname=laravel', 'laravel', 'secret');" 2>/dev/null; do
    echo "Aguardando o banco de dados ficar pronto..."
    sleep 3
done

echo "Banco de dados conectado com sucesso."

# Instalar dependências do Composer
if [ -f composer.json ]; then
    echo "Instalando dependências do Composer..."
    composer install --no-interaction --prefer-dist
else
    echo "Arquivo composer.json não encontrado. Ignorando instalação do Composer."
fi

# Configurar Laravel Passport (sem recriar tabelas existentes)
if [ -f artisan ]; then
    echo "Configurando Laravel Passport..."

    # Executar migrações gerais
    php artisan migrate --force

    # Gerar chaves do Passport
    php artisan passport:keys --force
    php artisan passport:client --personal --name="Personal Access Client"

else
    echo "Arquivo artisan não encontrado. Ignorando configuração do Passport."
fi

# Gerar chave da aplicação
if [ -f artisan ]; then
    echo "Gerando chave da aplicação..."
    php artisan key:generate
else
    echo "Arquivo artisan não encontrado. Ignorando geração de chave."
fi

# Iniciar o Vite (Frontend)
if [ -f package.json ]; then
    echo "Instalando dependências do NPM..."
    npm install --legacy-peer-deps
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
