## Правильное подключение стилей и скриптов в Битрикс.

Есть несколько способов подключения файлов стилей и скриптов, при верстке шаблонов в системе управления 1С-Битрикс. Если
вы получаете готовую верстку в HTML/CSS, то имеет смысл грамотно подключить файлы стилей, js и мета теги при интеграции
шаблона в Битрикс

До выхода нового ядра D7:

```php
// Для подключения скриптов
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/file.js" );

// Подключение css
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/js/file.css", true);

// Подключение мета тегов или сторонних файлов
$APPLICATION->AddHeadString("name='<meta name='yandex-verification' content='62be9ea1' />'");
```

Подключение стилей и скриптов с D7:

```php
use Bitrix\Main\Page\Asset;
// Для подключения css
Asset::getInstance()->addCss("/bitrix/css/main/bootstrap.min.css");
// Для подключения скриптов
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/myscripts.js");
// Подключение мета тегов или сторонних файлов
Asset::getInstance()->addString("<link rel='shortcut icon' href='/local/images/favicon.ico' />");
```

Далее в настройках Битрикс: Настройки- Настройки Модулей -Главный модуль : включаем объединение и сжатие JS файлов,
объединение css файлов.

Подключение стилей и js в шаблонах компонентов:

Если нужно подключить стили и скрипты, внутри шаблонов компонентов. Например, вы используете слайдер, на основе списка
новостей: у него может быть много js и css и не целесообразно, подключать его кишочки, глобально ко всему сайту. Просто
воспользуйтесь такой конструкцией:
```php
$this->addExternalCss("/local/styles.css");
$this->addExternalJS("/local/liba.js");
```