<?php
/**
 * trellmor/php-framework
 * Copyright (C) 2016 Daniel Triendl <daniel@pew.cc>
 *
 * This file is part of trellmor/php-framework
 *
 * trellmor/php-framework is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
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

class Route {
	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';
	const OPTIONS = 'OPTIONS';
	private $method;
	private $class;
	private $function;
	private $url;

	public function __construct($method, $class, $function, $url) {
		$this->method = $method;
		$this->class = $class;
		$this->function = $function;
		$this->url = str_replace('/', '\\/', $url);
	}

	public static function get($class, $function, $url) {
		$c = __CLASS__;
		return new $c(static::GET, $class, $function, $url);
	}

	public static function post($class, $function, $url) {
		$c = __CLASS__;
		return new $c(static::POST, $class, $function, $url);
	}

	public static function put($class, $function, $url) {
		$c = __CLASS__;
		return new $c(static::PUT, $class, $function, $url);
	}

	public static function delete($class, $function, $url) {
		$c = __CLASS__;
		return new $c(static::DELETE, $class, $function, $url);
	}

	public static function options($class, $function, $url) {
		$c = __CLASS__;
		return new $c(static::OPTIONS, $class, $function, $url);
	}

	/**
	 * Checks if the passed url matches the route.
	 * If it maches the class
	 * will be created and the function called with the arguments extracted
	 * from the url
	 */
	public function matchUrl($method, $url) {
		if ($this->method == $method) {
			if (preg_match('/^' . $this->url . '$/', $url, $matches)) {
				$params = $this->prepareParams($matches);
				$this->execute($params);
				return true;
			}
			return false;
		}
	}

	protected function prepareParams($params) {
		unset($params[0]);
		return array_values($params);
	}

	protected function execute($params) {
		$instance = new $this->class();
		call_user_func_array(array (
				$instance,
				$this->function
		), $params);
	}
}