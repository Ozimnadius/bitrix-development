## Убрать сооющение окончания Демо лицензии
```PHP
global $SiteExpireDate;
if (DEMO && ($SiteExpireDate < time())) {
    $SiteExpireDate = time() * 1.1;
}
```
