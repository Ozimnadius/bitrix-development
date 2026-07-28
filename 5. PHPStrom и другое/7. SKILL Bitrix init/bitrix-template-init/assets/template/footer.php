<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

    <? // Переменные вычислены в inc/page_vars.php и видны здесь благодаря include в header.php ?>
    <? if (!$isMain): ?>
              </main>
              <!--page__main END-->
          <? if ($showAside): ?>
            </div>
            <!--page__grid END-->
          <? endif; ?>
        </div>
        <!--page END-->
      <? if (!$widePage): ?>
      </div>
      <!--container END-->
      <? endif; ?>
    <? endif; ?>

  </div>
  <!--wrapper__content END-->

  <div class="wrapper__footer">
      <? include_once $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH . '/page_blocks/footer.php' ?>
  </div>

</div>
<!--wrapper END-->

</body>
</html>
