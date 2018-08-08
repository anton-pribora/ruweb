<?php

// charset cp1251

$layout = Layout();

$layout->addMenu('/topleftmenu/services/'        , ['text' => 'Услуги', 'href' => '?do=domains']);
$layout->addMenu('/topleftmenu/services/domains/', ['text' => 'Домены', 'href' => '?do=domains']);
$layout->addMenu('/topleftmenu/services/sites/'  , ['text' => 'Сайты', 'href' => '?do=sites']);
$layout->addMenu('/topleftmenu/services/vds/'    , ['text' => 'VDS', 'href' => '?do=vds']);
$layout->addMenu('/topleftmenu/services/ssl/'    , ['text' => 'SSL', 'href' => '?do=services&page=select&groupid=10']);
$layout->addMenu('/topleftmenu/services/other/'  , ['text' => 'Другие услуги', 'href' => '?do=services']);

$layout->addMenu('/topleftmenu/services/vds/orders/'  , ['text' => 'Мои VDS', 'href' => '?do=vds']);
$layout->addMenu('/topleftmenu/services/vds/new/'     , ['text' => 'Добавить VDS', 'href' => '?do=services&page=select&groupid=185&parent=0']);
$layout->addMenu('/topleftmenu/services/vds/settings/', ['text' => 'Настройки', 'href' => '?do=vdsconfig']);
$layout->addMenu('/topleftmenu/services/vds/faq/'     , ['text' => 'Вопросы перед покупкой', 'href' => 'http://forum.ruweb.net/forumdisplay.php?fid=34']);

$layout->addMenu('/topleftmenu/services/sites/orders/'  , ['text' => 'Мои сайты', 'href' => '?do=sites']);
$layout->addMenu('/topleftmenu/services/sites/new/'     , ['text' => 'Добавить сайт', 'href' => '?do=addsite']);
$layout->addMenu('/topleftmenu/services/sites/settings/', ['text' => 'Настройки', 'href' => '?do=siteconfig']);

$layout->addMenu('/topleftmenu/news/'   , ['text' => 'Новости', 'href' => '?do=newsletter']);
$layout->addMenu('/topleftmenu/support/', ['text' => 'Поддержка', 'href' => '?do=support']);

// Доп. меню
// Меню добавляется по префиксу /topleftmenu/
// В качестве дополнительных параметров можно использовать любые аттрибуты html, 
// они просто добавляются в тэг.
$layout->addMenu('/topleftmenu/menu1/', ['text' => 'Неподтверждённые заявки (1)', 'href' => '?do=something', 'class' => 'text-danger']);
$layout->addMenu('/topleftmenu/menu2/', ['text' => 'Выполните активацию аккаунта <b class="text-danger">(!)</b>', 'href' => '?do=something']);

// Доп. меню без ссылки
$layout->addMenu('/topleftmenu/menu3/', ['text' => 'Hello', 'onclick' => 'alert("hello")', 'style' => 'cursor: pointer', 'title' => 'Нажми на меня']);

$layout->addMenu('/toprightmenu/money/'         , ['text' => 'Баланс', 'extra' => '2868.11 руб.', 'href' => '?do=balance'])->setDropdown(true);
$layout->addMenu('/toprightmenu/money/balance/' , ['text' => 'Состояние счёта', 'href' => '?do=balance']);
$layout->addMenu('/toprightmenu/money/payment/' , ['text' => 'Пополнить', 'href' => '?do=refill&page=select']);
$layout->addMenu('/toprightmenu/money/history/' , ['text' => 'История операций', 'href' => '?do=history']);
$layout->addMenu('/toprightmenu/money/discount/', ['text' => 'Дополнительные скидки', 'href' => '?do=discount']);

$layout->addMenu('/toprightmenu/account/'                , ['text' => 'Аккаунт #1234', 'href' => '?do=profile'])->setDropdown(true);
$layout->addMenu('/toprightmenu/account/profile/'        , ['text' => 'Профиль', 'href' => '?do=profile']);
$layout->addMenu('/toprightmenu/account/profile/info/'   , ['text' => 'Персональные данные', 'href' => '?do=profile']);
$layout->addMenu('/toprightmenu/account/profile/history/', ['text' => 'Последние операции', 'href' => '?do=operations']);
$layout->addMenu('/toprightmenu/account/sep1/'           , ['text' => '--']);
$layout->addMenu('/toprightmenu/account/promo/'          , ['text' => 'Промоакции', 'href' => '?do=promo']);
$layout->addMenu('/toprightmenu/account/partner/'        , ['text' => 'Партнёрская программа', 'href' => '?do=part']);
$layout->addMenu('/toprightmenu/account/documents/'      , ['text' => 'Документы', 'href' => '?do=docs']);
$layout->addMenu('/toprightmenu/account/sep2/'           , ['text' => '--']);
$layout->addMenu('/toprightmenu/account/logout/'         , ['text' => 'Выход', 'href' => '?do=logout']);

$do = isset($_GET['do']) ? $_GET['do'] : 'main';

$map = [
    'support'    => '/topleftmenu/support/',
    'domains'    => '/topleftmenu/services/domains/',
    'vds'        => '/topleftmenu/services/vds/orders/',
    'vdsconfig'  => '/topleftmenu/services/vds/settings/',
    'vdsfaq'     => '/topleftmenu/services/vds/faq/',
    'sites'      => '/topleftmenu/services/sites/orders/',
    'siteconfig' => '/topleftmenu/services/sites/settings/',
    'addsite'    => '/topleftmenu/services/sites/new/',
    
    'balance'    => '/toprightmenu/money/balance/',
    'history'    => '/toprightmenu/money/history/',
    'discount'   => '/toprightmenu/money/discount/',
    'refill'     => '/toprightmenu/money/payment/',
    'promo'      => '/toprightmenu/account/promo/',
    'profile'    => '/toprightmenu/account/profile/info/',
    'operations' => '/toprightmenu/account/profile/history/',
    'part'       => '/toprightmenu/account/partner/',
    'docs'       => '/toprightmenu/account/documents/',
];

if ($do == 'newsletter') {
    $layout->activateMenu('/topleftmenu/news/');
    
    if (isset($_GET['id'])) {
        $layout->addCrumb('<a href="">Новость #' . intval($_GET['id']) . '</a>');
    }
}
elseif ($do == 'viewtrans2' ) {
    $layout->activateMenu('/toprightmenu/money/history/');
    
    if (isset($_GET['transid'])) {
        $layout->addCrumb('<a href="">Транзакция #' . intval($_GET['transid']) . '</a>');
    }
}
elseif ($do == 'services') {
    if (@$_GET['id'] == '12120') {
        $layout->activateMenu('/topleftmenu/services/vds/orders/view/');
        $layout->addCrumb('<a href="">#12120</a>');
    }
    else if (@$_GET['groupid'] == '10') {
        $layout->activateMenu('/topleftmenu/services/ssl/');
    }
    elseif (@$_GET['groupid'] == '185') {
        $layout->activateMenu('/topleftmenu/services/vds/new/');
    }
    else {
        $layout->activateMenu('/topleftmenu/services/other/');
    }
}
elseif ($do == 'manage') {
    $layout->activateMenu('/topleftmenu/services/sites/orders/');
    
    if (isset($_GET['siteid'])) {
        $layout->addCrumb('<a href="">Хостинг-аккаунт #' . intval($_GET['siteid']) . '</a>');
    }
}
elseif (isset($map[$do])) {
    $layout->activateMenu($map[$do]);
}