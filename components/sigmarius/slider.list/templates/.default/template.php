<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->addExternalCss("https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css");
$this->addExternalJS("https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js");
?>

<div id="sigmarius-slider" class="carousel slide" data-bs-ride="carousel">
    <!--переключатели-->
    <ol class="carousel-indicators">
        <?php 
            $count = 0; 
            foreach($arResult as $arItem): 
        ?>
            <li data-bs-target="#sigmarius-slider" 
                data-bs-slide-to="<?= $count; ?>" 
                <?php if($count === 0): ?>class="active"<?php endif; ?>
            >
            </li>
            <?= $count++ ?>
        <?php endforeach; ?>
    </ol>

    <!--Обертка для слайдов-->
    <div class="carousel-inner" role="listbox">
        <?php 
            $count = 0; 
            foreach($arResult as $arItem): 
        ?>
            <div id="<?=$this->GetEditAreaID($arItem['ID'])?>"
            class="carousel-item <?php if($count === 0): ?>active<?php endif; ?>">
                <img src="<?= $arItem['PREVIEW_PICTURE_URL']; ?>" alt="<?= $arItem['NAME']; ?>">
                <div class="carousel-caption">
                    <?php if($arParams['DISPLAY_NAME'] === 'Y' && $arItem['NAME']): ?>
                        <h3 class="text-uppercase"><?= $arItem['NAME']; ?></h3>
                    <?php endif; ?>
                    <?php if($arParams['DISPLAY_PREVIEW_TEXT'] === 'Y' && $arItem['PREVIEW_TEXT']): ?>
                        <p><?= $arItem['PREVIEW_TEXT']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?= $count++ ?>
        <?php endforeach; ?>
    </div>

    <!--Элементы управления-->
    <button type="button" class="carousel-control-prev" data-bs-target="#sigmarius-slider" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button type="button" class="carousel-control-next" data-bs-target="#sigmarius-slider" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php if(!empty($arParams['INTERVAL'])): ?>
<script>
    const interval = <?= json_encode($arParams['INTERVAL']); ?>;
    const myCarouselElement = document.getElementById('sigmarius-slider');

    const carousel = new bootstrap.Carousel(myCarouselElement, {
        interval: interval
    });
</script>
<?php endif; ?>
