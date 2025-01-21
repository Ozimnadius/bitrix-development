## Преобразование массив Битрикс меню в древовидный массив

Преобразование убогий массив Битриксового меню в древовидный массив (пока только 2 уровня).

В файле result_modifier.php
```php
$arrTree = [];
$parentIndex = 0;
foreach ($arResult as $arItem){
    if ($arItem['DEPTH_LEVEL'] > 1){
        $arrTree[$parentIndex]['ITEMS'][$arItem['ITEM_INDEX']] = $arItem;
    } else{
        $arrTree[$arItem['ITEM_INDEX']] = $arItem;
        $parentIndex = $arItem['ITEM_INDEX'];
    }
}
$arResult = $arrTree;
```