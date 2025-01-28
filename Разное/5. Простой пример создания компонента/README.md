## Простой пример создания компонента

1. Нужно создать свое пространство имен (создаем папку) /local/components/ozimnad/sample/
2. Создаем папку /local/components/ozimnad/sample/templates/.default/
    1. В ней создаем файл template.php
3. Создаем папку lang пример выше или в архиве.
4. Создаем компонент в /local/components/ozimnad/sample/:
    1. component.php
    2. .description.php
    3. .parameters.php

В component.php:

```php
<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['DATE'] = date($arParams["TEMPLATE_FOR_DATE"]);
$this->IncludeComponentTemplate();
?>
```

В .description.php:

```php
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentDescription = array(
    "NAME" => getMessage("COMPONENT_NAME"),
    "DESCRIPTION" => getMessage("COMPONENT_DESC"),
    "PATH" => array(
        "ID" => "ozimnad",
        "CHILD" => array(
            "ID" => "sample",
            "NAME" => getMessage("COMPONENT_NAME")
        )
    ),
);
?>
```

В .parameters.php:

```php
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
		"TEMPLATE_FOR_DATE" => array(
			"PARENT" => "BASE",
			"NAME" => "Шаблон для даты",
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "Y-m-d",
		),
	),
);
?>
```

В templates/.default/template.php:

```php
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
echo $arResult['DATE'];
?>
```

После этого можно вызвать компонет либо с помощью визуального редактора либо с помощью кода на странице:
```php
<?$APPLICATION->IncludeComponent(
	"ozimnad:sample",
	"",
	Array(
		"TEMPLATE_FOR_DATE" => "Y-m-d"
	)
);?>
```
