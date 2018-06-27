<?php

use ApCode\Executor\PhpFileExecutor;

include_once __DIR__ . '/bootstrap.php';

$action = Request()->action();
$pages  = __dir('/pages');
$page   = $pages . $action;
$path   = '/';

// Инициализация
foreach (explode('/', rtrim(dirname($action), '/')) as $folder) {
    if ($folder) {
        $path .= "$folder/";
    }
    
    glob_include($pages . $path . "*.init.php");
}

$executor = new PhpFileExecutor($pages);

ob_start();

if ($executor->canExecute($action)) {
    $executor->execute($action);
} else {
    echo 'Файл ' . __dir("/pages$action") . ' не найден';
}

include __dir('/layout.php');