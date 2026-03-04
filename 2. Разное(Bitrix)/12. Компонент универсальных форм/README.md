## Простой компонент для универсальных форм
Поля тянутся из инфоблока, для каждой формы можно сосздать инфоблок со свойствами. В этот же инфоблок, потом записывается успешная отправка письма.
Все остальные настройки, уже в компонете.

1. components.rar - сам компонент
2. web-comp.rar - это шаблон, для примера
3. sendFrom.php - обработчик отправки и записи в инфоблок. 

Валидация и отправка после валидации
```JS
document.querySelectorAll('.form').forEach(form => {
    Helper.validateForm(form);
  });

  class Events {
  /**
   * Constructor for Events class.
   */
  constructor() {

    this.events = new Set();

    this.setEvents();
    this.init();
  }

  setEvents() {
    document.querySelectorAll(`[data-event]`).forEach(i => {
      i.dataset.event.split(',').forEach((event) => {
        let [eventType, eventName] = event.split('.');

        if (!this[eventName]) return;

        this.events.add(eventType);
      });
    });
    document.querySelector('#templates').content.querySelectorAll(`[data-event]`).forEach(i => {
      i.dataset.event.split(',').forEach((event) => {
        let [eventType, eventName] = event.split('.');

        if (!this[eventName]) return;

        this.events.add(eventType);
      });
    });
  }

  /**
   * Initializes event listeners based on event types.
   */
  init() {

    const body = document.querySelector("body");

    this.events.forEach((type) => {

      body.addEventListener(type, (e) => {
        const target = e.target.closest(`[data-event]`);
        if (!target) return;

        target.dataset.event.split(',').forEach((event) => {
          let [eventType, eventName] = event.split('.');

          if (type !== eventType || !this[eventName]) return;

          this[eventName].call(this, e, target);
        });
      });
    });

  }

  get TemplateDom() {
    return document.querySelector('#templates').content;
  }

  openForm(e, elem) {
    e.preventDefault();
    const formid = elem.dataset.formid;
    const html = this.TemplateDom.querySelector(`#${formid}`).cloneNode(true);
    const form = html.querySelector('form');

    Helper.initForm(form);


    Fancybox.show([{
      html: html,
    }]);
  }

  /**
   * Sends a form using fetch API and handles the response.
   *
   * @param {Event} e - the event object
   * @param {Element} elem - the form element to be submitted
   */
  sendForm(e, elem) {
    if (!elem.querySelector('.form__error-input')) {
      e.preventDefault();
      fetch(elem.action, {
        method: 'POST',
        body: new FormData(elem)
      }).then(response => response.json()).then((data) => {
        if (data.status) {
          elem.reset();
          this.showSuccess();
          // alert("Мы скоро свяжемся с вами.", "Спасибо!");
        } else {
          alert("Произошла ошибка.", data.error);
        }

      }).catch(function (err) {
        alert('Fetch Error :-S', err);
      });
    }
  }

  showSuccess() {
    Fancybox.close();
    Fancybox.show([{
      html: this.TemplateDom.querySelector(`#success`).cloneNode(true),
    }]);
  }

}

class Helper {

  static initForm(form) {
    this.initTel(form);
    this.initSelects(form);
    this.validateForm(form);
  }

  static initTel(form) {
    Inputmask("+7(999)-999-99-99", {
      // clearIncomplete: true
    }).mask(form.querySelectorAll('input[type="tel"]'));
  }

  static initSelects(form) {
    form.querySelectorAll('select').forEach(function (element) {
      new Choices(element, {
        searchEnabled: false,
        itemSelectText: false
      });
    });
  }

  static validateForm(form) {
    let fields = [];
    let fieldsGroup = [];

    form.querySelectorAll('[required]').forEach(el => {
      // debugger;
      let fieldSettings = {
        selector: `[name="${el.name}"]`,
        settings: []
      };

      // Базовое правило required
      fieldSettings.settings.push({
        rule: 'required',
        errorMessage: el.dataset.error || 'Это поле обязательно'
      });

      // Проверяем наличие кастомных валидаторов через data-атрибуты
      if (el.type === 'tel') {
        fieldSettings.settings.push({
          validator: (name, value) => {
            const phone = value[`[name="${el.name}"]`].elem.inputmask.unmaskedvalue();
            return phone.length === 10;
          },
          errorMessage: el.dataset.errorMessage || 'Некорректный телефон'
        });
      }

      if (el.type === 'email') {
        fieldSettings.settings.push({
          rule: 'email',
          errorMessage: el.dataset.errorMessage || 'Некорректный email'
        });
      }

      fields.push(fieldSettings);
    });

    form.querySelectorAll('[data-groroup-required]').forEach(el => {
      // debugger;
      let fieldSettings = {
        selector: `.${el.className}`,
        settings: 'Выберите один из пунктов'
      };

      fieldsGroup.push(fieldSettings);
    });



    const validation = new JustValidate(
      form,
      {
        errorFieldCssClass: 'form__error-input',
        errorLabelCssClass: 'form__error-label',
        successFieldCssClass: 'form__success-input'
      }
    );

    // Проходим по всем полям из вашего объекта
    fields.forEach(field => {
      // Добавляем поле с его правилами валидации
      validation.addField(field.selector, field.settings);
    });
    fieldsGroup.forEach(field => {
      // Добавляем поле с его правилами валидации
      validation.addRequiredGroup(field.selector, field.settings);
    });

  }

  static get TemplateDom() {
    return document.querySelector('#templates').content;
  }

  openForm(e, elem) {
    e.preventDefault();
    const formid = elem.dataset.formid;
    const html = this.TemplateDom.querySelector(`#${formid}`).cloneNode(true);
    const form = html.querySelector('form');

    Helper.initForm(form);

    Fancybox.show([{
      html: html,
    }]);
  }

}
```
