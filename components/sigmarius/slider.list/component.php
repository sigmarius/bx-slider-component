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

$arSelectFields = [
    'ID', 
    'NAME', 
    'PREVIEW_TEXT', 
    'PREVIEW_PICTURE', 
    'IBLOCK_ID', // обязательно указывается при выборке свойств методом GetProperties()
    // 'PROPERTY_LINK', // вывод свойств PROPERTY_<PROPERTY_CODE>
    // 'PROPERTY_AUTHOR', // вывод свойств PROPERTY_<PROPERTY_CODE>
    // 'PROPERTY_MULTI' // вывод свойств PROPERTY_<PROPERTY_CODE>
];

// выбираем все свойства инфоблока
$arProperties = CIBlockProperty::GetList(
    ['id' => 'asc'], // array arOrder = Array()
    [
        'ACTIVE' => 'Y',
        'IBLOCK_ID' => $arParams['IBLOCK_ID']
    ], //  array arFilter = Array()
);

while ($property = $arProperties->Fetch()) {
    // чтобы не добавлять каждое свойство по имени => добавляем в массив $arSelectFields поля свойств для последующей передачи в GetList и выборки
    $arSelectFields[] = 'PROPERTY_' . $property['CODE'];
}

$rsElement = CIBlockElement::GetList($arOrder, $arFilter, false, $arNavParams, $arSelectFields);

$arItems = [];
$resultButtons = []; // массив для кнопок Изменить и удалить всплывающей панели

// GetNext - возвращает элементы
// GetNextElement - возвращает элементы вместе со свойствами
while ($objElem = $rsElement->GetNextElement()) {
    // вернули объект со свойствами - достали все поля элементов
    $res = $objElem->GetFields();

    // кнопки Изменить и Удалить для всплывающей панели компонента
    $arButtons = CIBlock::GetPanelButtons(
            $arParams["IBLOCK_ID"], 
            $res['ID'], 
            0,               
            ["SECTION_BUTTONS" => false, "SESSID" => false]
    );

    // массив для редактирования элементов
    $resultButtons['EDIT_LINK'] = $arButtons['edit']['edit_element']['ACTION_URL'];
    $resultButtons['EDIT_LINK_TEXT'] = $arButtons['edit']['edit_element']['TEXT'];

    // массив для удаления элементов
    $resultButtons['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];
    $resultButtons['DELETE_LINK_TEXT'] = $arButtons['edit']['delete_element']['TEXT'];

    // Метод добавляет кнопку, которая открывает указанный URL в popup-окне
    $this->AddEditAction(
        $res['ID'], // Идентификатор_области,
        $resultButtons['EDIT_LINK'], // URL страницы, которая откроется в popup-окне
        $resultButtons['EDIT_LINK_TEXT'], // Название кнопки в toolbar
    );

    // Метод добавляет кнопку удаления элемента
    $this->AddDeleteAction(
        $res['ID'], //Идентификатор_области
        $resultButtons['DELETE_LINK'], // URL страницы, удаляющая указанный элемент
        $resultButtons['DELETE_LINK_TEXT'], // Название кнопки
        [
            "CONFIRM" => GetMessage('SIGMARIUS_DELETE_ELEMENT_CONFIRM'),
        ]
);

    $res['PREVIEW_PICTURE_URL'] = CFile::GetPath($res['PREVIEW_PICTURE']);

    // Возвращает все или некоторые значения свойств элемента
    $res['PROPERTIES'] = $objElem->GetProperties();

    $arItems[] = $res;
}

$arResult = $arItems;

if ($USER->IsAuthorized()) {
    // кнопка Добавить элемент на всплывающей панели компонента
    $arButtons = CIBlock::GetPanelButtons(
                $arParams["IBLOCK_ID"], 
                0, 
                0,               
                ["SECTION_BUTTONS" => false, "SESSID" => false]
            );

    // определяем, активна ли включаемая область (ползунок Режим правки на верхней панели включен)
    if ($APPLICATION->GetShowIncludeAreas()) {
        // добавляем кнопки к всплывающей панели компонента
        $this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

    }
}

$this->IncludeComponentTemplate();
