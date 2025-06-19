<?php
    $routes['home'] = 'user/index';
    $routes['news'] = 'user/news';
    $routes['contact'] = 'user/contact';
    $routes['favorite'] = 'user/favorite';
    $routes['logout'] = 'auth/logout';
    $routes['profile'] = 'setting/profile';
    

    DEFINE('ROUTER',$routes);
?>