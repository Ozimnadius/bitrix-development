## Анимация чисел от 0 до нужного значения.


```javascript
/*COUNTER*/
const observerCounter = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: [0.1]
});
document
    .querySelectorAll("[data-counter]")
    .forEach((i) => observerCounter.observe(i));

function animateCounter(counter) {
    const target = +counter.getAttribute("data-counter");
    let count = 0;
    const speed = target / 100;

    const updateCounter = () => {
        count += speed;
        if (count < target) {
            counter.innerText = Math.ceil(count);
            requestAnimationFrame(updateCounter);
        } else {
            counter.innerText = target;
        }
    };

    updateCounter();
};
```

```html
<ul>
    <li>
        <div><span data-counter='10'>0</span> лет</div>
        <div>стаж<br>инструкторов</div>
    </li>
    <li>
        <div>><span data-counter='2000'>0</span></div>
        <div>учеников<br>за 2020 год</div>
    </li>
    <li>
        <div>><span data-counter='25'>0</span> лет</div>
        <div>помогаем<br>получить права</div>
    </li>
    <li>
        <div><span data-counter='68'>0</span></div>
        <div>машин<br>в автопарке</div>
    </li>
</ul>
```






