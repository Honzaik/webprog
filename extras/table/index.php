<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

define('PRODUCTS_PER_PAGE', 10);

function main()
{
    $currentSearch = isset($_GET['search']) ? filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING) : '';
    $currentMaxPrice = (isset($_GET['maxprice']) && preg_match('/^[0-9]+([.][0-9]{2})?$/', $_GET['maxprice'])) ? (float)$_GET['maxprice'] : ''; //todo
    $currentInStock = isset($_GET['instock']) ? '1' : '0';

    $currentParams = '&search=' . $currentSearch . '&maxprice=' . $currentMaxPrice . ($currentInStock === '1' ? '&instock=1' : '');

    $data = getData('data.csv');
    $foundRows = search($data, ($currentSearch !== '') ? $currentSearch : null, ($currentMaxPrice !== '') ? $currentMaxPrice : null, (bool)$currentInStock);

    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 0;

    $possiblePages = (int)ceil(count($foundRows) / PRODUCTS_PER_PAGE);
    if ($currentPage >= $possiblePages) {
        $currentPage = $possiblePages-1;
    }

    if ($currentPage < 0) {
        $currentPage = 0;
    }

    $result = array_slice($foundRows, $currentPage*PRODUCTS_PER_PAGE, PRODUCTS_PER_PAGE);
    $showPagination = ($possiblePages > 1);
    require __DIR__ . '/template.php';
}


function getData(string $path) : array
{
    $file = fopen($path, 'r');
    $data = [];
    $columns = ['isbn' => 0, 'title' => 1, 'author' => 2, 'price' => 3, 'availability' => 4];
    $index = 0;
    while ($row = fgetcsv($file)) {
        if ($index !== 0) {
            $rowObj = new stdClass();
            $rowObj->isbn = $row[$columns['isbn']];
            $rowObj->title = $row[$columns['title']];
            $rowObj->author = $row[$columns['author']];
            $rowObj->price = $row[$columns['price']];
            $rowObj->availability = $row[$columns['availability']];
            $data[] = $rowObj;
        } else {
            $columns['isbn'] = array_search('isbn', $row);
            $columns['title'] = array_search('title', $row);
            $columns['author'] = array_search('author', $row);
            $columns['price'] = array_search('price', $row);
            $columns['availability'] = array_search('availability', $row);
        }
        $index++;
    }
    return $data;
}

function search(array $data, ?string $searchString, ?float $maxPrice, bool $inStock) : array
{
    $matchingRows = [];
    foreach ($data as $row) {
        $rowMatching = true;
        if ($searchString !== null) {
            if (!(strpos($row->isbn, $searchString) !== false || strpos($row->title, $searchString) !== false || strpos($row->author, $searchString) !== false)) {
                $rowMatching = false;
            }
        }

        if ($maxPrice !== null) {
            if ($maxPrice < (float)$row->price) {
                $rowMatching = false;
            }
        }

        if (($row->availability !== 'in stock') && $inStock) {
            $rowMatching = false;
        }

        if ($rowMatching) {
            $matchingRows[] = $row;
        }
    }
    return $matchingRows;
}

main();
