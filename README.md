# Sobre o Router60

Router60 é um roteador simples (apenas [60 linhas](https://github.com/hackergaucho/routercv/blob/master/router.php) de código) em PHP.

<p align="center">
<img src="logo.png" width="150" height="150">
</p>

## Instalação & utilização

1) Faça o download do script na raiz do site

```bash
wget https://raw.githubusercontent.com/hackergaucho/router60/master/router.php
```

2) Incorpore no código & defina as rotas no "index.php"

```php
<?php
$router=require 'router.php';
$rotas=[
    '/'=>[//raiz do site
        'c'=>'exemplo',
        'v'=>'exemplo'
    ],
    'exemplo'=>[
        'c'=>'exemplo',
        'v'=>'exemplo'
    ],
    '*'=>[//qualquer outra rota
        'c'=>'exemplo',
        'v'=>'exemplo'
    ],
];
$router($rotas, 'http://localhost/site');
```

Definindo o domínio/url do site o RouterCV pode rodar corretamente mesmo dentro de um subdiretório.

3) Crie o controller "c/index.php" (opcional)

```php
<?php
return [
    'msg'=>$request_method.' '.$segment(1, $domain)
];
```

4) Crie a view "v/index.php" (opcional)

```php
<?php
print $msg;
```

5) Crie o "exemplo/index.php"

```php
<?php
require '../index.php';
```

Nesse caso o arquivo "exemplo/index.php" serve como um bypass em servidores ou diretórios que não suportam a reescrita de URL.

## Reescrita de URLs

Caso o servidor Apache suporte a reescrita de URLs basta adicionar um arquivo .htaccess na raiz do site com o seguinte código:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```
