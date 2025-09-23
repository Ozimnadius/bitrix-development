## Убрать сооющение окончания Демо лицензии
Добавить в файл init.php
```PHP
global $SiteExpireDate;
if (DEMO && ($SiteExpireDate < time())) {
    $SiteExpireDate = time() * 1.1;
}
```
