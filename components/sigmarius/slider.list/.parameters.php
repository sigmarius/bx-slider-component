<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
{ 
    return;
} 

// типы инфоблоков
$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

// инфоблоки выбранных типов
$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

// параметры сортировки
$arSorts = array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = array(
        "ID"=>GetMessage("T_IBLOCK_DESC_FID"),
        "NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
        "ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
        "SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
        "TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
    );

// свойства инфоблока
$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(array("sort"=>"asc", "name"=>"asc"), array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
    {
        $arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}

// параметры
$arComponentParameters = array(
    "GROUPS" => array(
        "SIGMARIUS" => [
            "SORT" => 110,
            "NAME" => GetMessage("SIGMARIUS_GROUP_SLIDER"),
        ], // новая группа настроек
    ),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "sigmarius_content", // тип инфоблока по умолчанию
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        "NEWS_COUNT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_CONT"),
            "TYPE" => "STRING",
            "DEFAULT" => "3", // по умолчанию отображается 3 слайда
        ),
        "SORT_BY1" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_IBLOCK_DESC_IBORD1"),
            "TYPE" => "LIST",
            "DEFAULT" => "SORT", // по умолчанию сортировка будет по полю SORT
            "VALUES" => $arSortFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_ORDER1" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_IBLOCK_DESC_IBBY1"),
            "TYPE" => "LIST",
            "DEFAULT" => "DESC",
            "VALUES" => $arSorts,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
        // собственные параметры
        "DISPLAY_NAME" => [
            "PARENT" => "SIGMARIUS", // отображается в группе, созданной в ключе GROUPS
            "NAME" => GetMessage("SIGMARIUS_NAME_SLIDER"),
            "TYPE" => "CHECKBOX", // тип поля
            "DEFAULT" => "Y", // активный по умолчанию
        ], // отображать название слайда
        "DISPLAY_PREVIEW_TEXT" => [
            "PARENT" => "SIGMARIUS", // отображается в группе, созданной в ключе GROUPS
            "NAME" => GetMessage("SIGMARIUS_TEXT_SLIDER"),
            "TYPE" => "CHECKBOX", // тип поля
            "DEFAULT" => "Y", // активный по умолчанию
        ], // отображать текстовое описание слайда
        "INTERVAL" => [
            "PARENT" => "SIGMARIUS", // отображается в группе, созданной в ключе GROUPS
            "NAME" => GetMessage("SIGMARIUS_INTERVAL_SLIDER"),
            "TYPE" => "STRING", // тип поля
            "DEFAULT" => "6000", // значение по умолчанию
        ], // интервал смены слайдов
    ),
);
