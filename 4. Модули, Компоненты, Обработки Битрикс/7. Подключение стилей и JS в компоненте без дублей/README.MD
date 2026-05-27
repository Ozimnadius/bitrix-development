## Подключение стилей и JS в компоненте без дублей
Решает проблему дублирования, если компонент вызывается больше одного раза

```PHP
static $cssAdded = false;
if (!$cssAdded) {
    $cssAdded = true;
    Asset::getInstance()->addCss($templateFolder . '/styles.css');
}
```

Для js аналогично.

```PHP
static $jsAdded = false;
if (!$jsAdded) {
    $jsAdded = true;
    Asset::getInstance()->addCss($templateFolder . '/scripts.css');
}
```

Важно: нельзя называть файлы дефолтными style.css и script.js
