<?php

function Html($html) {
    return htmlentities($html, ENT_COMPAT, 'utf-8');
}

function __dir($path = '') {
    return dirname(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file']) . '/' . ltrim($path, '/');
}

function Redirect($url) {
    header('Location: '. $url);

    while (ob_get_level()) {
        ob_end_clean();
    }

    die;
}