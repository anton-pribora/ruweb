<?php

return [
    'nav' => [
        ['title' => 'Заказы'                , 'href' => ShortUrl(__dir('orders/'))  , 'active' => Url()->matchPath(__dir('orders/'))],
        ['title' => 'Настройки уведомлений' , 'href' => ShortUrl(__dir('settings/')), 'active' => Url()->matchPath(__dir('settings/'))],
        ['title' => 'Вопросы перед покупкой', 'href' => ShortUrl(__dir('faq/'))     , 'active' => Url()->matchPath(__dir('faq/'))],
    ],
];