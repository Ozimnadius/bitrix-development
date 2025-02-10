## Простая анимация при появлении элемента в зоне видимости.

За анимацию отвечает css, а класс добавляет класс animated при появллении элемента в зоне видимости.

```javascript
const observer10 = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animated');
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: [0.1]
});
document
    .querySelectorAll('[data-animate="observer10"]')
    .forEach((i) => observer10.observe(i));
```

```html

<div class="line"
     data-animate="observer10">
</div>
<style>
    .line {
        width: 0;
        height: 1px;
        background-color: #000;

        &.animated {
            animation: LINE 1s ease-in-out both;
        }
    }

    @keyframes LINE {
        0% {
            width: 0;
        }
        100% {
            width: 100%;
        }
    }
</style>
```






