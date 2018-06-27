<?php

Template()->render('@extra/nav-tabs.php', Meta(__dir('../../'))->get('nav', []));

?>
<div class="py-4">
  <h2>Новый заказ</h2>
  <?php echo tryToFancyOldCode(file_get_contents(__dir('old.txt')));?>
</div>