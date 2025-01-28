<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentDescription = array(
    "NAME" => getMessage("COMPONENT_NAME"),
    "DESCRIPTION" => getMessage("COMPONENT_DESC"),
    "PATH" => array(
        "ID" => "ozimnad",
        "CHILD" => array(
            "ID" => "sample",
            "NAME" => getMessage("COMPONENT_NAME")
        )
    ),
);
?>