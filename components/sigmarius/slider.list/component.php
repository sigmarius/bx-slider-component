<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$arParams['INTERVAL'] = (int)$arParams['INTERVAL'];
if (strlen($arParams['INTERVAL']) < 3) {
    $arParams['INTERVAL'] = 6000;
}

$arParams['NEWS_COUNT'] = (int)$arParams['NEWS_COUNT'];
if ($arParams['NEWS_COUNT'] <= 0) {
    $arParams['NEWS_COUNT'] = 1;
}

$arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
if (strlen($arParams['IBLOCK_TYPE']) <= 0) {
    $arParams['IBLOCK_TYPE'] = 'sigmarius_content';
}

$arParams['IBLOCK_ID'] = trim($arParams['IBLOCK_ID']);

$arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
if($arParams["SORT_BY1"] == '') {
    $arParams["SORT_BY1"] = "SORT";
}
    
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"])) {
    $arParams["SORT_ORDER1"]="DESC";
}

if(!CModule::IncludeModule("iblock"))
{ 
    return;
} 

$arOrder = [
    $arParams['SORT_BY1'] => $arParams["SORT_ORDER1"],
];

$arFilter = [
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
    'IBlOCK_ID' => $arParams['IBLOCK_ID'],
    'ACTIVE' => 'Y'
];

$arNavParams = [
    nTopCount => $arParams['NEWS_COUNT']
];

$arSelectFields = ['ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE'];

$rsElement = CIBlockElement::GetList($arOrder, $arFilter, false, $arNavParams, $arSelectFields);

$arItems = [];

while ($res = $rsElement->GetNext()) {
    $res['PREVIEW_PICTURE_URL'] = CFile::GetPath($res['PREVIEW_PICTURE']);

    $arItems[] = $res;
}

$arResult = $arItems;

$this->IncludeComponentTemplate();
