## Убрать сооющение окончания Демо лицензии
bitrix/modules/main/include.php
```PHP
$GLOBALS[___377115506(92)] = OLDSITEEXPIREDATE;
```
Заменить на 

```PHP
$GLOBALS[___377115506(92)] = time() + 86400 * 1;
```
