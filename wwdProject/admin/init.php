<?php
    include 'connect.php';
    $tbls   = 'includes/templates/';
    $func   = 'includes/functions/';
    $css    = 'layout/css/';
    $js     = 'layout/js/';
    $lang   = 'includes/languages/';


    include $func . 'functions.php';
    include $lang . 'english.php';
    include $tbls . 'header.php';
    if(!isset($noNavbar)){
        include $tbls . 'navbar.php';
    }
    