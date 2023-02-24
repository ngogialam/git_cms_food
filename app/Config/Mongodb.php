<?php
namespace Config;
/**
 * Mongodb Configuration
 */
class Mongodb
{
	public $defaultGroup = 'default';

	/**
	 * The default database connection.
	 *
	 * @var array
	 */
	public $default = [
		'host' => '192.168.100.180',
		'port' => '27017',
		'dbname' => 'session_db',
		'user' => '',
		'password' => '',
		'connString' => null
	];

	public function __construct()
	{
		parent::__construct();

		// Ensure that we always set the database group to 'tests' if
		// we are currently running an automated test suite, so that
		// we don't overwrite live data on accident.
		if (ENVIRONMENT === 'production')
		{
			$this->defaultGroup = 'default';
		}
	}
}