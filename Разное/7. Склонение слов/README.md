## Склонение слов
```php
use Bitrix\Main\Grid\Declension;

$timeDeclension = new Declension('час', 'часа', 'часов');
echo $timeDeclension->get(1); //час
echo $timeDeclension->get(2); //часа
echo $timeDeclension->get(10); //часов
```