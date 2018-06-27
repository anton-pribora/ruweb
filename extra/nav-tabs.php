<?php
/* @var $this ApCode\Template\Template */
$nav = $this->argument(0);
?>
<ul class="nav nav-tabs">
<?php
foreach ($nav as $item) {
?>
    <li class="nav-item"><a role="tab" href="<?php echo Html($item['href'] ?? '')?>" class="nav-link <?php if ($item['active'] ?? false) echo 'active';?>"><?php echo $item['title'] ?? '';?></a></li>
<?php
}
?>
</ul>