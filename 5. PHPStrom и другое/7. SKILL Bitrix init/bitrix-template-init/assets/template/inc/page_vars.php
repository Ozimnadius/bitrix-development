<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Переменные страницы для каркаса шаблона (header.php, footer.php, page_blocks).
 * Подключается первой строкой header.php; благодаря include видны и в footer.php.
 */

$CurDir = $APPLICATION->GetCurDir();

$isMain = $CurDir === '/'; // на главной каркас .page не строится

// Тема оформления. При одной теме оставить 'dark' или 'light' константой.
// При двух — определять по разделу, например:
// $theme = strpos($CurDir, '/section/') === 0 ? 'light' : 'dark';
$theme = 'dark';

// Флаги из свойств страницы ($APPLICATION->SetPageProperty('...', '...'))
$showTitle = $APPLICATION->GetProperty("show_title") !== 'N';             // заголовок; скрыть: 'N'
$showBreadcrumbs = $APPLICATION->GetProperty("show_breadcrumbs") !== 'N'; // хлебные крошки; скрыть: 'N'
$widePage = $APPLICATION->GetProperty("wide_page") === 'Y';              // страница без .container; включить: 'Y'
$contentLayout = $APPLICATION->GetProperty("content_layout") === 'Y';    // семантическая контентная типографика
$pageMainClass = 'page__main' . ($contentLayout ? ' content' : '');

// Путь запроса глубже каталога физического обработчика = детальная страница SEF-компонента.
// Для SEF-разделов список и детальная — один index.php, различить их можно только по URL.
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (substr($requestPath, -9) === 'index.php') $requestPath = substr($requestPath, 0, -9);
$requestPath = rtrim($requestPath, '/') . '/';

$realFilePath = $_SERVER['REAL_FILE_PATH'] ?? $_SERVER['SCRIPT_NAME'] ?? '';
$sectionPath = rtrim(str_replace('\\', '/', dirname($realFilePath)), '/') . '/';
$isSefDetail = $realFilePath !== '' && $requestPath !== $sectionPath;

// Боковая колонка: на всём разделе ('show_aside' = Y) или только на детальных SEF-страницах ('show_aside_detail' = Y).
// Свойства раздела задаются в .section.php через $arDirProperties.
$showAside = $APPLICATION->GetProperty("show_aside") === 'Y'
    || ($APPLICATION->GetProperty("show_aside_detail") === 'Y' && $isSefDetail);
