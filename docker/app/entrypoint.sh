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
VITE_API_BASE_URL=http://localhost:8000/api
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

# Adicionar configuração do banco de testes no .env.testing
if [ ! -f .env.testing ]; then
    cp .env .env.testing
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=laravel_testing/' .env.testing
    sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=mysql_testing/' .env.testing
fi

echo "Configuração do .env concluída."

# Verificar conexão com o banco principal
echo "Aguardando conexão com o banco principal..."
until php -r "new PDO('mysql:host=db;port=3306;dbname=laravel', 'laravel', 'secret');" 2>/dev/null; do
    echo "Aguardando o banco principal ficar pronto..."
    sleep 3
done

# Criar o banco de testes
echo "Criando banco de dados de testes, se necessário..."
docker exec mysql-db mysql -u laravel -psecret -e "CREATE DATABASE IF NOT EXISTS laravel_testing;"

# Verificar conexão com o banco de testes
echo "Aguardando conexão com o banco de testes..."
until php -r "new PDO('mysql:host=db;port=3306;dbname=laravel_testing', 'laravel', 'secret');" 2>/dev/null; do
    echo "Aguardando o banco de testes ficar pronto..."
    sleep 3
done

echo "Banco de testes conectado com sucesso."

# Instalar dependências do Composer
if [ -f composer.json ]; then
    echo "Instalando dependências do Composer..."
    composer install --no-interaction --prefer-dist
else
    echo "Arquivo composer.json não encontrado. Ignorando instalação do Composer."
fi

# Gerar chave da aplicação para o ambiente principal
if [ -f artisan ]; then
    echo "Gerando chave da aplicação para o ambiente principal..."
    php artisan key:generate
else
    echo "Arquivo artisan não encontrado. Ignorando geração de chave."
fi

# Executar migrações no banco principal
echo "Executando migrações no banco principal..."
php artisan migrate --force

echo "Executando seeds no banco principal..."
php artisan db:seed

# Configurar Laravel Passport no banco principal
if [ -f artisan ]; then
    echo "Configurando Laravel Passport no banco principal..."
    php artisan passport:keys --force
    php artisan passport:client --personal --name="Personal Access Client"
fi

echo "Verificando conexão com o banco de testes..."
until php -r "new PDO('mysql:host=db;port=3306;dbname=laravel_testing', 'laravel', 'secret');" 2>/dev/null; do
    echo "Banco de testes ainda não está disponível, tentando novamente..."
    sleep 3
done

echo "Banco de testes conectado com sucesso."

# Configurar o banco de testes
echo "Configurando o banco de dados de testes..."
php artisan key:generate --env=testing

# Executar migrações no banco de testes, ignorando tabelas do Passport
echo "Executando migrações no banco de testes (sem tabelas do Passport)..."
php artisan migrate --env=testing --force

# Seeders no banco de testes
echo "Executando seeders no banco de testes..."
php artisan db:seed --env=testing --force

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
