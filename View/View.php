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
namespace View;

use Application\Exceptions\InvalidViewException;

class View {
	private $template;
	private $vars = array ();

	public function __construct($template = '') {
		$this->template = $template;
		$this->assignVar('view', $this);
	}

	public function getTemplate() {
		return $this->template;
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

	public function assignVar($name, $value) {
		$this->vars[$name] = $value;
	}

	public function assignVars($vars) {
		$this->vars = array_merge($this->vars, $vars);
	}

	public function getVars() {
		return $this->vars;
	}

	public function load($view) {
		$file = __DIR__ . '/' . $this->template . '/' . $view . '.php';

		if (file_exists($file)) {
			extract($this->vars, EXTR_REFS);
			include $file;
		} else {
			throw new InvalidViewException('View not found: ' . $view);
		}
	}

	public function handleMessages() {
		$messages = Message::getSavedMessages();

		foreach ($messages as $message) {
			$this->assignVar('message', $message);
			$this->load('message');
		}
	}
}
