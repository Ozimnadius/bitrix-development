# ozimnad.test

Учебный модуль для изучения разработки модулей 1С-Битрикс.

---

## Структура модуля

```
bitrix/modules/ozimnad.test/
├── include.php                        # Точка входа модуля
├── admin/
│   └── ozimnad_test.php               # Логика страницы в админке
├── install/
│   ├── index.php                      # Класс-установщик (ozimnad_test extends CModule)
│   ├── version.php                    # Версия модуля
│   └── admin/
│       └── ozimnad_test.php           # Обёртка — копируется в bitrix/admin/ при установке
├── lang/
│   └── ru/
│       ├── admin/
│       │   └── ozimnad_test.php       # Переводы для страницы админки
│       └── install/
│           └── index.php              # Переводы для установщика
└── lib/
    ├── AdminMenu.php                  # Обработчик события OnBuildGlobalMenu
    └── Hello.php                      # Пример класса с автозагрузкой
```

---

## Ключевые концепции

### Именование

Модули Битрикс именуются по формату `vendor.name` — всё строчными буквами:
- `vendor` — разработчик (в нашем случае `ozimnad`)
- `name` — название модуля (`test`)

Класс-установщик именуется с заменой точки на подчёркивание: `ozimnad_test`.

Неймспейс для классов в `lib/` строится из имени модуля: `ozimnad.test` → `Ozimnad\Test\`.

### include.php

Подключается каждый раз при вызове `Loader::includeModule('ozimnad.test')`.
Классы из папки `lib/` Битрикс регистрирует **автоматически** — вручную их прописывать не нужно.

```php
// Подключение модуля в любом файле сайта:
\Bitrix\Main\Loader::includeModule('ozimnad.test');
```

### Автозагрузка классов

Все классы в папке `lib/` загружаются автоматически по соглашению:

| Файл | Класс |
|---|---|
| `lib/Hello.php` | `Ozimnad\Test\Hello` |
| `lib/AdminMenu.php` | `Ozimnad\Test\AdminMenu` |
| `lib/Models/Item.php` | `Ozimnad\Test\Models\Item` |

### Установщик (install/index.php)

Класс `ozimnad_test extends CModule` управляет жизненным циклом модуля.

| Метод | Когда вызывается |
|---|---|
| `DoInstall()` | При нажатии "Установить" в админке |
| `DoUninstall()` | При нажатии "Удалить" в админке |
| `InstallFiles()` | Копирует файлы из `install/admin/` в `bitrix/admin/` |
| `UnInstallFiles()` | Удаляет скопированные файлы из `bitrix/admin/` |
| `InstallEvents()` | Регистрирует подписки на события Битрикс |
| `UnInstallEvents()` | Удаляет подписки на события |

`RegisterModule()` — записывает модуль в таблицу `b_module` в БД.
`UnRegisterModule()` — удаляет запись из `b_module`.

### Страницы в админке

Файлы страниц должны лежать **непосредственно** в `bitrix/admin/` (не в подпапках) —
иначе Битрикс строит некорректные относительные ссылки в меню.

Соглашение по именованию файлов: префикс `vendor_module_`:
```
bitrix/admin/ozimnad_test.php           # главная страница
bitrix/admin/ozimnad_test_list.php      # список записей
bitrix/admin/ozimnad_test_detail.php    # детальная страница
```

Файл в `bitrix/admin/` — тонкая обёртка, вся логика живёт в `admin/` папке модуля:
```php
// bitrix/admin/ozimnad_test.php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/ozimnad.test/admin/ozimnad_test.php';
```

Это позволяет изменять страницу **без переустановки** модуля.

Каждая страница обёрнута стандартным прологом и эпилогом:
```php
require_once '...prolog_admin_before.php'; // ядро, авторизация
// ... подключение модуля, настройка заголовка ...
require '...prolog_admin_after.php';       // шапка и меню админки
// ... HTML контент страницы ...
require '...epilog_admin.php';             // подвал админки
```

### Языковые файлы

Путь к lang-файлу **зеркалит** путь к php-файлу относительно папки модуля:

```
admin/ozimnad_test.php  →  lang/ru/admin/ozimnad_test.php
install/index.php       →  lang/ru/install/index.php
```

Использование:
```php
Loc::loadMessages(__FILE__); // загрузить переводы для текущего файла
Loc::getMessage('КЛЮЧ');     // получить строку на текущем языке
```

Ключи принято именовать в формате `VENDOR_MODULE_КЛЮЧ` — чтобы избежать коллизий.

### События

Подписка на событие регистрируется в `InstallEvents()` через `RegisterModuleDependences()`:

```php
RegisterModuleDependences(
    'main',                          // модуль-источник события
    'OnBuildGlobalMenu',             // имя события
    'ozimnad.test',                  // наш модуль
    \Ozimnad\Test\AdminMenu::class,  // класс-обработчик
    'onBuildGlobalMenu'              // метод-обработчик
);
```

Подписка хранится в БД — поэтому регистрируется при установке и удаляется при удалении модуля.

### Меню админки

`OnBuildGlobalMenu` — событие, которое Битрикс выбрасывает при построении левого меню.
Обработчик получает два массива по ссылке:
- `$globalMenu` — разделы главного меню (верхний уровень)
- `$moduleMenu` — пункты внутри существующего раздела

Добавление своего раздела в главное меню:
```php
$globalMenu[] = [
    'menu_id'  => 'ozimnad',       // уникальный ID раздела
    'text'     => 'Ozimnad',       // название раздела
    'sort'     => 90,              // позиция среди всех разделов
    'items_id' => 'menu_ozimnad',  // уникальный ID списка пунктов
    'items'    => [ ... ],         // пункты меню
];
```

---

## Установка

1. Убедитесь что папка `bitrix/modules/ozimnad.test/` присутствует на сервере
2. Перейдите в админку: `Marketplace → Установленные решения`
3. Найдите **Ozimnad Test** и нажмите **Установить**

## Удаление

1. Перейдите в `Marketplace → Установленные решения`
2. Найдите **Ozimnad Test** и нажмите **Удалить**
