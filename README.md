## Mirum Framework

A micro framework for MVC applications

Heroku
----------

Link com a aplicação funcionando\
https://mirum-framework.herokuapp.com/

Requisitos
------------

- php 7.1.3 ou maior
- composer


Instalação
------------

Install using composer:

```bash
composer install
```

Banco de Dados
------------
- Crie um banco de dados com o seguinte schema

Mysql
```
create table categories
(
  id   int auto_increment primary key,
  name varchar(191) null
);

create table products
(
  id          int auto_increment primary key,
  name        varchar(191)   null,
  price       decimal(10, 2) null,
  category_id varchar(191)   not null,
  store_id    int            not null
);

create table stores
(
  id      int auto_increment primary key,
  name    varchar(191) not null,
  address varchar(191) null
);

```
Postgresql
```
create table categories
(
  id   serial not null primary key,
  name varchar(191) 
    constraint category_name_uindex unique
);

create table products
(
  id          serial       not null
    constraint products_pkey
      primary key,
  name        varchar(191),
  price       numeric(10, 2),
  category_id integer not null,
  store_id    integer      not null
);

create table stores
(
  id      serial       not null
    constraint stores_pkey
      primary key,
  name    varchar(191) not null,
  address varchar(191)
);

```

Configuração
------------

- Copie o arquivo .env.example e mude o nome para .env
- Defina as variáveis de configuração do banco de dados e variáveis do app dentro do arquivo .env
- Na configuração de host do banco de dados use sempre o ip

Utilização
------------

####Rotas
As rotas são configuradas no arquivo config/routes.php
```
$router->route('/', 'StoreController@index');
```

####Banco de dados
É possível adicionar várias configurações para banco de dados no arquivo config/database.php. Suporte para mysql, postgresql e sqlserver
```

$database->addConfig('db', [
    'driver' => getenv('DB_DRIVER'),
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => getenv('DB_CHARSET'),
    'collation' => getenv('DB_COLLATION'),
    'port'=> getenv('DB_PORT'),
]);

$database->setCurrentConfig('db');
```

####Instruções para o teste

Calcular nota
```
GET /calcula-notas/{nota1}/{nota2}/{nota3}/{nota4}
```

Converter Celsius em Fahrenheit
```
GET /calcula-temperatura/{celsius}
```

Calcular idade em dias
```
GET /calcula-idade/{years}/{months}/{days}
```
