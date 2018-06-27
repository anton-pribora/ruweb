<?php

/**
 * @return \ApCode\Template\Layout\Layout
 */
function Layout($layout = NULL) {
    static $layouts;

    if (empty($layout)) {
        $layout = 'default';
    }

    if (empty($layouts[$layout])) {
        $layouts[$layout] = new \ApCode\Template\Layout\Layout($layout, PathAlias());
    }

    return $layouts[$layout];
}


/**
 * @return \ApCode\Alias\AliasInterface
 */
function UrlAlias() {
    static $alias;

    if (empty($alias)) {
        $alias = new ApCode\Alias\Alias();
    }

    return $alias;
}

/**
 * @return \ApCode\Alias\AliasInterface
 */
function PathAlias() {
    static $alias;

    if (empty($alias)) {
        $alias = new ApCode\Alias\Alias();
    }

    return $alias;
}

function ExpandPath($alias) {
    return PathAlias()->expand($alias);
}

function ExpandUrl($alias) {
    return UrlAlias()->expand($alias);
}

function Asset($path) {
    static $asset;

    if (empty($asset)) {
        $asset = new ApCode\Template\Asset\Asset(PathAlias(), UrlAlias());
    }

    return $asset->urlTo($path);
}

/**
 * @return \ApCode\Template\Template
 */
function Template() {
    static $template;

    if (empty($template)) {
        $template = new ApCode\Template\Template();
        $template->setAlias(PathAlias());
    }

    return $template;
}

/**
 * @return \ApCode\Web\Request\Http
 */
function Request() {
    static $request;

    if (empty($request)) {
        $request = new \ApCode\Web\Request\Http();
    }

    return $request;
}

/**
 * @return \ApCode\Web\UrlManager
 */
function Url() {
    static $urlManager;

    if (empty($urlManager)) {
        $urlManager = new \ApCode\Web\UrlManager\Routed(Request()->fullUri(), UrlAlias());
    }

    return $urlManager;
}

/**
 * @param unknown $path
 * @param array $params
 * @param string $replaceParams
 * @return \ApCode\Web\Url
 */
function ShortUrl($path, $params = [], $replaceParams = FALSE) {
    return Url()->shortUrl($path, $params, $replaceParams);
}

function ShortLink($text, $url, $class = '') {
    return sprintf('<a href="%s" class="%s">%s</a>', $url, $class, $text);
}

/**
 * @param unknown $path
 * @param array $params
 * @param string $replaceParams
 * @return \ApCode\Web\Url
 */
function FullUrl($path, $params = [], $replaceParams = FALSE) {
    return Url()->fullUrl($path, $params, $replaceParams);
}

/**
 * @param string $path
 * @param array $params
 * @return \ApCode\Web\Url
 */
function ExternalUrl($path, $params = []) {
    static $urlManager;
    
    if (empty($urlManager)) {
        $urlManager = new \ApCode\Web\UrlManager(Request()->fullUri(), UrlAlias());
    }
    
    return $urlManager->fullUrl($path, $params);
}

/**
 * @param string $name
 * @return \ApCode\Misc\Timer
 */
function Timer($name = 'default') {
    static $timers = [];

    if (empty($timers[$name])) {
        $timers[$name] = new ApCode\Misc\Timer();
    }

    return $timers[$name];
}

/**
 * @return ApCode\Web\Pagination
 */
function Pagination() {
    static $pagination;

    if (empty($pagination)) {
        $pagination = new ApCode\Web\Pagination();
        $pagination->setUrl(Url()->shortUrl('', $_GET), true);
    }

    return $pagination;
}

/**
 * @param string $path
 * @return \ApCode\Misc\FileMeta\FileMeta
 */
function Meta($path) {
    return ApCode\Misc\FileMeta\MetaManager::fileMeta($path);
}
