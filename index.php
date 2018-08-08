<?php

include_once __DIR__ . '/layout/layout.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'main';

if ($do == 'logout') {
    // ��������� ������ ������������
    // session_destroy();
    
    // �������� �� ����� �����������
    header('Location: ?do=login');
    exit();
}
elseif (in_array($do, ['login', 'register', 'help', 'main'])) {
    // ���� ��� ���������������� ������������
    include_once __DIR__ . '/layout/menu-for-guest.php';
} else {
    // ���� ��� �������������� �������������
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