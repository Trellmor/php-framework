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

use Application\Crypto;
use Application\Crypto\SecureRandom;
use Application\Crypto\Utils;

class CSRF {
	private static $name = 'csrf_token';
	private static $hmac = 'hmac_secret';

	public function getToken() {
		return base64_encode($this->getTokenValue(static::$name));
	}

	public function getName() {
		return static::$name;
	}

	public function verifyToken($method = 'POST') {
		if (empty($_SESSION[static::$name])) {
			return false;
		}

		$input = new Input($method);

		if (empty($input->csrf_token)) {
			return false;
		}

		return Crypto\Utils::compareStr($_SESSION[static::$name], base64_decode($input->csrf_token));
	}

	public function hashHMAC($data) {
		$hash = hash_hmac('sha256', $data, $this->getHMACSecret(), true);
		return base64_encode($data . $hash);
	}

	public function verifyHMAC($data) {
		$data = base64_decode($data);
		if (Utils::binaryStrlen($data) <= 32) {
			return false;
		}

		$hash = Utils::binarySubstr($data, -32, 32);
		$data = Utils::binarySubstr($data, 0, -32);

		$newhash = hash_hmac('sha256', $data, $this->getHMACSecret(), true);
		return (Utils::compareStr($hash, $newhash)) ? $data : false;
	}

	protected function getHMACSecret() {
		return $this->getTokenValue(static::$hmac);
	}

	protected function getTokenValue($name) {
		// Start session
		Session::start();

		if (!empty($_SESSION[$name])) {
			return $_SESSION[$name];
		} else {
			$token = $this->generateToken();
			$_SESSION[$name] = $token;
			return $token;
		}
	}

	protected function generateToken() {
		$sr = new SecureRandom();
		return $sr->getBytes(32); // 256 bit token
	}
}
