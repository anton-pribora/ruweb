<?php 

// charset cp1251

namespace {
    use somenamespace\Layout;
                
    function Layout() {
        static $instance;
        
        if (empty($instance)) {
            $instance = new Layout();
        }
        
        return $instance;
    }
}

namespace somenamespace {
    class MenuItem
    {
        private $path, $props;
        
        public function __construct($path, array $props)
        {
            $this->path  = $path;
            $this->props = $props;
        }
        
        public function prop($name, $default = NULL)
        {
            return isset($this->props[$name]) ? $this->props[$name] : $default;
        }
        
        public function setProp($name, $value)
        {
            $this->props[$name] = $value;
        }
        
        public function attributes()
        {
            $result = $this->props;
            
            unset($result['active']);
            unset($result['tag']);
            unset($result['text']);
            unset($result['extra']);
            
            return $result;
        }
        
        public function active()
        {
            return boolval($this->prop('active'));
        }
        
        public function text()
        {
            return $this->prop('text');
        }
        
        public function extra()
        {
            return $this->prop('extra');
        }
        
        public function tag()
        {
            return $this->prop('tag', 'a');
        }
    }
    
    class Layout 
    {
        private $menu = [];
        private $variables = [
            'headTags' => [],
        ];
        
        public function setVar($name, $value)
        {
            $this->variables[$name] = $value;
        }
        
        public function getVar($name, $default = NULL)
        {
            return isset($this->variables[$name]) ? $this->variables[$name] : $default;
        }
        
        public function addMenu($path, array $params) 
        {
            $this->menu[$path] = new MenuItem($path, $params);
        }
        
        public function menuLink($path, $class = '')
        {
            $menu = $this->menu[$path];
            $attributes = $menu->attributes();
            
            $active = $menu->active() ? ' active' : '';
            
            if (isset($attributes['class'])) {
                $attributes['class'] .= ' ' . $class . $active;
            } else {
                $attributes['class'] = $class . $active;
            }
            
            $result = ['<' . $menu->tag()];
            
            foreach ($attributes as $name => $value) {
                $result[] = sprintf(' %s="%s"', htmlentities($name, ENT_QUOTES, 'utf-8'), htmlentities($value, ENT_QUOTES, 'utf-8'));
            }
            
            $result[] = '>';
            $result[] = $menu->text();
            $result[] = '</' . $menu->tag() . '>';
            
            return join($result);
        }
        
        public function menuProp($path, $prop, $default = NULL)
        {
            if (isset($this->menu[$path])) {
                return $this->menu[$path]->prop($prop, $default);
            }
            
            return $default;
        }
        
        public function setMenuProp($path, $prop, $value)
        {
            if (isset($this->menu[$path])) {
                $this->menu[$path]->setProp($prop, $value);
            }
        }
        
        /**
         * @param string $pattern
         * @return MenuItem[]
         */
        public function findMenuItemsByPath($pattern)
        {
            $result = [];
            
            foreach ($this->menu as $key => $menu) {
                if (preg_match($pattern, $key)) {
                    $result[$key] = $menu;
                }
            }
            
            return $result;
        }
        
        public function activateMenu($path, $addCrumbs = TRUE)
        {
            $sections = preg_split('~/~', $path, null, PREG_SPLIT_NO_EMPTY);
            $menuPath = '/';
            
            foreach ($sections as $value) {
                $menuPath .= $value . '/';
                
                if (isset($this->menu[$menuPath])) {
                    $this->setMenuProp($menuPath, 'active', true);
                    
                    if ($addCrumbs) {
                        $this->addCrumb($this->menuLink($menuPath));
                    }
                }
            }
        }
        
        public function addCrumb($html)
        {
            if (!isset($this->variables['crumbs'])) {
                $this->variables['crumbs'] = [];
            }
            
            $this->variables['crumbs'][] = $html;
        }
        
        private function tryToFancyOldCode ($text) {
            $text = preg_replace_callback('~<script[\w\W]*</script>~Ui', function($matches) {
                $this->variables['headTags'][] = $matches[0];
                return '';
            }, $text);
            
            $text = preg_replace('~<html>[\s\S]+</head>~Ui', '', $text);
            $text = preg_replace('~</?body[^>]*>~i', '', $text);
            $text = preg_replace('~</?basefont[^>]*>~i', '', $text);
            $text = preg_replace('~<style> td.centr \{vertical-align:middle; padding: 4px 4px\}</style>~i', '', $text);
            $text = preg_replace('~<hr><table border=0 cellspacing=0 width=100%><tr><td>RuBill v0.83<br><small>[\s\S]+~', '', $text);
            $text = preg_replace('~<table border=0 cellspacing=5>[\w\W]+</table><hr>~Ui', '', $text);
            $text = preg_replace('~<p></p>~Ui', '', $text);
            $text = preg_replace('~<hr><table[\s\S]*?</table>~Ui', '', $text);
            $text = preg_replace('~<img src=(img[/\w\.-]+)~i', '<img src="https://ruweb.net/billing/\\1"', $text);
            $text = preg_replace_callback('~<table[\s\S]+>~Ui', function($matches) {
                return '<table class="table table-sm">';
            }, $text);
            
            $text = preg_replace('~<table[\s\S]+</table>~U', '<div class="table-responsive">\\0</div>', $text);
            $text = trim($text);
            
            return $text;
        }
        
