## Добавляем в Bitrix возможность перейти на страницу элемента из админки
Для этого необходимо модифицировать страницу редактирования элемента. Для этого воспользуемся обработчиками событий, в частности события вызова контекстного меню OnAdminContextMenuShow. Для это в файле init.php напишем обработчик события.

```PHP
<? AddEventHandler('main', 'OnAdminContextMenuShow', 'ElementDetailAdminContextMenuShow'); 

function ElementDetailAdminContextMenuShow(&$items){
if ($_SERVER['REQUEST_METHOD']=='GET' && $GLOBALS['APPLICATION']->GetCurPage()=='/bitrix/admin/iblock_element_edit.php' && $_REQUEST['ID']>0)
{
    CModule::IncludeModule('iblock');
    $rsElement = CIBlockElement::GetList(
        $arOrder  = array("ID" => "ASC"),
        $arFilter = array(
            "=IBLOCK_ID" => $_REQUEST['IBLOCK_ID'],
            "=ID" => $_REQUEST['ID'],
        ),
        false,
        false,
        $arSelectFields = array("ID", "NAME", "IBLOCK_ID", "CODE", "DETAIL_PAGE_URL")
    );
    if($arElement = $rsElement->GetNext(true, false)):
        $items[] = array(
            "TEXT"  => "Открыть страницу элемента",
            "LINK"  => $arElement['DETAIL_PAGE_URL'],
            'LINK_PARAM' => 'target=_blank',
            "TITLE" => "Открыть страницу элемента",
            "ICON"  => "adm-btn",
        );    
    endif;
    }
}
```