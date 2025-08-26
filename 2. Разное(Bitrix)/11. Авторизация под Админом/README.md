## Авторизация под Админом (если нет доступов)

1. Создаем файл ajax/sendForm.php (можно как угодно назвать)
```PHP
<?php
global $USER;
$USER->Authorize(1); 
```