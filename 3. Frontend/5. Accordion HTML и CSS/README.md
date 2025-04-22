## Аккордион HTML и CSS (без JS)


```html
<div class="accordion">
  <details class="accordion__details " name="faq">
    <summary class="accordion__summary">
      Как и куда сдавать автомобиль?
    </summary>
  </details>
  <div class="accordion__content">
    <div class="accordion__content-body">
      Сдача автомобиля осуществляется на 2 этаже в здании парка. Мойка автомобиля перед сдачей, обязательна. Сдать автомобиль можно с 9:00 до 15:00 в будни. Сдача автомобиля в выходной день и в будни с 15:00 до 21:00 платная - 1000 руб. При сдаче автомобиля после 18:00, аренда начисляется автоматически сразу после сдачи автомобиля. За день сдачи аренда не возвращается.

    </div>
  </div>
  <details class="accordion__details " name="faq">
    <summary class="accordion__summary">
      Как и куда сдавать автомобиль?
    </summary>
  </details>
  <div class="accordion__content">
    <div class="accordion__content-body">
      Сдача автомобиля осуществляется на 2 этаже в здании парка. Мойка автомобиля перед сдачей, обязательна. Сдать автомобиль можно с 9:00 до 15:00 в будни. Сдача автомобиля в выходной день и в будни с 15:00 до 21:00 платная - 1000 руб. При сдаче автомобиля после 18:00, аренда начисляется автоматически сразу после сдачи автомобиля. За день сдачи аренда не возвращается.

    </div>
  </div>
</div>
```

```scss
.accordion{

  &__summary{
    list-style: none;
    cursor: pointer;
    &::-webkit-details-marker {
      display: none;
    }
  }

  &__content {
    display: grid;
    grid-template-rows: 0fr;
    transition-duration: 0.3s;
  }

  &__content-body {
    overflow: hidden;
  }

  &__details[open] + .accordion__content {
    grid-template-rows: 1fr;
  }
}
```






