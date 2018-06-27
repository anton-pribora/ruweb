<?php

UrlAlias()->set('@root' , '/');
UrlAlias()->set('@root/', '/');

PathAlias()->set('@root', ROOT_DIR);

PathAlias()->set('@layout', '@root/layout.php');
PathAlias()->set('@extra', '@root/extra');