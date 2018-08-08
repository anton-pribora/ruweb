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
        
        public function path()
        {
            return $this->path;
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
            unset($result['dropdown']);
            
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
        
        public function dropdown()
        {
            return boolval($this->prop('dropdown'));
        }
        
        public function setDropdown($value)
        {
            $this->setProp('dropdown', $value);
            return $this;
        }
    }
    
    class Layout 
    {
        private $menu = [];
        private $variables = [
            'headTags' => [],
        ];
        
        private $leftMenu = [];
        private $navs = [];
        
        public function setVar($name, $value)
        {
            $this->variables[$name] = $value;
        }
        
        public function getVar($name, $default = NULL)
        {
            return isset($this->variables[$name]) ? $this->variables[$name] : $default;
        }
        
        /**
         * @return \somenamespace\MenuItem
         */
        public function addMenu($path, array $params) 
        {
            return $this->menu[$path] = new MenuItem($path, $params);
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
                $result[] = sprintf(' %s="%s"', htmlentities($name, ENT_QUOTES, 'cp1251'), htmlentities($value, ENT_QUOTES, 'cp1251'));
            }
            
            $result[] = '>';
            $result[] = $menu->text();
            $result[] = '</' . $menu->tag() . '>';
            
            return join($result);
        }
        
        public function writeTopMenuItem(MenuItem $item)
        {
            if ($item->dropdown()) {
                echo "<li class=\"dropdown\">\n";
                echo "<a class=\"dropdown-toggle nav-link dropdown-toggle ", $item->active() ? 'active' : '', "\" data-toggle=\"dropdown\" href=\"\">", $item->text(), ' ', $item->extra(), "</a>\n";
                echo "<div class=\"dropdown-menu\" role=\"menu\">\n";
                
                foreach ($this->findMenuItemsByPath('~^' . $item->path() . '[^/]+/$~') as $path => $menuItem) {
                    if ($menuItem->text() == '--') {
                        echo "<div class=\"dropdown-divider\" role=\"presentation\"></div>\n";
                    } else {
                        echo $this->menuLink($path, 'dropdown-item');
                    }
                }
                
                echo "</div>\n";
                echo "</li>\n"; 
            } else {
                echo "<li class=\"nav-item\" role=\"presentation\">", $this->menuLink($item->path(), 'nav-link'), "</li>";
            }
        }
        
        public function writeTopMenuItems(array $items, $class = '')
        {
            if (!$items) {
                return ;
            }
            
            echo "<ul class=\"$class\">\n";
            
            foreach ($items as $item) {
                $this->writeTopMenuItem($item);
            }
            
            echo "</ul>\n";
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
        
        private function writeBegin()
        {
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="cp1251">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->getVar('title', 'Ruweb Billing')?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/4.1.1/sandstone/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="https://unpkg.com/@bootstrapstudio/bootstrap-better-nav/dist/bootstrap-better-nav.min.css">
    <style><?php readfile(__DIR__ . '/style.css');?></style>
    <?php echo join("\n    ", $this->variables['headTags']);?> 
</head>
<body>
<?php 
        }
        
        private function writeNavigation()
        {
?>
<nav class="navbar navbar-light navbar-expand-md bg-light">
    <div class="container"><a class="navbar-brand" href="<?php echo $this->getVar('homelink', '/')?>"><img alt="ruweb.net" src="https://ruweb.net/imgs/logo.png" height="32"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
<?php 
            $this->writeTopMenuItems($this->findMenuItemsByPath('~^/topleftmenu/[^/]+/$~'), 'nav navbar-nav');
            $this->writeTopMenuItems($this->findMenuItemsByPath('~^/toprightmenu/[^/]+/$~'), 'nav navbar-nav ml-auto');
?>
        </div>
    </div>
</nav>
<?php
        }
        
        private function writeEnd()
        {
?>
    <div class="container">
        <hr>
    </div>
    <div class="footer-basic">
<?php include(__DIR__ . '/footer.php');?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://unpkg.com/@bootstrapstudio/bootstrap-better-nav/dist/bootstrap-better-nav.min.js"></script>
</body>
</html>
<?php
        }
        
        private function writeCrumbs()
        {
            if (empty($this->getVar('crumbs'))) {
                return ;
            }
            
            echo "<ol class=\"breadcrumb\">\n";
            
            foreach ($this->getVar('crumbs') as $value) {
                echo "  <li class=\"breadcrumb-item\">$value</li>\n";
            }
            
            echo "</ol>\n";
        }
        
        private function writeLeftMenu()
        {
            echo "<div class=\"list-group mb-3 mb-md-0\">\n";
            
            foreach ($this->leftMenu as $path => $menuItem) {
                if ($menuItem->text() !== '--') {
                    echo $this->menuLink($path, 'list-group-item list-group-item-action');
                }
            }
            
            echo "</div>\n";
        }
        
        private function writePageNavs()
        {
            if (!$this->navs) {
                return ;
            }
            
            echo "<ul class=\"nav nav-tabs mb-4\">\n";
            
            foreach ($this->navs as $path => $menuItem) {
              echo "<li class=\"nav-item\">", $this->menuLink($path, 'nav-link'), "</li>\n";
            }
            
            echo "</ul>";
        }
        
        private function writeContent($content)
        {
            echo "<div class=\"container\">\n";
            
            if ($this->leftMenu) {
                // Страница с левым меню
                echo "<div class=\"row\">\n";
                
                // Колонка левого меню
                echo "<div class=\"col-md-4 col-xl-3 offset-xl-0 mt-3\">\n";
                $this->writeLeftMenu();
                echo "</div>\n";
                
                // Колонка с содержимым
                echo "<div class=\"col-md-8 col-xl-9 mt-3\">\n";
                echo "<div style=\"min-height: 70vh\">\n";
                $this->writeCrumbs();
                $this->writePageNavs();
                echo $content, "\n";
                echo "</div>\n";
                echo "</div>\n";
                
                echo "</div>\n";
            } else {
                // Страница без левого меню
                echo "<div style=\"min-height: 70vh\" class=\"mt-3\">\n";
                $this->writeCrumbs();
                $this->writePageNavs();
                echo $content, "\n";
                echo "</div>\n";
            }
            
            echo "</div>\n";
        }
        
        public function render($content, $fancy = TRUE) 
        {
            $fancyContent = $fancy ? $this->tryToFancyOldCode($content) : $content;
            
            foreach ($this->findMenuItemsByPath('~^/[^/]+/[^/]+/$~') as $path => $menuItem) {
                if ($menuItem->active()) {
                    $this->leftMenu = $this->findMenuItemsByPath("~^{$path}[^/]+/\$~");
                    break;
                }
            }
            
            foreach ($this->leftMenu as $path => $menuItem) {
                if ($menuItem->active()) {
                    $this->navs = $this->findMenuItemsByPath("~^{$path}[^/]+/\$~");
                    break;
                }
            }
            
            $this->writeBegin();
            $this->writeNavigation();
            $this->writeContent($fancyContent);
            $this->writeEnd();
        }
    }
}

