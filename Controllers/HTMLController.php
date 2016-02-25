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
namespace Controllers;

use Models\Message;
use View\View;

abstract class HTMLController {
	protected $view;

	public function __construct() {
		$this->view = new View();
	}

	protected function error($code, $message) {
		http_response_code($code);

		$this->message(new Message($message, Message::LEVEL_ERROR));
	}

	protected function info($message) {
		$this->message(new Message($message, Message::LEVEL_INFO));
	}

	protected function success($message) {
		$this->message(new Message($message, Message::LEVEL_SUCCESS));
	}

	protected function warn($message) {
		$this->message(new Message($message, Message::LEVEL_WARNING));
	}

	protected function message($message) {
		$this->view->assignVar('message', $message);
		$this->view->load('messagepage');
	}

	protected function redirect($uri) {
		header('Location: ' . $uri);
	}
}
