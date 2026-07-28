<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/inc/page_vars.php';
?>
<!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <?
    use Bitrix\Main\Page\Asset;
    use Bitrix\Main\UI\Extension;

    $APPLICATION->ShowHead();
    ?>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title><? $APPLICATION->ShowTitle() ?></title>

    <link rel="icon" href="<?= SITE_TEMPLATE_PATH ?>/favicon/favicon.ico">

    <?
    // Вендорные CSS и JS подключаются только через расширения — см. local/js/__NS__/
    // Диспетчер __APP__.onReady грузится глобально: скрипты компонентов рассчитывают,
    // что он есть всегда. Библиотеки грузятся точечно из component_epilog.php.
    Extension::load(['__NS__.base-css', '__NS__.core']);

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/scripts.js');
    ?>
</head>
<body data-theme="<?= $theme ?>">

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
    <? if (!$isMain): ?>
      <? if (!$widePage): ?>
        <!--container-->
        <div class="container">
      <? endif; ?>
        <!--page-->
        <div class="page">
          <? if ($showBreadcrumbs): ?>
            <div class="page__breadcrumbs">
                <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", [
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => SITE_ID,
                ]); ?>
            </div>
          <? endif; ?>

          <? if ($showTitle): ?>
            <h1 class="page__title"><? $APPLICATION->ShowTitle(false); ?></h1>
          <? endif; ?>

          <? if ($showAside): ?>
            <!--page__grid-->
            <div class="page__grid">
              <aside class="page__aside">
                  <? include_once $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH . '/page_blocks/aside.php'; ?>
              </aside>
              <!--page__main-->
              <main class="<?= $pageMainClass ?>">
          <? else: ?>
              <!--page__main-->
              <main class="<?= $pageMainClass ?>">
          <? endif; ?>
    <? endif; ?>
