<?php

const PAGE_REGEX = '/^[a-zA-Z][a-zA-Z\/]*[a-zA-Z]$/';
const TEMPLATE_DIR = 'templates/';
const PARAM_DIR = 'parameters/';

function getPaths(string $inputPath) : array
{
    if (!preg_match(PAGE_REGEX, $inputPath)) {
        http_response_code(400);
        die();
    }

    $paramPath = null;
    $templatePath = null;

    if (is_dir(TEMPLATE_DIR . $inputPath)) {
        $templatePath = TEMPLATE_DIR . $inputPath . '/index.php';
        $paramPath = PARAM_DIR . $inputPath . '/index.php';
        if (!is_file($templatePath)) {
            http_response_code(404);
            die();
        }
    } else if (is_file(TEMPLATE_DIR . $inputPath . '.php')) {
        $templatePath = TEMPLATE_DIR . $inputPath . '.php';
        $paramPath = PARAM_DIR . $inputPath . '.php';
    } else {
        http_response_code(404);
        die();
    }

    return [$templatePath, $paramPath];
}

function printPage(string $tP, string $pP) {
    if (is_file($pP)) {
        $paramsDesc = require_once($pP);
        foreach ($paramsDesc as $name => $values) {
            if (!isset($_GET[$name])) {
                http_response_code(400);
                die();
            }
            $paramValue = $_GET[$name];

            if (!is_array($values)) {
                if ($values === 'int') {
                    if (filter_var($paramValue, FILTER_VALIDATE_INT) === false) {
                        http_response_code(400);
                        die();
                    } else {
                        $$name = (int) $paramValue;
                    }
                } else {
                    $$name = $paramValue;
                }
            } else {
                if (!in_array($paramValue, $values)) {
                    http_response_code(400);
                    die();
                } else {
                    $$name = $paramValue;
                }
            }
        }
    }

    require_once(TEMPLATE_DIR . '_header.php');
    require_once($tP);
    require_once(TEMPLATE_DIR . '_footer.php');
}

function main(string $input) {
    $paths = getPaths($input);
    printPage($paths[0], $paths[1]);
}


main($_GET['page']);



