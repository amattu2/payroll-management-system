<?php
/*
 * Produced: Sat May 21 2022
 * Author: Alec M.
 * GitHub: https://amattu.com/links/github
 * Copyright: (C) 2022 Alec M.
 * License: License GNU Affero General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Files
require(dirname(__FILE__, 4) ."/vendor/autoload.php");

/**
 * Currency Number Formatter
 *
 * @var \NumberFormatter
 */
$CURRENCY_FORMATTER = new NumberFormatter('en_US', NumberFormatter::CURRENCY_ACCOUNTING);
setlocale(LC_MONETARY, 'en_US.UTF-8');

/**
 * Current User IP Address
 *
 * @var string|null
 */
define("USER_IP",
  $_SERVER['HTTP_CLIENT_IP'] ??
  $_SERVER['HTTP_X_FORWARDED_FOR'] ??
  $_SERVER['REMOTE_ADDR'] ??
  null
);

/**
 * Current Request was via AJAX
 *
 * @var boolean
 */
define("IS_XHR", ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? null) === 'XMLHttpRequest');

/**
 * Configuration Handle
 *
 * @var IniParser\IniParser|null
 */
$config = null;
if (defined('FLAG_CONFIGURATION') || defined('FLAG_DATBASE')) {
  $config = new IniParser\IniParser(
    dirname(__FILE__, 4) . "/application/configuration.ini",
    true
  );
}

/**
 * MySQLi Connection Handle
 *
 * @var \MySQLi|null
 */
$con = null;
if (defined('FLAG_DATABASE')) {
  $con = new Medoo\Medoo([
    'type' => 'mysql',
    'host' => $config->get("HOST", "DATABASE"),
    'username' => $config->get("USER", "DATABASE"),
    'password' => $config->get("PASS", "DATABASE"),
    'database' => $config->get("DB", "DATABASE"),
  ]);
}
