<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "spkp";
$route['scaffolding_trigger'] = "";
$route['event/:any'] = 'event/index/file_id/$1';
$route['gallery/:any'] = 'gallery/index/$1';
$route['newsread/:any'] = 'news/read/file_id/$1';
$route['eventread/:any'] = 'event/read/file_id/$1';
$route['downloadread/:any'] = 'download/read/file_id/$1';
$route['downloaddo/:any'] = 'download/dodownload/file_id/$1';
$route['download/:any'] = 'download/index/file_id/$1';
$route['videoread/:any'] = 'video/read/file_id/$1';
$route['news/:any'] = 'news/index/file_id/$1';
$route['video/:any'] = 'video/index/file_id/$1';
$route['polling/:any'] = 'polling/index/file_id/$1';
$route['text/:any'] = 'text/index/file_id/$1';

$route['404_override'] = '';

