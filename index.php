<?php

include_once __DIR__ . '/layout/layout.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'main';

if ($do == 'logout') {
    // Завершаем сессию пользователя
    // session_destroy();
    
    // Редирект на форму авторизации
    header('Location: ?do=login');
    exit();
}
elseif (in_array($do, ['login', 'register', 'help', 'main'])) {
    // Меню для неавторизованных пользовтелей
    include_once __DIR__ . '/layout/menu-for-guest.php';
} else {
    // Меню для авторизованных пользователей
    include_once __DIR__ . '/layout/menu-for-user.php';
}

ob_start();

$page =__DIR__ . '/pages/' . strtr($_SERVER['QUERY_STRING'] ?: 'do=' . $do, ['..' => '__', '/' => '_', '\\' => '_', "\0" => '%00']) . '.txt';

if (file_exists($page)) {
    readfile($page);
} else {
    echo "File not found: $page";
}

header('Content-type: text/html; charset=windows-1251');

Layout()->render(ob_get_clean());