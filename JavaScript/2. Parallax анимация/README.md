## Класс Parallax для параллакс эффекта при скроле страницы.

```javascript
/*Класс меняет offset при скроле у элемента с атрибутом data-parallax*/
class Parallax {
    constructor() {
        this.elements = document.querySelectorAll('[data-parallax]');
        this.init();
    }

    init() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.startAnimation(entry);
                } else {
                    this.stopAnimation(entry);
                }
            });
        });

        this.elements.forEach(i => this.observer.observe(i));
    }

    startAnimation(entry) {
        if (!entry.target._boundAnimate) {
            entry.target._boundAnimate = () => this.animate(entry);
        }
        window.addEventListener('scroll', entry.target._boundAnimate);
    }

    stopAnimation(entry) {
        if (entry.target._boundAnimate) {
            window.removeEventListener('scroll', entry.target._boundAnimate);
            delete entry.target._boundAnimate;
        }
    }

    animate(entry) {
        const rect = entry.target.getBoundingClientRect();
        const offset = window.innerHeight - rect.top - rect.height;
        const modificator = entry.target.dataset.parallaxModificator || 1;
        entry.target.style.setProperty('--offset', `${offset * modificator}px`);
    }
}

new Parallax();
```






