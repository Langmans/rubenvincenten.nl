<?php

error_reporting(-1);
setlocale(LC_ALL, 'nl_NL.utf-8', 'nl.utf-8', 'nl_NL', 'nl', 'dutch', 'nld');

define('ROOT_DIR', realpath(dirname(__FILE__)) . '/');
define('CONTENT_DIR', ROOT_DIR . 'content/');
define('CONTENT_EXR', '.md');

define('MODULES_DIR', ROOT_DIR . 'modules/');

define('PICO_DIR', MODULES_DIR . 'pico/');
