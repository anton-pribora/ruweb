# Пример шаблона для биллинговой системы

Настройки конфига для NGINX:

```
server {
    listen *:80;
    server_name dev-ruweb.net;

    root       /www/dev-ruweb.net/docs;
    access_log /www/dev-ruweb.net/logs/access.log;
    error_log  /www/dev-ruweb.net/logs/error.log;
    
    set $phpini "
        error_log=/www/dev-ruweb.net/logs/php-errors.log
    ";

    index index.php;

    location ~ ^.*(/[\w-]*|\.php)$ {
        include fastcgi_params;
        fastcgi_param PHP_VALUE $phpini;
        fastcgi_param SCRIPT_FILENAME $document_root/index.php;
        fastcgi_pass unix:/run/php/php7.1-fpm.sock;
    }
}
```