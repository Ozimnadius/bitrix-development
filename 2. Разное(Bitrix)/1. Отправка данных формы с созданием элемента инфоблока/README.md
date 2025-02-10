## Отправка данных формы с созданием элемента инфоблока.
+ Первым делом создаем инфоблок в который будем добавлять элементы.
+ Создаем форму, для отправки данных, если еще нет.

Пример формы:
```html
<form action="/ajax/sendForm.php" method="post">
    <fieldset>
        <input type="text" name="name" required="" placeholder="*Имя">
        <input type="text" name="company" placeholder="Название компании">
        <input type="tel" name="tel" placeholder="Телефон">
        <input type="email" name="email" required="" placeholder="*e-mail">
        <textarea name="msg" rows="10" placeholder="Сообщение"></textarea>
    </fieldset>
    <button class="btn form__submit" type="submit">Обсудить проект</button>
</form>
```

+ Создаем файл sendForm.php, вот с таким кодом:
```php
header('Content-Type: application/json');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

function sendMail()
{
    $postData = $_POST;

    // Sanitize and validate input data
    $name = htmlspecialchars(trim($postData['name']));
    $company = htmlspecialchars(trim($postData['company']));
    $tel = htmlspecialchars(trim($postData['tel']));
    $email = filter_var($postData['email'], FILTER_VALIDATE_EMAIL);
    $msg = htmlspecialchars(trim($postData['msg']));

    // Validate email
    if (!$email) {
        return false; // Invalid email format
    }

    // Build email content
    $html = "<h3>Обсудим Проект</h3>";
    $html .= "<table>";
    $html .= "<tr><td>Имя: $name</td></tr>";
    $html .= "<tr><td>Компания: $company</td></tr>";
    $html .= "<tr><td>Телефон: $tel</td></tr>";
    $html .= "<tr><td>Email: $email</td></tr>";
    $html .= "</table>";

    try {
        // Send email
        $result = \Bitrix\Main\Mail\Event::send([
            "EVENT_NAME" => 'FEEDBACK_FORM',
            "LID" => "s1",
            "C_FIELDS" => [
                'TEXT' => $html,
            ]
        ]);

        // Save data to the database
        CModule::IncludeModule("iblock");
        $el = new CIBlockElement;
        $fields = [
            "DATE_CREATE" => date("d.m.Y H:i:s"),
            "CREATED_BY" => $GLOBALS['USER']->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => 20,
            "ACTIVE" => "Y",
            "NAME" => "Сообщение от " . date('d.m.Y H:i'),
            "PROPERTY_VALUES" => [
                'name' => $name,
                'company' => $company,
                'tel' => $tel,
                'email' => $email,
                'msg' => $msg,
            ],
        ];

        if ($ID = $el->Add($fields)) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log($e->getMessage(), 0);
        return false;
    }
}

echo json_encode(['status' => sendMail()]);
exit();
```

+ Можно добавить отправку jsоn
```javascript
fetch(elem.action, {
            method: 'POST',
            body: new FormData(elem)
        }).then(response => response.json()).then((data) => {
            console.log(this);
            console.log(data);
        });
```