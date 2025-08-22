## Удобная отправка писем

1. Создаем файл ajax/sendForm.php (можно как угодно назвать)
```PHP
<?php
header('Content-Type: application/json');
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (isset($_POST) && !empty($_POST)) {
  try {
    $fields = $_POST;
    $status = true;

    unset($fields['EVENT_TYPE'], $fields['IBLOCK_ID']);

    // В форме можно указать в скрытом input какое почтовое событие нужно
    if (isset($_POST['EVENT_TYPE']) && !empty($_POST["EVENT_TYPE"])) {
      // Send email
      $result = \Bitrix\Main\Mail\Event::send([
        "EVENT_NAME" => $_POST['EVENT_TYPE'],
        "LID" => "s1",
        "C_FIELDS" => $fields
      ]);
      if (!$result->getId()) {
        $status = false;
      }
    }

    // В форме можно указать в скрытом input какой инфоблок нужен
    if (isset($_POST["IBLOCK_ID"]) && !empty($_POST["IBLOCK_ID"])) {
      // Save data to the database
      CModule::IncludeModule("iblock");
      $el = new CIBlockElement;
      $fields = [
        "DATE_CREATE" => date("d.m.Y H:i:s"),
        "CREATED_BY" => $GLOBALS['USER']->GetID(),
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID" => IntVal($_POST["IBLOCK_ID"]),
        "ACTIVE" => "Y",
        "NAME" => "Сообщение от " . date('d.m.Y H:i'),
        "PROPERTY_VALUES" => $fields
      ];
      if (!$ID = $el->Add($fields)) {
        $status = false;
      }
    }

    if ($status) {
      echo json_encode(array(
        'status' => true
      ));
    } else {
      echo json_encode(array(
        'status' => false
      ));
    }

  } catch (Exception $e) {
    error_log($e->getMessage(), 0);
    echo json_encode(array(
      'status' => false
    ));
  }
}




```