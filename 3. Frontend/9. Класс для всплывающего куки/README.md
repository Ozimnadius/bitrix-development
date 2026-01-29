## Класс для всплывающего куки

```javascript
/**
 * @typedef {Object} CookieConsentOptions
 * @property {string} cookieName - Имя cookie для хранения согласия
 * @property {number} cookieExpiry - Срок действия cookie в днях
 * @property {number} showDelay - Задержка показа баннера в мс
 * @property {string} containerClass - CSS класс контейнера баннера
 * @property {string} btnClass - CSS селектор кнопки принятия
 * @property {string} activeClass - CSS класс для активного состояния
 * @property {boolean} debug - Включить отладочное логирование
 * @property {Function} [onAccept] - Callback при принятии согласия
 */

/**
 * Класс для управления баннером согласия на использование cookie
 * @class
 */
class CookieConsent {
  /**
   * Создает экземпляр CookieConsent
   * @param {CookieConsentOptions} options - Опции конфигурации
   * @param {string} [options.cookieName='cookie_consent_accepted'] - Имя cookie для хранения согласия
   * @param {number} [options.cookieExpiry=365] - Срок действия cookie в днях
   * @param {number} [options.showDelay=2000] - Задержка показа баннера в мс
   * @param {string} [options.containerClass='cookies'] - CSS класс контейнера баннера
   * @param {string} [options.btnClass='.cookies__btn'] - CSS селектор кнопки принятия
   * @param {string} [options.activeClass='active'] - CSS класс для активного состояния
   * @param {boolean} [options.debug=false] - Включить отладочное логирование
   * @param {Function} [options.onAccept] - Callback при принятии согласия
   */
  constructor(options = {}) {
    // Конфигурация по умолчанию
    this.defaults = {
      cookieName: 'cookie_consent_accepted',
      cookieExpiry: 365, // дней
      showDelay: 2000, // задержка в мс
      containerClass: 'cookies',
      btnClass: '.cookies__btn',
      activeClass: 'active',
      debug: false
    };

    // Объединяем настройки
    this.config = {...this.defaults, ...options};
    
    // Сохраняем callback если передан
    this.onAccept = options.onAccept || null;

    // Элементы DOM
    this.container = null;
    this.acceptBtn = null;

    // Флаги
    this.isVisible = false;
    this.consentGiven = false;

    // Привязываем контекст для обработчиков событий
    this.handleAccept = this.handleAccept.bind(this);
    this.init();
  }

  /**
   * Инициализация компонента
   * @returns {void}
   */
  init() {
    // Проверяем, дано ли уже согласие
    this.consentGiven = this.getCookie(this.config.cookieName) === 'true';

    // Если согласие не дано, показываем баннер с задержкой
    if (!this.consentGiven) {
      this.setupDOM();
      this.setupEventListeners();
      this.showWithDelay();
    }

    this.log('CookieConsent инициализирован');
  }

  /**
   * Находим элементы DOM
   * @returns {boolean} - Успешность поиска элементов
   */
  setupDOM() {
    this.container = document.querySelector(`.${this.config.containerClass}`);

    if (!this.container) {
      console.warn(`Cookie контейнер с классом "${this.config.containerClass}" не найден`);
      return false;
    }

    this.acceptBtn = this.container.querySelector(this.config.btnClass);
    return true;
  }

  /**
   * Устанавливаем обработчики событий
   * @returns {void}
   */
  setupEventListeners() {
    if (this.acceptBtn) {
      this.acceptBtn.addEventListener('click', this.handleAccept);
    }
  }

  /**
   * Показать баннер с задержкой
   * @returns {void}
   */
  showWithDelay() {
    if (!this.container || this.consentGiven) return;

    setTimeout(() => {
      this.show();
    }, this.config.showDelay);
  }

  /**
   * Показать баннер
   * @returns {void}
   */
  show() {
    if (!this.container || this.isVisible) return;

    this.container.classList.add(this.config.activeClass);
    this.isVisible = true;

    this.log('Cookie баннер показан');
  }

  /**
   * Скрыть баннер
   * @returns {void}
   */
  hide() {
    if (!this.container || !this.isVisible) return;

    this.container.classList.remove(this.config.activeClass);
    this.isVisible = false;

    this.log('Cookie баннер скрыт');
  }

  /**
   * Обработка принятия куки
   * @returns {void}
   */
  handleAccept() {
    this.setCookie(this.config.cookieName, 'true', this.config.cookieExpiry);
    this.consentGiven = true;
    this.hide();

    this.log('Согласие на куки принято');

    // Вызываем callback если передан
    if (this.onAccept) {
      this.onAccept();
    }

    // Можно добавить кастомное событие
    document.dispatchEvent(new CustomEvent('cookieConsentAccepted'));
  }

  /**
   * Установить куки
   * @param {string} name - Имя куки
   * @param {string} value - Значение куки
   * @param {number} days - Срок действия в днях
   * @returns {void}
   */
  setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = `${name}=${value};${expires};path=/`;
  }

  /**
   * Получить значение куки
   * @param {string} name - Имя куки
   * @returns {string|null} Значение куки
   */
  getCookie(name) {
    const cookieName = name + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');

    for (let i = 0; i < cookieArray.length; i++) {
      let cookie = cookieArray[i];
      while (cookie.charAt(0) === ' ') {
        cookie = cookie.substring(1);
      }
      if (cookie.indexOf(cookieName) === 0) {
        return cookie.substring(cookieName.length, cookie.length);
      }
    }
    return null;
  }

  /**
   * Удалить куки
   * @param {string} name - Имя куки
   * @returns {void}
   */
  removeCookie(name) {
    this.setCookie(name, '', -1);
  }

  /**
   * Проверить, дано ли согласие
   * @returns {boolean} - Статус согласия
   */
  hasConsent() {
    return this.consentGiven;
  }

  /**
   * Сбросить согласие (для тестирования)
   * @returns {void}
   */
  reset() {
    this.removeCookie(this.config.cookieName);
    this.consentGiven = false;
    this.isVisible = false;

    if (this.container) {
      this.container.classList.remove(this.config.activeClass);
      this.container.style.display = 'none';
    }

    this.log('Согласие сброшено');
  }

  /**
   * Логирование для отладки
   * @param {string} message - Сообщение для лога
   * @returns {void}
   */
  log(message) {
    if (this.config.debug) {
      console.log(`[CookieConsent] ${message}`);
    }
  }

  /**
   * Уничтожить экземпляр
   * @returns {void}
   */
  destroy() {
    if (this.acceptBtn) {
      this.acceptBtn.removeEventListener('click', this.handleAccept);
    }

    this.log('CookieConsent уничтожен');
  }
}

new CookieConsent({
      // debug: true
    });
```


