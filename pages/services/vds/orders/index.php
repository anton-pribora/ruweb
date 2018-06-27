<?php 

Template()->render('@extra/nav-tabs.php', Meta(__dir('..'))->get('nav', []));

$newOrderUrl = ShortUrl(__dir('new/'));

?>
     
<div class="py-4">

<div class="card-columns">
  <div class="card box-shadow">
    <div class="card-header"><h5 class="card-title mb-0">anton-pribora.ru</h5></div>
    <div class="card-body">
      <h6 class="card-subtitle text-muted mb-2">Виртуальный выделенный сервер</h6>
      
      <ul class="list-unstyled">
        <li>Номер заказа: 12120</li>
        <li>Тариф: KVMz-MICRO</li>
        <li>IP: 185.221.152.228</li>
        <li>Состояние: включен</li>
        <li>Цена: 5601.20 руб./3 года</li>
        <li>Оплачен до: 20.01.2021</li>
        <li>Автопродление: да</li>
      </ul>
      
      <a href="<?php echo ShortUrl(__dir('view/'))?>" class="btn btn-primary btn-block">Подробно</a>
    </div>
  </div>
  
  <div class="card box-shadow">
    <div class="card-header"><h5 class="card-title mb-0">anton-pribora.ru</h5></div>
    <div class="card-body">
      <h6 class="card-subtitle text-muted mb-2">Виртуальный выделенный сервер</h6>
      
      <ul class="list-unstyled">
        <li>Номер заказа: 12120</li>
        <li>Тариф: KVMz-MICRO</li>
        <li>IP: 185.221.152.228</li>
        <li>Состояние: включен</li>
        <li>Цена: 5601.20 руб./3 года</li>
        <li>Оплачен до: 20.01.2021</li>
        <li>Автопродление: да</li>
      </ul>
      
      <a href="<?php echo ShortUrl(__dir('view/'))?>" class="btn btn-primary btn-block">Подробно</a>
    </div>
  </div>
  
  <div class="card box-shadow">
    <div class="card-header"><h5 class="card-title mb-0">anton-pribora.ru</h5></div>
    <div class="card-body">
      <h6 class="card-subtitle text-muted mb-2">Виртуальный выделенный сервер</h6>
      
      <ul class="list-unstyled">
        <li>Номер заказа: 12120</li>
        <li>Тариф: KVMz-MICRO</li>
        <li>IP: 185.221.152.228</li>
        <li>Состояние: включен</li>
        <li>Цена: 5601.20 руб./3 года</li>
        <li>Оплачен до: 20.01.2021</li>
        <li>Автопродление: да</li>
      </ul>
      
      <a href="<?php echo ShortUrl(__dir('view/'))?>" class="btn btn-primary btn-block">Подробно</a>
    </div>
  </div>
  
  <div class="card box-shadow">
    <div class="card-header"><h5 class="card-title mb-0">anton-pribora.ru</h5></div>
    <div class="card-body">
      <h6 class="card-subtitle text-muted mb-2">Виртуальный выделенный сервер</h6>
      
      <ul class="list-unstyled">
        <li>Номер заказа: 12120</li>
        <li>Тариф: KVMz-MICRO</li>
        <li>IP: 185.221.152.228</li>
        <li>Состояние: включен</li>
        <li>Цена: 5601.20 руб./3 года</li>
        <li>Оплачен до: 20.01.2021</li>
        <li>Автопродление: да</li>
      </ul>
      
      <a href="<?php echo ShortUrl(__dir('view/'))?>" class="btn btn-primary btn-block">Подробно</a>
    </div>
  </div>
  
  <div class="card box-shadow">
    <div class="card-header"><h5 class="card-title mb-0">Заказать</h5></div>
    <div class="card-body">
      <ul class="list-unstyled">
        <li class="mb-2"><a class="btn btn-outline-primary btn-block" href="<?php echo $newOrderUrl?>">Новый VDS</a></li>
        <li class="mb-2"><a class="btn btn-outline-primary btn-block text-truncate" href="<?php echo $newOrderUrl?>">Панель управления для VDS</a></li>
        <li class="mb-2"><a class="btn btn-outline-primary btn-block" href="<?php echo $newOrderUrl?>">Домен</a></li>
        <li class="mb-2">
<div class="dropdown"><button class="btn btn-outline-primary dropdown-toggle btn-block" data-toggle="dropdown" aria-expanded="false" type="button">Другое</button>
    <div role="menu" class="dropdown-menu">
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">SSL-сертификаты</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Выделенные IP-адреса</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Лицензии на панели управления и прочее ПО</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Виртуальные выделенные сервера (VDS) [KVM]</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Для реселлеров</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Услуги вебстудии</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Резервное копирование</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Защита от DDOS-атак</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Выделенные сервера</a>
        <a href="<?php echo $newOrderUrl?>" class="dropdown-item">Прочие услуги</a>
    </div>
</div>
        </li>
      </ul>
    </div>
  </div>
</div>

</div>