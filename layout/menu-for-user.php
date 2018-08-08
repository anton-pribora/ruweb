<?php

// charset cp1251

$layout = Layout();

$layout->addMenu('/topleftmenu/services/'        , ['text' => '������', 'href' => '?do=domains']);
$layout->addMenu('/topleftmenu/services/domains/', ['text' => '������', 'href' => '?do=domains']);
$layout->addMenu('/topleftmenu/services/sites/'  , ['text' => '�����', 'href' => '?do=sites']);
$layout->addMenu('/topleftmenu/services/vds/'    , ['text' => 'VDS', 'href' => '?do=vds']);
$layout->addMenu('/topleftmenu/services/ssl/'    , ['text' => 'SSL', 'href' => '?do=services&page=select&groupid=10']);
$layout->addMenu('/topleftmenu/services/other/'  , ['text' => '������ ������', 'href' => '?do=services']);

$layout->addMenu('/topleftmenu/services/vds/orders/'  , ['text' => '��� VDS', 'href' => '?do=vds']);
$layout->addMenu('/topleftmenu/services/vds/new/'     , ['text' => '�������� VDS', 'href' => '?do=services&page=select&groupid=185&parent=0']);
$layout->addMenu('/topleftmenu/services/vds/settings/', ['text' => '���������', 'href' => '?do=vdsconfig']);
$layout->addMenu('/topleftmenu/services/vds/faq/'     , ['text' => '������� ����� ��������', 'href' => 'http://forum.ruweb.net/forumdisplay.php?fid=34']);

$layout->addMenu('/topleftmenu/services/sites/orders/'  , ['text' => '��� �����', 'href' => '?do=sites']);
$layout->addMenu('/topleftmenu/services/sites/new/'     , ['text' => '�������� ����', 'href' => '?do=addsite']);
$layout->addMenu('/topleftmenu/services/sites/settings/', ['text' => '���������', 'href' => '?do=siteconfig']);

$layout->addMenu('/topleftmenu/news/'   , ['text' => '�������', 'href' => '?do=newsletter']);
$layout->addMenu('/topleftmenu/support/', ['text' => '���������', 'href' => '?do=support']);

// ���. ����
// ���� ����������� �� �������� /topleftmenu/
// � �������� �������������� ���������� ����� ������������ ����� ��������� html, 
// ��� ������ ����������� � ���.
$layout->addMenu('/topleftmenu/menu1/', ['text' => '��������������� ������ (1)', 'href' => '?do=something', 'class' => 'text-danger']);
$layout->addMenu('/topleftmenu/menu2/', ['text' => '��������� ��������� �������� <b class="text-danger">(!)</b>', 'href' => '?do=something']);

// ���. ���� ��� ������
$layout->addMenu('/topleftmenu/menu3/', ['text' => 'Hello', 'onclick' => 'alert("hello")', 'style' => 'cursor: pointer', 'title' => '����� �� ����']);

$layout->addMenu('/toprightmenu/money/'         , ['text' => '������', 'extra' => '2868.11 ���.', 'href' => '?do=balance'])->setDropdown(true);
$layout->addMenu('/toprightmenu/money/balance/' , ['text' => '��������� �����', 'href' => '?do=balance']);
$layout->addMenu('/toprightmenu/money/payment/' , ['text' => '���������', 'href' => '?do=refill&page=select']);
$layout->addMenu('/toprightmenu/money/history/' , ['text' => '������� ��������', 'href' => '?do=history']);
$layout->addMenu('/toprightmenu/money/discount/', ['text' => '�������������� ������', 'href' => '?do=discount']);

$layout->addMenu('/toprightmenu/account/'                , ['text' => '������� #1234', 'href' => '?do=profile'])->setDropdown(true);
$layout->addMenu('/toprightmenu/account/profile/'        , ['text' => '�������', 'href' => '?do=profile']);
$layout->addMenu('/toprightmenu/account/profile/info/'   , ['text' => '������������ ������', 'href' => '?do=profile']);
$layout->addMenu('/toprightmenu/account/profile/history/', ['text' => '��������� ��������', 'href' => '?do=operations']);
$layout->addMenu('/toprightmenu/account/sep1/'           , ['text' => '--']);
$layout->addMenu('/toprightmenu/account/promo/'          , ['text' => '����������', 'href' => '?do=promo']);
$layout->addMenu('/toprightmenu/account/partner/'        , ['text' => '���������� ���������', 'href' => '?do=part']);
$layout->addMenu('/toprightmenu/account/documents/'      , ['text' => '���������', 'href' => '?do=docs']);
$layout->addMenu('/toprightmenu/account/sep2/'           , ['text' => '--']);
$layout->addMenu('/toprightmenu/account/logout/'         , ['text' => '�����', 'href' => '?do=logout']);

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
        $layout->addCrumb('<a href="">������� #' . intval($_GET['id']) . '</a>');
    }
}
elseif ($do == 'viewtrans2' ) {
    $layout->activateMenu('/toprightmenu/money/history/');
    
    if (isset($_GET['transid'])) {
        $layout->addCrumb('<a href="">���������� #' . intval($_GET['transid']) . '</a>');
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
        $layout->addCrumb('<a href="">�������-������� #' . intval($_GET['siteid']) . '</a>');
    }
}
elseif (isset($map[$do])) {
    $layout->activateMenu($map[$do]);
}