        public function render($content, $fancy = TRUE) 
        {
            $fancyContent = $fancy ? $this->tryToFancyOldCode($content) : $content;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->getVar('title', 'Ruweb Billing')?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/4.1.1/sandstone/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="https://unpkg.com/@bootstrapstudio/bootstrap-better-nav/dist/bootstrap-better-nav.min.css">
    <style type="text/css"><?php readfile(__DIR__ . '/style.css');?></style>
    <?php echo join("\n    ", $this->variables['headTags']);?> 
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md bg-light">
        <div class="container"><a class="navbar-brand" href="<?php echo $this->getVar('homelink', '/')?>"><img src="https://ruweb.net/imgs/logo.png" height="32"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><?=$this->menuLink('/services/', 'nav-link')?></li>
                    <li class="nav-item" role="presentation"><?=$this->menuLink('/news/', 'nav-link')?></li>
                    <li class="nav-item" role="presentation"><?=$this->menuLink('/support/', 'nav-link')?></li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="dropdown">
                        <a class="dropdown-toggle nav-link dropdown-toggle <?=$this->menu['/money/']->active() ? 'active' : ''?>" data-toggle="dropdown" href=""><?php echo $this->menu['/money/']->text() . ' ' . $this->menu['/money/']->extra();?></a>
                        <div class="dropdown-menu" role="menu">
<?php foreach ($this->findMenuItemsByPath('~^/money/[^/]+/$~') as $path => $menuItem) {?>
                          <?=$this->menuLink($path, 'dropdown-item');?> 
<?php }?>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle nav-link dropdown-toggle <?=$this->menu['/account/']->active() ? 'active' : ''?>" data-toggle="dropdown" href=""><?php echo $this->menu['/account/']->text();?></a>
                        <div class="dropdown-menu" role="menu">
<?php foreach ($this->findMenuItemsByPath('~^/account/[^/]+/$~') as $path => $menuItem) {?>
                          <?=$this->menuLink($path, 'dropdown-item');?> 
<?php }?>
                          <div class="dropdown-divider" role="presentation"></div>
                          <?=$this->menuLink('/logout/', 'dropdown-item');?> 
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
<?php 

$leftMenu = [];

foreach ($this->findMenuItemsByPath('~^/[^/]+/$~') as $path => $menuItem) {
    if ($menuItem->active()) {
        $leftMenu = $this->findMenuItemsByPath("~^{$path}[^/]+/\$~");
        break;
    }
}

$pageNavs = [];

foreach ($leftMenu as $path => $menuItem) {
    if ($menuItem->active()) {
        $pageNavs = $this->findMenuItemsByPath("~^{$path}[^/]+/\$~");
        break;
    }
}

if ($leftMenu) {?>
        <div class="row">
            <div class="col-md-4 col-xl-3 offset-xl-0 mt-3">
                <div class="list-group mb-3 mb-md-0">
<?php foreach ($leftMenu as $path => $menuItem) {?>
                    <?php echo $this->menuLink($path, 'list-group-item list-group-item-action');?>
<?php }?>
                </div>
            </div>
            <div class="col-md-8 col-xl-9 mt-3">
<?php if ($this->getVar('crumbs')) {?>
                <ol class="breadcrumb">
<?php foreach ($this->getVar('crumbs') as $value) {?>
                    <li class="breadcrumb-item"><?php echo $value?></li>
<?php }?>
                </ol>
<?php }?>
              <div style="min-height: 80vh">
<?php if ($pageNavs) {?>
                <ul class="nav nav-tabs">
<?php foreach ($pageNavs as $path => $menuItem) { ?>
                  <li class="nav-item"><?php echo $this->menuLink($path, 'nav-link')?></li>
<?php } ?>
                </ul>
                <div class="py-4">
                  <?=$fancyContent?>
                </div>
<?php } else { ?>
              <?=$fancyContent?>
<?php } ?>
              </div>
            </div>
        </div>
<?php } else {?>
        <div style="min-height: 80vh" class="mt-3">
<?php if ($this->getVar('crumbs')) {?>
                <ol class="breadcrumb">
<?php foreach ($this->getVar('crumbs') as $value) {?>
                    <li class="breadcrumb-item"><?php echo $value?></li>
<?php }?>
                </ol>
<?php }?>
          <?=$fancyContent?>
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
<?php
        }
    }
}

