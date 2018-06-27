<?php


function tryToFancyOldCode ($text) {
    $text = preg_replace('~<html>[\s\S]+</style>~', '', $text);
    $text = preg_replace('~<hr><table border=0 cellspacing=0 width=100%><tr><td>RuBill v0.83<br><small>Сгенерировано[\s\S]+~', '', $text);
    $text = preg_replace('~<table border=0 cellspacing=5>[\w\W]+</table><hr>~Ui', '', $text);
    $text = preg_replace('~<script[\w\W]+</script>~Ui', '', $text);
    $text = preg_replace('~<p></p>~Ui', '', $text);
    $text = preg_replace('~<hr><table[\s\S]*?</table>~Uui', '', $text);
    $text = preg_replace_callback('~<table[\s\S]+>~Ui', function($matches) {
        return '<table class="table table-sm">';
    }, $text);
    
    $text = preg_replace('~<table[\s\S]+</table>~U', '<div class="table-responsive">\\0</div>', $text);
    
//     $text = preg_replace_callback('~<select[\s\S]+>~U', function($matches) {
//         return '<select class="form-control">';
//     }, $text);
    
//     $text = preg_replace_callback('~<input([^>]*type=[^>]*(text|password).*>)~Ui', function($matches) {
//         return '<input class="form-control"' . $matches[1];
//     }, $text);
    
    $text = preg_replace_callback('~\\?do=(\w+)~', function($matches) {
        return '#' . $matches[1];
    }, $text);
    
    return $text;
    return '<pre>' . htmlentities($text) .'</pre>';
};
