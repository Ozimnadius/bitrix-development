# Тип блока: слайдер

Если блок в макете выглядит как слайдер или карусель — есть слайды, pagination, точки, стрелки или carousel-поведение — используется Swiper.

Документация: `https://swiperjs.com/get-started/`, `https://swiperjs.com/swiper-api/`.

Имена в угловых скобках — слоты `PROJECT.md`. В код они не попадают: сначала подставляется значение из контракта, и если слот пуст — сначала бутстрап.

## Структура

`{block}` — имя конкретного BEM-блока.

```html
<div class="{block}__slider">
  <div class="{block}__swiper swiper">
    <div class="{block}__wrapper swiper-wrapper">
      <div class="{block}__slide swiper-slide">
        ...
      </div>
    </div>
  </div>

  <div class="{block}__pagination"></div>

  <div class="{block}__nav">
    <button class="{block}__arrow {block}__arrow--prev" type="button"></button>
    <button class="{block}__arrow {block}__arrow--next" type="button"></button>
  </div>
</div>
```

- класс `swiper` — на `{block}__swiper`, а не на `{block}__slider`;
- `swiper-wrapper` — на `{block}__wrapper`;
- `swiper-slide` — на каждом `{block}__slide`;
- pagination лежит внутри `{block}__slider`, но вне `{block}__swiper`;
- `swiper-pagination` не используется — pagination адресуется BEM-классом блока;
- стрелки всегда внутри `{block}__nav`, классы `{block}__arrow--prev` / `--next`; `swiper-button-prev` и `swiper-button-next` не обязательны.

## Слайды

- Сколько точек pagination показывает макет — столько слайдов, если пользователь не сказал иначе.
- Если раскрыт только первый слайд, остальные заполняются той же структурой и тем же доступным контентом.
- Пустые placeholder-слайды не оставляются, когда контент первого слайда доступен.
- Если для разных слайдов в макете есть свой контент — он переносится в соответствующие слайды.

## JS

`new Swiper(...)` напрямую в шаблоне не вызывается. Инициализация декларативная — через хелпер расширения, обёрнутый в диспетчер готовности:

```js
(() => {
  "use strict";

  window.<APP>.<onReady>(() => {
    window.<APP>.<initSlider>({
      root: ".{block}__slider",
      swiper: ".{block}__swiper",
      pagination: ".{block}__pagination",
      prev: ".{block}__arrow--prev",
      next: ".{block}__arrow--next",
      options: {
        slidesPerView: 1,
        loop: true,
      },
    });
  });
})();
```

Форма конфига — это API конкретного хелпера, она берётся из слота `<initSlider>`, а не копируется отсюда.

Хелпер обязан: находить все блоки по корневому селектору, подставлять pagination и navigation только для заданных и реально найденных узлов, быть защищённым от повторной инициализации и убирать инстансы при подмене DOM.

Если в проекте такого хелпера ещё нет — не вызывать Swiper россыпью по компонентам. Либо завести хелпер в расширении и записать его в контракт, либо, если это разовый случай, инициализировать Swiper прямо в `script.js` внутри диспетчера готовности, с проверкой наличия узла и защитой от повторного вызова.

Расширение подключается из `component_epilog.php`:

```php
\Bitrix\Main\UI\Extension::load("<ns>.swiper");
```

Перед подключением обязательно прочитать `../bitrix-assets.md`: там три правила — кэш, порядок CSS и условная загрузка, — нарушение которых ломает страницу молча или только на кэше. Стили слайдера почти всегда перекрывают библиотечные, то есть правило порядка CSS здесь срабатывает практически всегда.

## Чеклист

- `{block}__slider` не содержит класс `swiper`.
- `{block}__swiper`, `{block}__wrapper` и каждый `{block}__slide` несут свои swiper-классы.
- Pagination находится вне `{block}__swiper` и адресуется BEM-классом.
- Стрелки внутри `{block}__nav`.
- Количество слайдов соответствует pagination в макете, пустых слайдов нет.
- `new Swiper` напрямую не вызывается, инициализация обёрнута в диспетчер готовности.
- Расширение подключено из эпилога, чеклист `../bitrix-assets.md` пройден.
