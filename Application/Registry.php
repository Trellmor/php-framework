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

class Registry extends Singleton {
	private $vars = array ();

	/**
	 * Set a variable
	 *
	 * @param string $index
	 * @param mixed $value
	 */
	public function __set($index, $value) {
		$this->vars[$index] = $value;
	}

	/**
	 * Get a variable
	 *
	 * @param string $index
	 * @return mixed
	 */
	public function __get($index) {
		return $this->vars[$index];
	}

	/**
	 * Check if a variable is set
	 *
	 * @param string $index
	 * @return True if the variable is set
	 */
	public function __isset($index) {
		return isset($this->vars[$index]);
	}
}
