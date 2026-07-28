(() => {
  "use strict";

  const initializers = new Set();
  let isReady = false;

  const runOne = (initializer) => {
    try {
      initializer();
    } catch (error) {
      console.error("[__NS__] инициализатор упал", error);
    }
  };

  const runAll = () => {
    initializers.forEach(runOne);
  };

  const markReady = () => {
    isReady = true;
    runAll();
  };

  // Инициализатор, зарегистрированный после готовности DOM, выполняется сразу:
  // расширения грузятся из эпилогов, то есть позже самого события.
  const onReady = (initializer) => {
    if (typeof initializer !== "function") {
      return;
    }

    initializers.add(initializer);

    if (isReady) {
      runOne(initializer);
    }
  };

  window.__APP__ = window.__APP__ || {};
  window.__APP__.onReady = onReady;

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", markReady, {once: true});
  } else {
    markReady();
  }

  // Повторный прогон при подмене DOM: композитный кэш и ajax.
  // Без этого блоки, приехавшие ajax'ом, остаются неинициализированными.
  if (window.BX && typeof window.BX.addCustomEvent === "function") {
    window.BX.addCustomEvent("onFrameDataReceived", runAll);
    window.BX.addCustomEvent("onAjaxSuccess", runAll);
  }
})();
