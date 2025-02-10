<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
$cp = $this->__component; // объект компонента
if (is_object($cp)) {
    // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
    $cp->arResult['PROPERTIES'] = $arResult['PROPERTIES'];
    $cp->SetResultCacheKeys(array('PROPERTIES'));
}
?>
