## Подключение своего класса

1. Создаем файл local/php_interface/classes/Sample.php
```PHP
<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
class Sample
{
   public static function test(int $a): bool
   {
      return $a > 2;
   }
}
```

2. Создаем файл local/php_interface/autoload.php
```PHP
<?php

Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    'Sample' => '/local/php_interface/classes/Sample.php'
]);
```

3. Создаем файл local/php_interface/init.php
```PHP
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/autoload.php');
```