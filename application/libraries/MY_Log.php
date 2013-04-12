<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Log extends CI_Log {

	protected $_config;
	protected $_raven;
	protected $_raven_levels = array();

	public function __construct()
	{
		parent::__construct();

		$this->config =& get_config();

		if ( ! in_array(ENVIRONMENT, $this->config['raven_environments'])) return;

		try
		{
			// If Raven_Client isn't already defined, include the autoloader
			if ( ! class_exists('Raven_Client'))
			{
				require_once APPPATH . 'libraries/raven-php/lib/Raven/Autoloader.php';
				Raven_Autoloader::register();
			}

			// Create a new Raven Client with the extra options if they exist
			if (empty($config['raven_config'])) {
				$this->_raven = new Raven_Client($this->config['raven_client']);
			} else {
				$this->_raven = new Raven_Client($this->config['raven_client'], $this->config['raven_config']);
			}

			// Map Raven error levels to CI error levels
			$this->_raven_levels = array(
				'ERROR' => Raven_Client::ERROR,
				'DEBUG' => Raven_Client::DEBUG,
				'INFO' => Raven_Client::INFO,
				'ALL' => Raven_Client::DEBUG
			);

			// Adds Raven as an error handler
			$error_handler = new Raven_ErrorHandler($this->_raven);
			$error_handler->registerErrorHandler();
			$error_handler->registerExceptionHandler();
		}
		catch (Exception $e)
		{
			// Do nothing, since we don't want to stop loading of the site due
			// to a Raven misconfiguration or error.
		}
	}

	public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$level = strtoupper($level);

		if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
		{
			return FALSE;
		}

		// Skip log messages that are outside our threshold
		if ( ! in_array($level, $this->config['raven_log_threshold'])) {
			return FALSE;
		}

		// Push the message to Raven
		$this->_raven->captureMessage($msg, array(), $this->_raven_levels[$level], TRUE);

		return TRUE;
	}
}
