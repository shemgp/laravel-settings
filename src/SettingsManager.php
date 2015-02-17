<?php
/**
 * Laravel 4 - Persistant Settings
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  l4-settings
 */

namespace anlutro\LaravelSettings;

use Illuminate\Support\Manager;
use Illuminate\Foundation\Application;

class SettingsManager extends Manager
{
	public function getDefaultDriver()
	{
		return $this->getConfig('anlutro/l4-settings::store');
	}

	public function createJsonDriver()
	{
		$path = $this->getConfig('anlutro/l4-settings::path');

		return new JsonSettingStore($this->app['files'], $path);
	}

	public function createDatabaseDriver()
	{
		$connection = $this->app['db']->connection();
		$table = $this->getConfig('anlutro/l4-settings::table');

		return new DatabaseSettingStore($connection, $table);
	}

	protected function getConfig($key)
	{
		if (version_compare(Application::VERSION, '5.0', '>=')) {
			$key = str_replace('anlutro/l4-settings::', 'settings.', $key);
		}

		return $this->app['config']->get($key);
	}
}
