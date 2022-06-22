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
        <li data-bs-target="#sigmarius-slider" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#sigmarius-slider" data-bs-slide-to="1"></li>
        <li data-bs-target="#sigmarius-slider" data-bs-slide-to="2"></li>
    </ol>

    <!--Обертка для слайдов-->
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" data-bs-interval="3000">
            <img src="<?= $templateFolder; ?>/img/slider-1.jpg" alt="Картинка 1">
            <div class="carousel-caption">
                <h3 class="text-uppercase">Адаптивный слайдер</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquet elit lorem, ac congue mi
                    eleifend sit amet. Sed dignissim viverra neque a tristique.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
            <img src="<?= $templateFolder; ?>/img/slider-2.jpg" alt="Картинка 2">
            <div class="carousel-caption">
                <h3 class="text-uppercase">Анимированная прокрутка</h3>
                <p>Aenean cursus imperdiet erat sit amet facilisis. Phasellus congue, sem in consectetur accumsan,
                    tellus risus sollicitudin mauris, quis ornare libero magna eget ex.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
            <img src="<?= $templateFolder; ?>/img/slider-3.jpg" alt="Картинка 3">
            <div class="carousel-caption">
                <h3 class="text-uppercase">Простая установка</h3>
                <p>Praesent dictum, orci eget eleifend auctor, urna ex dapibus odio, vitae pretium neque massa vel
                    neque. Donec et interdum diam. Morbi dignissim vestibulum mi ac viverra.</p>
            </div>
        </div>
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

<script>
    const myCarouselElement = document.getElementById('sigmarius-slider');
    console.log(myCarouselElement);
    const carousel = new bootstrap.Carousel(myCarouselElement, {
        interval: 2000
    });
</script>
