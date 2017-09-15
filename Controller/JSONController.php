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
namespace Controller;

use Application\CORS;

abstract class JSONController {

	public function __construct() {
		// Make sure file is not cached (as it happens for example on iOS devices)
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('Content-Type: application/json');
		CORS::headers();
	}

	protected function returnJSON($data, $http_response_code = 200) {
		http_response_code($http_response_code);
		die(json_encode($data));
	}

	protected function jsonError($code, $message, $http_response_code = 400) {
		$this->returnJSON([
				'status' => 'error',
				'error' => [
						'code' => $code,
						'message' => $message
				]
		], $http_response_code);
	}

	protected function redirect($uri, $code = 302) {
		header('Location: ' . $uri, true, $code);
	}
}
