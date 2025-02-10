## Класс Events для удобного управления событиями.
1. Сильно упрощает работу с событиями, плюс все они в одном месте.
2. Убирает кучу мусорного кода.
3. Чуть позже сделаю его модулем и выложу в npmjs.

```javascript
class Events {

    constructor() {

        this.events = new Set();

        document.addEventListener("DOMContentLoaded", () => {
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
            this.init();
        });
    }

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

        Inputmask("+7(999)-999-99-99", {
            // clearIncomplete: true
        }).mask(form.querySelectorAll('input[type="tel"]'));

        new JustValidate(
            form,
            {
                errorFieldCssClass: 'form__error-input',
                errorLabelCssClass: 'form__error-label'
            }
        ).addField('input[type="tel"]', [
            {
                rule: 'required',
            },
            {
                validator: (name, value) => {
                    const phone = value['input[type="tel"]'].elem.inputmask.unmaskedvalue();
                    return phone.length === 10;
                }
            }
        ]);

        Fancybox.show([{
            src: html,
            type: "html"
        }]);
    }

    sendForm(e, elem) {
        e.preventDefault();

        if (!elem.querySelector('.form__error-input')) {
            fetch(elem.action, {
                method: 'POST',
                body: new FormData(elem)
            }).then(response => response.json()).then((data)=> {
                if (data.status) {
                    this.showSuccess();
                }
                this.disableScrollbar()
            }).catch(function (err) {
                alert('Fetch Error :-S', err);
            });
        }
    }

    showSuccess() {
        Fancybox.close();
        Fancybox.show([{
            src: this.TemplateDom.querySelector(`#success`),
            type: "clone"
        }]);
    }


    disableScrollbar() {
        const htmlElem = document.querySelector('html');
        htmlElem.classList.add('with-fancybox');
        htmlElem.setAttribute('style', '--fancybox-scrollbar-compensate: 0px;');
        document.querySelector("body").classList.add("hide-scrollbar");
    }

    anableScrollbar() {
        const htmlElem = document.querySelector('html');
        htmlElem.classList.remove('with-fancybox');
        htmlElem.setAttribute('style', '');
        document.querySelector("body").classList.remove("hide-scrollbar");
    }

    loadAutodromeItems(e, elem) {
        e.preventDefault();

        document.querySelectorAll('.index-autodromes__item[data-hidden]').forEach(item => {
            item.removeAttribute('data-hidden');
        });
        elem.disabled = true;
    }

}

new Events();
```

Пример как прописывать события:

```html
<!--Первым идет тип события, вторым метод класса-->
<button type="button" data-formid="callback" data-event="click.openForm">
    Подобрать площадку рядом с домом                    
</button>
```

