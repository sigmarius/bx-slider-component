<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
// системные названия веток
// - content (контент)
// - service (сервисы)
// - communication (общение)
// - e-store (магазин)
// - utility (служебные)
$arComponentDescription = [
    "NAME" => GetMessage('SLIDER_LIST_NAME'), // имя компонента в дереве
    "DESCRIPTION" => GetMessage('SLIDER_LIST_DESCRIPTION'), // описание компонента, появляется при наведении на иконку в параметрах
    "SORT" => 10, // сортировка в виртуальном дереве редактора
    "CACHE_PATH" => "Y", // ключ для сбрасывания кеша
    "PATH" => [
        "ID" => "sigmarius_content", // id ветки, сделали новую
        "NAME" => GetMessage("SIGMARIUS_COMPONENTS_NAME"), // название компонента в дереве
    ], // директория, в которой размещается компонент
];
