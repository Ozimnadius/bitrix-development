<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$CurDir = $APPLICATION->GetCurDir();
$CurUri = $APPLICATION->GetCurUri();
$isMain = $CurDir === '/';
$showAside = $APPLICATION->GetProperty("show_aside") === 'Y';
$showTitle = $APPLICATION->GetProperty("show_title") === 'Y';
$isContent = $APPLICATION->GetProperty("content_page") === 'Y';
?>
<!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <?
    use Bitrix\Main\Page\Asset;
    use Bitrix\Main\UI\Extension;

    // HEADERS
    $APPLICATION->ShowHead();
    ?>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title><? $APPLICATION->ShowTitle() ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="/local/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/local/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/local/favicon/favicon-16x16.png">
    <link rel="manifest" href="/local/favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="icon" type="image/png" href="<?=SITE_TEMPLATE_PATH ?>/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?=SITE_TEMPLATE_PATH ?>/favicon/favicon.svg" />
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH ?>/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH ?>/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="<?=SITE_TEMPLATE_PATH ?>/favicon/site.webmanifest" />

    <?
    // CSS
    /*//Пример подключения CSS
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/libs/swiper/swiper-bundle.css');*/

    // JS
    /*//Пример подключения JS
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/libs/jquery/dist/jquery.min.js');*/

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/scripts.js');
    ?>
    
</head>
<body>

<!--wrapper-->
<div class="wrapper">
    <div class="wrapper__panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>

    <div class="wrapper__header">
        <? include_once $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH . '/page_blocks/header.php'; ?>
    </div>

    <!--wrapper__content-->
    <div class="wrapper__content">


