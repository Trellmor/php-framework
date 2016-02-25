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

abstract class Singleton {
	private static $instances = [ ];

	public function __destruct() {
		$class = get_called_class();
		unset(self::$instances[$class]);
	}

	public static function getInstance() {
		$class = get_called_class();
		if (!isset(self::$instances[$class])) {
			self::$instances[$class] = new $class();
		}

		return self::$instances[$class];
	}
}
