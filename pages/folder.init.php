<?php

Url()->setAlias(__dir('/'), '@root/');

Layout()->append('crumbs', ShortLink('Главная', ShortUrl(__dir('/'))));
