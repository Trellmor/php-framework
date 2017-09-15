<?php

namespace Application;

class CORS {
	public static function headers() {
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

		if (($origin = static::getConfig('Access-Control-Allow-Origin')) !== null) {
			header('Access-Control-Allow-Origin: ' . $origin);
		}

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
			if (($methods = static::getConfig('Access-Control-Allow-Methods')) !== null) {
				header('Access-Control-Allow-Methods: ' . $methods);
			}
		}

		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
			if (($headers = static::getConfig('Access-Control-Allow-Headers')) !== null) {
				if ($headers == '*') {
					$headers = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];
				}
				header('Access-Control-Allow-Headers: ' . $headers);
			}
		}
	}

	private static function getConfig($key) {
		$config = Registry::getInstance()->config;
		if (array_key_exists('cors', $config)) {
			$cors = $config['cors'];
			if (array_key_exists($key, $cors) && $cors[$key] !== null) {
				return $cors[$key];
			}
		}

		return null;
	}
}
