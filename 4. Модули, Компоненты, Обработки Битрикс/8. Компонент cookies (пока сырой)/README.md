```PHP
<?php $APPLICATION->IncludeComponent(
	"web-comp:cookies",
	".default",
	array(
		"BTN_TEXT" => "Принять и закрыть",
		"COOKIE_LIFETIME" => "365",
		"DEBUG" => "N",
		"DELAY" => "2000",
		"TEXT" => "Этот сайт использует файлы cookie для повышения удобства работы. Продолжая пользоваться сайтом, вы даете свое согласие на использование файлов cookie",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
```