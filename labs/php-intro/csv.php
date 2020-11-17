<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function loadCsv(string $filePath) : array
{
    $file = fopen($filePath, 'r'); 

    $res = [];
    while ($row = fgetcsv($file)) {
        $res[$row[0]] = $row;
    }

    return $res;
}

$filePath = 'products.csv';

var_dump(loadCsv($filePath));
