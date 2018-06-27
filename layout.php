<?php 

$menu = [
    '/services/' => [
        ['Домены', '/services/domains/'],
        ['Сайты', '/services/sites/'],
        ['VDS', '/services/vds/'],
        ['SSL', '/services/ssl/'],
        ['Другие услуги', '/services/other/'],
    ],
    '/money/' => [
        ['Состояние счёта', '/money/balance/'],
        ['История операций', '/money/history/'],
    ],
    '/account/' => [
        ['Профиль', '/account/profile/'],
        ['Промоакции', '/account/promo/'],
        ['Партнёрская программа', '/account/partner/'],
        ['Документы', '/account/documents/'],
    ],
];

$leftMenu = [];

foreach ($menu as $url => $items) {
    if (Request()->matchAction($url)) {
        $leftMenu = $items;
        break;
    }
}

$pageLink = function($text, $action, $class = '') {
    $active = Request()->matchAction($action) ? ' active' : '';
    return sprintf('<a href="%s" class="%s">%s</a>', ShortUrl($action), $class . $active, $text);
};

$navLink = function ($text, $action) use ($pageLink) {
    return $pageLink($text, $action, "nav-link");
};

$dropdownLink = function ($text, $action) use ($pageLink) {
    return $pageLink($text, $action, "dropdown-item");
};

$output = [];

while (ob_get_level()) {
    array_unshift($output, ob_get_clean());
}

$content = join($output);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruweb Billing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/4.1.1/sandstone/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="https://unpkg.com/@bootstrapstudio/bootstrap-better-nav/dist/bootstrap-better-nav.min.css">
    <style type="text/css">
.footer-basic {
  padding:20px 0;
  background-color:#ffffff;
  color:#4b4c4d;
}

.footer-basic ul {
  padding:0;
  list-style:none;
  text-align:center;
  /*font-size:18px;*/
  line-height:1.6;
  margin-bottom:0;
}

.footer-basic li {
  padding:0 10px;
}

.footer-basic ul a {
  color:inherit;
  text-decoration:none;
  opacity:0.8;
}

.footer-basic ul a:hover {
  opacity:1;
}

.footer-basic .social {
  text-align:center;
  padding-bottom:25px;
}

.footer-basic .social > a {
  font-size:24px;
  width:40px;
  height:40px;
  line-height:40px;
  display:inline-block;
  text-align:center;
  border-radius:50%;
  border:1px solid #ccc;
  margin:0 8px;
  color:inherit;
  opacity:0.75;
}

.footer-basic .social > a:hover {
  opacity:0.9;
}

.footer-basic .copyright {
  margin-top:15px;
  text-align:center;
  font-size:13px;
  color:#aaa;
  margin-bottom:0;
}
.border-top { border-top: 1px solid #e5e5e5; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }

.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }

@media (min-width: 576px) {
    .card-columns {
        -webkit-column-count: 2;
        -moz-column-count: 2;
        column-count: 2;
    }
}

@media (min-width: 768px) {
    .card-columns {
        -webkit-column-count: 2;
        -moz-column-count: 2;
        column-count: 2;
    }
}

@media (min-width: 992px) {
    .card-columns {
        -webkit-column-count: 3;
        -moz-column-count: 3;
        column-count: 3;
    }
}

@media (min-width: 1200px) {
    .card-columns {
        -webkit-column-count: 3;
        -moz-column-count: 3;
        column-count: 3;
    }
}
</style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md bg-light">
        <div class="container"><a class="navbar-brand" href="<?php echo ShortUrl('@root')?>"><img src="https://ruweb.net/imgs/logo.png" height="32"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><?=$navLink('Услуги', '/services/')?></li>
                    <li class="nav-item" role="presentation"><?=$navLink('Новости', '/news/')?></li>
                    <li class="nav-item" role="presentation"><?=$navLink('Поддержка', '/support/')?></li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="dropdown">
                        <a class="dropdown-toggle nav-link dropdown-toggle <?=Request()->matchAction('/money/') ? 'active' : ''?>" data-toggle="dropdown" href="">Баланс 1234.11 руб.&nbsp;</a>
                        <div class="dropdown-menu" role="menu">
<?php foreach ($menu['/money/'] as [$text, $url]) {?>
                          <?=$dropdownLink($text, $url);?> 
<?php }?>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle nav-link dropdown-toggle <?=Request()->matchAction('/account/') ? 'active' : ''?>" data-toggle="dropdown" href="">Аккаунт #12345&nbsp;</a>
                        <div class="dropdown-menu" role="menu">
<?php foreach ($menu['/account/'] as [$text, $url]) {?>
                          <?=$dropdownLink($text, $url);?> 
<?php }?> 
                          <div class="dropdown-divider" role="presentation"></div>
                          <?=$dropdownLink('Выход', '/logout/');?> 
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
<?php if ($leftMenu) {?>
        <div class="row">
            <div class="col-md-4 col-xl-3 offset-xl-0 mt-3">
                <div class="list-group mb-3 mb-md-0">
<?php foreach ($leftMenu as [$text, $url]) {?>
                    <?php echo $pageLink($text, $url, 'list-group-item list-group-item-action');?>
<?php }?>
                </div>
            </div>
            <div class="col-md-8 col-xl-9 mt-3">
<?php if (Layout()->exists('crumbs')) {?>
                <ol class="breadcrumb">
<?php foreach (Layout()->retrieve('crumbs') as [$value, $data]) {?>
                    <li class="breadcrumb-item"><?php echo $value?></li>
<?php }?>
                </ol>
<?php }?>
              <div style="min-height: 80vh">
                <?=$content?>
              </div>
            </div>
        </div>
<?php } else {?>
        <div style="min-height: 80vh" class="mt-3">
<?php if (Layout()->exists('crumbs')) {?>
                <ol class="breadcrumb">
<?php foreach (Layout()->retrieve('crumbs') as [$value, $data]) {?>
                    <li class="breadcrumb-item"><?php echo $value?></li>
<?php }?>
                </ol>
<?php }?>
          <?=$content?>
        </div>
<?php }?>
    </div>
    
    <div class="container">
        <hr>
    </div>
    <div class="footer-basic">
        <footer>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="?action=news">Новости</a></li>
                <li class="list-inline-item"><a href="#">Тарифы</a></li>
                <li class="list-inline-item"><a href="#">О компании</a></li>
                <li class="list-inline-item"><a href="#">Информация</a></li>
                <li class="list-inline-item"><a href="#">Политика конфеденциальности</a></li>
            </ul>
            <p class="copyright">Ruweb.net © 2018</p>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://unpkg.com/@bootstrapstudio/bootstrap-better-nav/dist/bootstrap-better-nav.min.js"></script>
</body>

</html>