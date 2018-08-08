<?php

// charset cp1251

$layout = Layout();

// ����� ����
$layout->addMenu('/topleftmenu/login/'   , ['text' => '����', 'href' => '?do=login']);
$layout->addMenu('/topleftmenu/register/', ['text' => '�����������', 'href' => '?do=register']);

// ������ ���� ��� �������
$layout->addMenu('/toprightmenu/help/', ['text' => '������', 'href' => '?do=help']);

$do = isset($_GET['do']) ? $_GET['do'] : 'main';

$map = [
    'login'    => '/topleftmenu/login/',
    'register' => '/topleftmenu/register/',
    
    'help'     => '/toprightmenu/help/',
];

if ($do == '���-������') {
    // ��������� ������-������ ����
}
elseif (isset($map[$do])) {
    // ���������� ���� ��� ������� ������
    $layout->activateMenu($map[$do], false);
}