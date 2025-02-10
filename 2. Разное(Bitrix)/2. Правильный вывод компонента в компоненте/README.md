## Правильный вывод компонента в компоненте.
+ Чтобы в component_epilog.php были доступны нужные свойства используем SetResultCacheKeys. В result_modifier.php пишем:
```php
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
$cp = $this->__component; // объект компонента
if (is_object($cp)) {
    // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
    $cp->arResult['PROPERTIES'] = $arResult['PROPERTIES'];
    $cp->SetResultCacheKeys(array('PROPERTIES'));
}
?>
```
+ В component_epilog.php используем отложенные функции битрикса SetViewTarget.
```php
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<? $this->__template->SetViewTarget('terminal_advantages'); ?>
<? // Список новостей
$APPLICATION->IncludeComponent("bitrix:news.list", "advantages", array(
    "IBLOCK_TYPE" => "aspro_allcorp2_content",    // Тип информационного блока (используется только для проверки)
    "IBLOCK_ID" => "43",    // Код информационного блока
    "NEWS_COUNT" => "6",    // Количество новостей на странице
    "SORT_BY1" => "SORT",    // Поле для первой сортировки новостей
    "SORT_ORDER1" => "ASC",    // Направление для первой сортировки новостей
    "SORT_BY2" => "ACTIVE_FROM",    // Поле для второй сортировки новостей
    "SORT_ORDER2" => "DESC",    // Направление для второй сортировки новостей
    "FILTER_NAME" => "",    // Фильтр
    "FIELD_CODE" => array(    // Поля
        0 => "NAME",
        1 => "PREVIEW_PICTURE",
        2 => "",
    ),
    "PROPERTY_CODE" => array(    // Свойства
        0 => "",
        1 => "",
    ),
    "CHECK_DATES" => "Y",    // Показывать только активные на данный момент элементы
    "DETAIL_URL" => "",    // URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
    "AJAX_MODE" => "N",    // Включить режим AJAX
    "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
    "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
    "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
    "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
    "CACHE_TYPE" => "A",    // Тип кеширования
    "CACHE_TIME" => "3600",    // Время кеширования (сек.)
    "CACHE_NOTES" => "",
    "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
    "CACHE_GROUPS" => "Y",    // Учитывать права доступа
    "PREVIEW_TRUNCATE_LEN" => "",    // Максимальная длина анонса для вывода (только для типа текст)
    "ACTIVE_DATE_FORMAT" => "d.m.Y",    // Формат показа даты
    "SET_TITLE" => "N",    // Устанавливать заголовок страницы
    "SET_BROWSER_TITLE" => "N",    // Устанавливать заголовок окна браузера
    "SET_META_KEYWORDS" => "N",    // Устанавливать ключевые слова страницы
    "SET_META_DESCRIPTION" => "N",    // Устанавливать описание страницы
    "SET_STATUS_404" => "N",    // Устанавливать статус 404
    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",    // Включать инфоблок в цепочку навигации
    "ADD_SECTIONS_CHAIN" => "N",    // Включать раздел в цепочку навигации
    "HIDE_LINK_WHEN_NO_DETAIL" => "N",    // Скрывать ссылку, если нет детального описания
    "PARENT_SECTION" => "",    // ID раздела
    "PARENT_SECTION_CODE" => "",    // Код раздела
    "INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
    "PAGER_TEMPLATE" => ".default",    // Шаблон постраничной навигации
    "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
    "DISPLAY_BOTTOM_PAGER" => "N",    // Выводить под списком
    "PAGER_TITLE" => "Новости",    // Название категорий
    "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
    "PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
    "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
    "COMPONENT_TEMPLATE" => ".default",
    "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
    "STRICT_SECTION_CHECK" => "N",    // Строгая проверка раздела для показа списка
    "DISPLAY_DATE" => "Y",    // Выводить дату элемента
    "DISPLAY_NAME" => "Y",    // Выводить название элемента
    "DISPLAY_PICTURE" => "Y",    // Выводить изображение для анонса
    "DISPLAY_PREVIEW_TEXT" => "Y",    // Выводить текст анонса
    "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
    "SHOW_404" => "N",    // Показ специальной страницы
    "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
),
    false
); ?>
<? $this->__template->EndViewTarget(); ?>
```
+ В файле template.php используем ShowViewContent.
```php
<? $APPLICATION->ShowViewContent('terminal_advantages'); ?>
```
 