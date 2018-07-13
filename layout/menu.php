<?php

// charset cp1251

$layout = Layout();

$layout->addMenu('/services/'        , ['text' => '������', 'href' => '?do=domains']);
$layout->addMenu('/services/domains/', ['text' => '������', 'href' => '?do=domains']);
$layout->addMenu('/services/sites/'  , ['text' => '�����', 'href' => '?do=sites']);
$layout->addMenu('/services/vds/'    , ['text' => 'VDS', 'href' => '?do=vds']);
$layout->addMenu('/services/ssl/'    , ['text' => 'SSL', 'href' => '?do=services&page=select&groupid=10']);
$layout->addMenu('/services/other/'  , ['text' => '������ ������', 'href' => '?do=services']);

// ���. ����
// ���� ����������� �� �������� /topmenu/
// � �������� �������������� ���������� ����� ������������ ����� ��������� html, 
// ��� ������ ����������� � ���.
$layout->addMenu('/topmenu/menu1/', ['text' => '��������������� ������ (1)', 'href' => '?do=something', 'class' => 'text-danger']);
$layout->addMenu('/topmenu/menu2/', ['text' => '��������� ��������� �������� <b class="text-danger">(!)</b>', 'href' => '?do=something']);

// ���. ���� ��� ������
$layout->addMenu('/topmenu/menu3/', ['text' => 'Hello', 'onclick' => 'alert("hello")', 'style' => 'cursor: pointer', 'title' => '����� �� ����']);

$layout->addMenu('/services/vds/orders/'  , ['text' => '��� VDS', 'href' => '?do=vds']);
$layout->addMenu('/services/vds/new/'     , ['text' => '�������� VDS', 'href' => '?do=services&page=select&groupid=185&parent=0']);
$layout->addMenu('/services/vds/settings/', ['text' => '���������', 'href' => '?do=vdsconfig']);
$layout->addMenu('/services/vds/faq/'     , ['text' => '������� ����� ��������', 'href' => 'http://forum.ruweb.net/forumdisplay.php?fid=34']);

$layout->addMenu('/services/sites/orders/'  , ['text' => '��� �����', 'href' => '?do=sites']);
$layout->addMenu('/services/sites/new/'     , ['text' => '�������� ����', 'href' => '?do=addsite']);
$layout->addMenu('/services/sites/settings/', ['text' => '���������', 'href' => '?do=siteconfig']);

$layout->addMenu('/news/'   , ['text' => '�������', 'href' => '?do=newsletter']);
$layout->addMenu('/support/', ['text' => '���������', 'href' => '?do=support']);

$layout->addMenu('/money/'         , ['text' => '������', 'extra' => '2868.11 ���.', 'href' => '?do=balance']);
$layout->addMenu('/money/balance/' , ['text' => '��������� �����', 'href' => '?do=balance']);
$layout->addMenu('/money/payment/' , ['text' => '���������', 'href' => '?do=refill&page=select']);
$layout->addMenu('/money/history/' , ['text' => '������� ��������', 'href' => '?do=history']);
$layout->addMenu('/money/discount/', ['text' => '�������������� ������', 'href' => '?do=discount']);

$layout->addMenu('/account/'          , ['text' => '������� #1234', 'href' => '?do=profile']);
$layout->addMenu('/account/profile/'  , ['text' => '�������', 'href' => '?do=profile']);
$layout->addMenu('/account/promo/'    , ['text' => '����������', 'href' => '?do=promo']);
$layout->addMenu('/account/partner/'  , ['text' => '���������� ���������', 'href' => '?do=part']);
$layout->addMenu('/account/documents/', ['text' => '���������', 'href' => '?do=docs']);

$layout->addMenu('/account/profile/info/'   , ['text' => '������������ ������', 'href' => '?do=profile']);
$layout->addMenu('/account/profile/history/', ['text' => '��������� ��������', 'href' => '?do=operations']);

$layout->addMenu('/logout/', ['text' => '�����', 'href' => '?do=logout']);

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
        $layout->addCrumb('<a href="">������� #' . $_GET['id'] . '</a>');
    }
}
elseif ($do == 'viewtrans2' ) {
    $layout->activateMenu('/money/history/');
    
    if (isset($_GET['transid'])) {
        $layout->addCrumb('<a href="">���������� #' . $_GET['transid'] . '</a>');
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