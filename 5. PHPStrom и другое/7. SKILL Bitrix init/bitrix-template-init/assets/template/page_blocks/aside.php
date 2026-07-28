<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? // Содержимое боковой колонки текущего раздела: файл sect_aside.php рядом с index.php раздела
$APPLICATION->IncludeComponent(
  "bitrix:main.include",
  ".default",
  [
    "AREA_FILE_SHOW" => "sect",
    "AREA_FILE_SUFFIX" => "aside",
    "AREA_FILE_RECURSIVE" => "N",
    "EDIT_TEMPLATE" => "",
    "COMPONENT_TEMPLATE" => ".default"
  ],
  false
); ?>

<? // Отложенный слот: шаблон компонента может дописать сюда контент через $APPLICATION->AddViewContent('aside', ...)
$APPLICATION->ShowViewContent('aside'); ?>
