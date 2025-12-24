## Выводим описание для свойств торговых предложений с картинками
В local/templates/template/components/bitrix/catalog.element/.default/result_modifier.php

```PHP
<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (!empty($arResult['SKU_PROPS'])) {
    // Перебираем все свойства SKU
    foreach ($arResult['SKU_PROPS'] as &$property) {
        // Пропускаем свойства, у которых не включен режим отображения картинками
        if (empty($property['SHOW_MODE']) || $property['SHOW_MODE'] !== 'PICT') {
            continue;
        }
        
        // Получаем ID всех значений свойства
        $valueIds = array_column($property['VALUES'], 'ID');
        
        // Пропускаем, если нет значений или не указана таблица highload-блока
        if (empty($valueIds) || empty($property['USER_TYPE_SETTINGS']['TABLE_NAME'])) {
            continue;
        }
        
        // Подключаем модуль highload-блоков
        if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
            try {
                // Получаем highload-блок по имени таблицы
                $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList([
                    'filter' => ['=TABLE_NAME' => $property['USER_TYPE_SETTINGS']['TABLE_NAME']]
                ])->fetch();
                
                if ($hlblock) {
                    // Получаем данные из highload-блока
                    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
                    $entityDataClass = $entity->getDataClass();
                    
                    // Получаем все значения с описаниями
                    $rsValues = $entityDataClass::getList([
                        'select' => ['ID', 'UF_NAME', 'UF_DESCRIPTION'],
                        'filter' => ['ID' => $valueIds]
                    ]);
                    
                    $values = [];
                    while ($value = $rsValues->fetch()) {
                        $values[$value['ID']] = $value;
                    }
                    
                    // Добавляем описания к значениям свойства
                    foreach ($property['VALUES'] as &$propertyValue) {
                        if (isset($values[$propertyValue['ID']])) {
                            $propertyValue['DESCRIPTION'] = $values[$propertyValue['ID']]['UF_DESCRIPTION'];
                        }
                    }
                    unset($propertyValue);
                }
            } catch (\Exception $e) {
                // Логируем ошибку, если что-то пошло не так
                \Bitrix\Main\Diag\Debug::writeToFile(
                    sprintf(
                        'Error in %s: %s\n%s',
                        $property['CODE'] ?? 'unknown',
                        $e->getMessage(),
                        $e->getTraceAsString()
                    ),
                    'hl_props_error.log',
                    'catalog.element'
                );
            }
        }
    }
    unset($property);
}
```