# RouterCV

RouterCV é um roteador simples em PHP com apenas [60 linhas de código](https://github.com/hackergaucho/routercv/blob/master/router.php).

## Instalação & utilização

1) Faça o download do script na raiz do site

```bash
wget https://tinyurl.com/routercv -O router.php
```

2) Incorpore no código & defina as rotas

```php
<?php
$router=require 'router.php';
$rotas=[
    '/'=>[//raiz do site
        'c'=>'exemplo'
        'v'=>'exemplo'
    ],
    'exemplo'=>[
        'c'=>'exemplo'
        'v'=>'exemplo'
    ],
    '*'=>[//qualquer outra rota
        'c'=>'exemplo'
        'v'=>'exemplo'
    ],
]
$router($rotas,'http://localhost/site');
```

É importante definir o domínio/url da raíz do site, assim o RouterCV pode rodar corretamente mesmo estando dentro de um diretório.

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

5) Cria o exemplo/index.php

```php
<?php
require '../index.php';
```

Nesse caso o arquivo "exemplo/index.php" serve como um bypass em servidores ou diretórios que não suportam a reescrita de URL.

Caso o servidor Apache suporte a reescrita de URLs basta adicionar um arquivo .htaccess na raiz do site com o seguinte código:

```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```
