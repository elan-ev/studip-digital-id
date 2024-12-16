<?php
/* Stud.IP dependencies*/
require_once 'vendor/trails/trails.php';
require_once 'app/controllers/studip_controller.php';

StudipAutoloader::addAutoloadPath(__DIR__ . '/app/models', 'DigiCard');

require_once 'vendor/autoload.php';