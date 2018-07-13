<?php

// charset cp1251

$layout = Layout();

$layout->addMenu('/services/'        , ['text' => 'Услуги', 'href' => '?do=domains']);
$layout->addMenu('/services/domains/', ['text' => 'Домены', 'href' => '?do=domains']);
$layout->addMenu('/services/sites/'  , ['text' => 'Сайты', 'href' => '?do=sites']);
$layout->addMenu('/services/vds/'    , ['text' => 'VDS', 'href' => '?do=vds']);
$layout->addMenu('/services/ssl/'    , ['text' => 'SSL', 'href' => '?do=services&page=select&groupid=10']);
$layout->addMenu('/services/other/'  , ['text' => 'Другие услуги', 'href' => '?do=services']);

// Доп. меню
// Меню добавляется по префиксу /topmenu/
// В качестве дополнительных параметров можно использовать любые аттрибуты html, 
// они просто добавляются в тэг.
$layout->addMenu('/topmenu/menu1/', ['text' => 'Неподтверждённые заявки (1)', 'href' => '?do=something', 'class' => 'text-danger']);
$layout->addMenu('/topmenu/menu2/', ['text' => 'Выполните активацию аккаунта <b class="text-danger">(!)</b>', 'href' => '?do=something']);

// Доп. меню без ссылки
$layout->addMenu('/topmenu/menu3/', ['text' => 'Hello', 'onclick' => 'alert("hello")', 'style' => 'cursor: pointer', 'title' => 'Нажми на меня']);

$layout->addMenu('/services/vds/orders/'  , ['text' => 'Мои VDS', 'href' => '?do=vds']);
$layout->addMenu('/services/vds/new/'     , ['text' => 'Добавить VDS', 'href' => '?do=services&page=select&groupid=185&parent=0']);
$layout->addMenu('/services/vds/settings/', ['text' => 'Настройки', 'href' => '?do=vdsconfig']);
$layout->addMenu('/services/vds/faq/'     , ['text' => 'Вопросы перед покупкой', 'href' => 'http://forum.ruweb.net/forumdisplay.php?fid=34']);

$layout->addMenu('/services/sites/orders/'  , ['text' => 'Мои сайты', 'href' => '?do=sites']);
$layout->addMenu('/services/sites/new/'     , ['text' => 'Добавить сайт', 'href' => '?do=addsite']);
$layout->addMenu('/services/sites/settings/', ['text' => 'Настройки', 'href' => '?do=siteconfig']);

$layout->addMenu('/news/'   , ['text' => 'Новости', 'href' => '?do=newsletter']);
$layout->addMenu('/support/', ['text' => 'Поддержка', 'href' => '?do=support']);

$layout->addMenu('/money/'         , ['text' => 'Баланс', 'extra' => '2868.11 руб.', 'href' => '?do=balance']);
$layout->addMenu('/money/balance/' , ['text' => 'Состояние счёта', 'href' => '?do=balance']);
$layout->addMenu('/money/payment/' , ['text' => 'Пополнить', 'href' => '?do=refill&page=select']);
$layout->addMenu('/money/history/' , ['text' => 'История операций', 'href' => '?do=history']);
$layout->addMenu('/money/discount/', ['text' => 'Дополнительные скидки', 'href' => '?do=discount']);

$layout->addMenu('/account/'          , ['text' => 'Аккаунт #1234', 'href' => '?do=profile']);
$layout->addMenu('/account/profile/'  , ['text' => 'Профиль', 'href' => '?do=profile']);
$layout->addMenu('/account/promo/'    , ['text' => 'Промоакции', 'href' => '?do=promo']);
$layout->addMenu('/account/partner/'  , ['text' => 'Партнёрская программа', 'href' => '?do=part']);
$layout->addMenu('/account/documents/', ['text' => 'Документы', 'href' => '?do=docs']);

$layout->addMenu('/account/profile/info/'   , ['text' => 'Персональные данные', 'href' => '?do=profile']);
$layout->addMenu('/account/profile/history/', ['text' => 'Последние операции', 'href' => '?do=operations']);

$layout->addMenu('/logout/', ['text' => 'Выход', 'href' => '?do=logout']);

$do = isset($_GET['do']) ? $_GET['do'] : 'main';

$map = [
    'support'    => '/support/',
    'domains'    => '/services/domains/',
    'vds'        => '/services/vds/orders/',
    'vdsconfig'  => '/services/vds/settings/',
    'vdsfaq'     => '/services/vds/faq/',
    'sites'      => '/services/sites/orders/',
    'siteconfig' => '/services/sites/settings/',
    'addsite'    => '/services/sites/new/',
    'balance'    => '/money/balance/',
    'history'    => '/money/history/',
    'discount'   => '/money/discount/',
    'refill'     => '/money/payment/',
    'promo'      => '/account/promo/',
    'profile'    => '/account/profile/info/',
    'operations' => '/account/profile/history/',
    'part'       => '/account/partner/',
    'docs'       => '/account/documents/',
];

if ($do == 'newsletter') {
    $layout->activateMenu('/news/');
    
    if (isset($_GET['id'])) {
        $layout->addCrumb('<a href="">Новость #' . $_GET['id'] . '</a>');
    }
}
elseif ($do == 'viewtrans2' ) {
    $layout->activateMenu('/money/history/');
    
    if (isset($_GET['transid'])) {
        $layout->addCrumb('<a href="">Транзакция #' . $_GET['transid'] . '</a>');
    }
}
elseif ($do == 'services') {
    if (@$_GET['id'] == '12120') {
        $layout->activateMenu('/services/vds/orders/view/');
        $layout->addCrumb('<a href="">#12120</a>');
    }
    else if (@$_GET['groupid'] == '10') {
        $layout->activateMenu('/services/ssl/');
    }
    elseif (@$_GET['groupid'] == '185') {
        $layout->activateMenu('/services/vds/new/');
    }
    else {
        $layout->activateMenu('/services/other/');
    }
}
elseif (isset($map[$do])) {
    $layout->activateMenu($map[$do]);
}