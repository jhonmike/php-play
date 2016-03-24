# Teste zf2

## 1. Dependencias de Instalação
### Composer

    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

## 2. GIT Clone, Baixe o Repositorio

    SSH: git clone git@github.com:jhonmike/php-play.git
    OR
    HTTP: git clone https://github.com/jhonmike/php-play.git
    cd php-play/apizf2

## 3. Instalação

    composer install

## 4. Config base de dados

DUPLIQUE o arquivo config/autoload/doctrine_orm.local.php.dist para config/autoload/doctrine_orm.local.php e edite as configurações do banco

## 5. Criando o banco e alimentando as tabelas com os seguintes comandos

    composer orm:create
    composer orm:fixture
  
## Outros Comandos
### Apagar banco de dados

    composer orm:drop
    
### Testes PHPUnit
Obs.: "composer test" limpa todo o banco de dados, antes de executar!
    
    composer test
