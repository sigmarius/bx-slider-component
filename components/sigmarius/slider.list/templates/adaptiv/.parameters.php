<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 

$arResize = [
    'EXACT' => GetMessage('IMAGE_EXACT'),
    'PROPORTIONAL' => GetMessage('IMAGE_PROPORTIONAL'),
    'PROPORTIONAL_ALT' => GetMessage('IMAGE_PROPORTIONAL_ALT'),
];

// основной массив для параметров, задаваемых через шаблон компонента
$arTemplateParameters = [
    'DEFAULT_IMG' => [
        'PARENT' => 'SIGMARIUS', // группа для отображения настройки
        'NAME' => GetMessage('SIGMARIUS_DEFAUL_IMG'), // отображаемое название
        'TYPE' => 'CHECKBOX', // тип настройки
        'DEFAULT' => 'Y', // активен по умолчанию
        'REFRESH' => 'Y', // форма перезагружается при установке чекбокса
    ],
];

// все текущие значения параметров сохраняются в $arCurrentValues
// если чекбокс выключен, отобразятся дополнительные параметры
if ($arCurrentValues['DEFAULT_IMG'] === 'N') {
    $arTemplateParameters = [
    'DEFAULT_IMG' => [
        'PARENT' => 'SIGMARIUS', // группа для отображения настройки
        'NAME' => GetMessage('SIGMARIUS_DEFAUL_IMG'), // отображаемое название
        'TYPE' => 'CHECKBOX', // тип настройки
        'DEFAULT' => '', 
        'REFRESH' => 'Y', // форма перезагружается при установке чекбокса
    ],
    'RESIZE_IMG' => [
        'PARENT' => 'SIGMARIUS', // группа для отображения настройки
        'NAME' => GetMessage('SIGMARIUS_RESIZE_IMG'), // отображаемое название
        'TYPE' => 'LIST', // выпадающий список
        'VALUES' => $arResize, // значения для выпадающего списка
    ],
    'MIN_WIDTH' => [
        'PARENT' => 'SIGMARIUS', // группа для отображения настройки
        'NAME' => GetMessage('SIGMARIUS_MIN_WIDTH'), // отображаемое название
        'TYPE' => 'STRING', // выпадающий список
        'DEFAULT' => '1200', // значение по умолчанию
    ],
    'MIN_HEIGHT' => [
        'PARENT' => 'SIGMARIUS', // группа для отображения настройки
        'NAME' => GetMessage('SIGMARIUS_MIN_HEIGHT'), // отображаемое название
        'TYPE' => 'STRING', // выпадающий список
        'DEFAULT' => '800', // значение по умолчанию
    ],
];
}
