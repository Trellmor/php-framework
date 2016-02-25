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

class File {

	public static function unlink($filename) {
		if (file_exists($filename) && is_writable(($filename))) {
			return unlink($filename);
		}
		return false;
	}

	public static function move_uploaded_file($filename, $destination) {
		$dir = dirname($destination);
		if (!file_exists($dir)) {
			if (!mkdir($dir, 0755, true)) {
				return false;
			}
		}

		return move_uploaded_file($filename, $destination);
	}

	public static function getUniqueueName($filename) {
		static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		if (file_exists($filename)) {
			$filename = explode('.', $filename);
			$filename[count($filename) - 2] .= $chars[rand(0, strlen($chars) - 1)];
			$filename = static::getUniqueueName(implode('.', $filename));
		}
		return $filename;
	}
}
