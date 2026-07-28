(() => {
  "use strict";

  const initialized = new WeakSet();
  const instances = new Set();

  // Диспетчер переигрывает инициализаторы при подмене DOM, поэтому старые
  // инстансы нужно убирать: иначе на странице копятся мёртвые слайдеры.
  const sweep = () => {
    instances.forEach((instance) => {
      const element = instance.el;

      if (element && !element.isConnected) {
        instance.destroy(true, true);
        instances.delete(instance);
      }
    });
  };

  const buildOptions = (slider, config) => {
    const options = Object.assign({}, config.options);
    const pagination = config.pagination ? slider.querySelector(config.pagination) : null;
    const prev = config.prev ? slider.querySelector(config.prev) : null;
    const next = config.next ? slider.querySelector(config.next) : null;

    if (pagination) {
      options.pagination = Object.assign({el: pagination, clickable: true}, options.pagination);
    }

    if (prev || next) {
      options.navigation = Object.assign({prevEl: prev, nextEl: next}, options.navigation);
    }

    return options;
  };

  const initSwiperGroup = (config) => {
    if (typeof window.Swiper === "undefined") {
      console.error("[__NS__] Swiper не загружен, слайдер пропущен:", config.root);
      return;
    }

    sweep();

    document.querySelectorAll(config.root).forEach((slider) => {
      const element = slider.querySelector(config.swiper);

      // Защита от повторной инициализации: диспетчер может вызвать хелпер снова.
      if (!element || initialized.has(element)) {
        return;
      }

      initialized.add(element);
      instances.add(new window.Swiper(element, buildOptions(slider, config)));
    });
  };

  window.__APP__ = window.__APP__ || {};
  window.__APP__.initSwiperGroup = initSwiperGroup;
})();
