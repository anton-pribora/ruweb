<?php

// charset cp1251

$layout = Layout();

// Левое меню
$layout->addMenu('/topleftmenu/login/'   , ['text' => 'Вход', 'href' => '?do=login']);
$layout->addMenu('/topleftmenu/register/', ['text' => 'Регистрация', 'href' => '?do=register']);

// Правое меню для примера
$layout->addMenu('/toprightmenu/help/', ['text' => 'Помощь', 'href' => '?do=help']);

$do = isset($_GET['do']) ? $_GET['do'] : 'main';

$map = [
    'login'    => '/topleftmenu/login/',
    'register' => '/topleftmenu/register/',
    
    'help'     => '/toprightmenu/help/',
];

if ($do == 'что-нибудь') {
    // Активация какого-нибудь меню
}
elseif (isset($map[$do])) {
    // Активируем меню без хлебных крошек
    $layout->activateMenu($map[$do], false);
}