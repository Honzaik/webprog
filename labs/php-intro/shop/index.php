<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

const ALLOWED_PAGES = ['cart', 'catalog', 'index'];
const TITLES = [
    'index' => 'Welcome',
    'cart' => 'Cart',
    'catalog' => 'Catalog'
];

$currentPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
if (!in_array($currentPage, ALLOWED_PAGES)) {
    $currentPage = 'index';
}

$title = TITLES[$currentPage];

require_once(__DIR__ . '/parts/header.php');

require_once(__DIR__ . '/parts/content/' . $currentPage . '-content.php');

require_once(__DIR__ . '/parts/footer.php');