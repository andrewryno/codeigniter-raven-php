<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Raven Client Configuration
| -------------------------------------------------------------------
| 'raven_client' = DSN string for connecting to a Raven client.
| 'raven_config' = Optional second parameter to Raven_Client which
| contains extra configuration options.
|
| See: https://github.com/getsentry/raven-php#configuration
*/
$config['raven_client'] = 'DSN string here';
$config['raven_config'] = array();
$config['raven_log_threshold'] = array('ERROR');