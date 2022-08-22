<?php

    spl_autoload_register();
    use \App\Controller\Controller;
    use \App\Db\Mysql;
    define('_ROOTPATH_', __DIR__);
    $controller = new Controller(_ROOTPATH_);
    $controller->init();


?>
