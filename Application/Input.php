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

class Input {
	const POST = 'POST';
	const GET = 'GET';
	const JSON = 'JSON';
	// const OPTIONS_UUID = ['options' => ['regexp' => REGEX_UUID]];
	const REGEX_UUID = '/([a-f\d]{8}(-[a-f\d]{4}){3}-[a-f\d]{12}?)/i';
	private $data;

	public function __construct($method) {
		switch ($method) {
			case static::GET:
				parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $this->data);
				break;
			case static::POST:
				$this->data = $_POST;
				break;
			case 'NULL':
				$this->data = array ();
				break;
			case 'JSON':
				$this->data = json_decode(file_get_contents('php://input'), true);
				break;
			default:
				parse_str(file_get_contents('php://input'), $this->data);
				break;
		}
	}

	public function filter($variable, $filter, $options = null) {
		if ($options != null) {
			$this->data[$variable] = filter_var($this->{$variable}, $filter, $options);
		} else {
			$this->data[$variable] = filter_var($this->{$variable}, $filter);
		}
	}

	/**
	 * Set a variable
	 *
	 * @param mixed $index
	 * @param mixed $value
	 */
	public function __set($index, $value) {
		if (isset($this->data[$index]) === false) {
			throw new \Exception('Invalid index: ' . $index);
		}
		$this->data[$index] = $value;
	}

	/**
	 * Get a variable
	 *
	 * @param mixed $index
	 * @return mixed
	 */
	public function __get($index) {
		if (isset($this->data[$index])) {
			return $this->data[$index];
		} else {
			return null;
		}
	}

	public function __isset($index) {
		return isset($this->data[$index]);
	}

	public function save() {
		Session::start();
		$_SESSION['input'] = $this;
	}

	public static function restore() {
		if (isset($_SESSION['input'])) {
			Registry::getInstance()->input = $_SESSION['input'];
			unset($_SESSION['input']);
		}
	}
}
