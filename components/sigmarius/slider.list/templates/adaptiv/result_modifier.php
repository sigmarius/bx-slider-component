<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 

switch ($arParams['RESIZE_IMG']) {
    case 'EXACT':
        $arResize = 'BX_RESIZE_IMAGE_EXACT';
        break;
    case 'PROPORTIONAL':
        $arResize = 'BX_RESIZE_IMAGE_PROPORTIONAL';
        break;
    default:
        $arResize = 'BX_RESIZE_IMAGE_PROPORTIONAL_ALT';
        break;
}

if ($arParams['MIN_WIDTH'] <= 0) {
    $arParams['MIN_WIDTH'] = 500;
}

if ($arParams['MIN_HEIGHT'] <= 0) {
    $arParams['MIN_HEIGHT'] = 250;
}

// если не установлен чекбокс "Оригинальный размер" 
if ($arParams['DEFAULT_IMG'] === 'N') {
    foreach ($arResult as $arImage) {
        if ($arImage['PREVIEW_PICTURE'] && $arParams['MIN_HEIGHT'] && $arParams['MIN_WIDTH']) {
            $resizedImg = CFile::ResizeImageGet(
                $arImage['PREVIEW_PICTURE'],
                [
                    'width' => $arParams['MIN_WIDTH'],
                    'height' => $arParams['MIN_HEIGHT'],
                ],
                $arResize,
                false
            ); 

            // возвращает размер изображения, тип файла и высоту/ширину текстовой строки, используемой внутри тега <img>
            $arSize = getimagesize($_SERVER['DOCUMENT_ROOT'] . $resizedImg['src']);

            // делаем новый ключ для оптимизированного изображения
            $arImage['PREVIEW_IMAGE'] = [
                'SRC' => $resizedImg['src'],
                'WIDTH' => (int)$arSize[0],
                'HEIGHT' => (int)$arSize[1],
            ];

            $arItems[] = $arImage;
        }
    }

    $arResult = $arItems;
}

foreach ($arResult as $key => $arItem) {
    $arResult[$key]['PREVIEW_TEXT'] = TruncateText($arItem['PREVIEW_TEXT'], 75);
}


