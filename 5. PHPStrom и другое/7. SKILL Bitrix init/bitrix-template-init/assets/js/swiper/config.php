<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Порядок внутри js значим: библиотека идёт перед своим хелпером.
return [
    "js" => ["./vendor/swiper-bundle.min.js", "./swiper-group.js"],
    "css" => "./vendor/swiper-bundle.css",
    "rel" => ["__NS__.core"],
];
