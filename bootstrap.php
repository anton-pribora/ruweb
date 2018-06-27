<?php

define('ROOT_DIR', __DIR__);

setlocale(LC_ALL, 'ru_RU.utf8', 'ru_RU');

function glob_include($pattern) {
    foreach (glob($pattern) as $file) {
        include $file;
    }
}

glob_include(ROOT_DIR . '/functions/*.php');
glob_include(ROOT_DIR . '/init/*.php');