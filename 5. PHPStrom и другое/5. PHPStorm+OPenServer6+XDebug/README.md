# Настройка 
В папке C:\OSPanel\config\PHP-8.4\default\templates редактируем файл php.ini

```ini
zend_extension                       = xdebug
xdebug.client_host                   = "localhost"
xdebug.client_port                   = 9003 
xdebug.idekey                        =  'PHPSTORM'
xdebug.mode                            = "debug"
xdebug.start_with_request            = "yes" 
```
Перезапускаем сервер и настраиваем PhpStorm