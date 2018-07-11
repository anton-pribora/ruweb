<?php

include_once __DIR__ . '/layout/layout.php';
include_once __DIR__ . '/layout/menu.php';

ob_start();

$page =__DIR__ . '/pages/' . strtr($_SERVER['QUERY_STRING'] ?: 'do=login', ['..' => '__', '/' => '_', '\\' => '_', "\0" => '%00']) . '.txt';

if (file_exists($page)) {
    readfile($page);
} else {
    echo "File not found: $page";
}

header('Content-type: text/html; charset=windows-1251');

Layout()->render(ob_get_clean());