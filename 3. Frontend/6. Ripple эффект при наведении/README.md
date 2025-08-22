## Ripple эффект при наведении (например на кнопки)


```JS
class Ripple {
  constructor(selector, options = {}) {
    this.selector = selector;
    this.settings = Object.assign({
      debug: false,
      on: 'hover',            // 'hover' или 'mousedown'
      origin: 'center',       // 'center' | 'cursor'
      opacity: 0.4,
      color: 'auto',
      multi: false,
      duration: 0.7,
      rate: pxPerSecond => pxPerSecond,
      easing: 'linear'
    }, options);

    // Делегирование событий
    if (this.settings.on === 'hover') {
      // используем mouseover (всплывает), эмулируем mouseenter
      document.addEventListener('mouseover', (e) => {
        const target = e.target.closest(this.selector);
        if (!target) return;
        // если пришли изнутри того же target — игнорируем (эмуляция mouseenter)
        if (target.contains(e.relatedTarget)) return;
        this.trigger(e, target);
      });
    } else {
      // клик/нажатие
      const type = this.settings.on || 'mousedown';
      document.addEventListener(type, (e) => {
        const target = e.target.closest(this.selector);
        if (target) this.trigger(e, target);
      });
    }
  }

  log(...args) {
    if (this.settings.debug) console.log('[Ripple]', ...args);
  }

  trigger(e, el) {
    el.classList.add('has-ripple');

    // data-* как частные настройки элемента
    const data = Object.fromEntries([...el.attributes]
      .filter(a => a.name.startsWith('data-'))
      .map(a => [a.name.replace(/^data-/, ''), a.value]));
    const s = Object.assign({}, this.settings, data);

    // создаём/берём ripple
    let rip;
    if (s.multi || (!s.multi && !el.querySelector('.ripple'))) {
      rip = document.createElement('span');
      rip.className = 'ripple';
      el.appendChild(rip);

      // размер круга = по большей стороне
      if (!rip.offsetWidth && !rip.offsetHeight) {
        const size = Math.max(el.offsetWidth, el.offsetHeight);
        rip.style.width  = `${size}px`;
        rip.style.height = `${size}px`;
      }

      // цвет
      const color = s.color === 'auto' ? getComputedStyle(el).color : s.color;
      rip.style.background = color;
      rip.style.opacity = s.opacity;

      // длительность (возможен перерасчёт rate)
      let duration = Number(s.duration) || 0.7;
      if (typeof s.rate === 'function') {
        const rate = Math.round(rip.offsetWidth / duration);
        const filteredRate = s.rate(rate);
        const newDuration = rip.offsetWidth / filteredRate;
        if (duration.toFixed(2) !== newDuration.toFixed(2)) duration = newDuration;
      }
      rip.style.animationDuration = `${duration}s`;
      rip.style.animationTimingFunction = s.easing;
    }

    if (!s.multi) rip = el.querySelector('.ripple');

    // сброс анимации
    rip.classList.remove('ripple-animate');

    // позиция
    const rect = el.getBoundingClientRect();
    let left, top;

    if (s.origin === 'cursor' && (e.clientX != null && e.clientY != null)) {
      // позиционируем по курсору
      const cx = e.clientX - rect.left;  // координата внутри элемента
      const cy = e.clientY - rect.top;
      left = cx - rip.offsetWidth / 2;
      top  = cy - rip.offsetHeight / 2;
    } else {
      // по центру
      left = rect.width / 2 - rip.offsetWidth / 2;
      top  = rect.height / 2 - rip.offsetHeight / 2;
    }

    rip.style.left = `${left}px`;
    rip.style.top  = `${top}px`;

    // удаляем после анимации в режиме multi
    if (s.multi) {
      rip.addEventListener('animationend', () => rip.remove(), { once: true });
    }

    // форсируем reflow, чтобы класс точно переинициировал анимацию
    // eslint-disable-next-line no-unused-expressions
    void rip.offsetWidth;

    // запуск анимации
    rip.classList.add('ripple-animate');
  }
}

//  Инициализация
new Ripple('.btn-secondary', {
    on: 'hover',
    origin: 'cursor', // поменяй на 'cursor', чтобы появлялось из точки наведения
    duration: 1,
    color: '#1ca53a',
    opacity: 1,
    easing: 'linear',
    multi: true
  });
```

```scss
.ripple {
  position: absolute;
  border-radius: 50%;
  transform: scale(0);
  pointer-events: none;
}

.ripple-animate {
  animation: ripple-animation forwards;
}

@keyframes ripple-animation {
  to {
    transform: scale(2.5);
    opacity: 0;
  }
}
```






