s<?php
/**
 * yabs - Yet another blog system
 * Copyright (C) 2014 Daniel Triendl <daniel@pew.cc>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace Application;

class BaseApplication {
	protected $app_root;

	public function __construct($app_root) {
		$this->app_root = $app_root;
	}

	protected function init() {
		$this->checkPHPVersion();

		$this->loadConfig();

		Session::start();
		Input::restore();
	}

	protected function checkPHPVersion() {
		if (version_compare(PHP_VERSION, '5.4') < 0) {
			die('PHP >= 5.4 required');
		}
	}

	/**
	 * Load application config
	 */
	protected function loadConfig() {
		if (file_exists($this->app_root . '/Application/config.php')) {
			require_once $this->app_root . '/Application/config.php';
		}

		if (file_exists($this->app_root . '/Application/localconfig.php')) {
			require_once $this->app_root . '/Application/localconfig.php';
		}

		if (isset($config)) {
			Registry::getInstance()->config = $config;
		}
	}

	public function run() {
		$this->init();

		if (!Router::getInstance()->route($_SERVER['REQUEST_METHOD'], Uri::detectPath())) {
			// No valid route found
			http_response_code(404);
			echo '<h1>Page not found.</h1>';
		}
	}
}
