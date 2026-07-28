(() => {
  "use strict";

  let isBound = false;

  window.__APP__.onReady(() => {
    // Bind делегирующий, поэтому вешается один раз на весь документ:
    // повторный прогон диспетчера не должен создавать второй биндинг.
    if (isBound) {
      return;
    }

    if (!window.Fancybox) {
      console.error("[__NS__] Fancybox не загружен");
      return;
    }

    window.Fancybox.bind("[data-fancybox]");
    isBound = true;
  });
})();
