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

if (!isset($_SESSION['ID']) || !isset($_SESSION['Username'])) {
  session_destroy();
  header("HTTP/1.1 401 Unauthorized", true, 401);
  if (!IS_XHR) header("location: /login.php");
  die();
}

if ($_SESSION['IP'] !== USER_IP) {
  session_destroy();
  header("HTTP/1.1 401 Unauthorized", true, 401);
  if (!IS_XHR) header("location: /login.php");
  die();
}

if ($_SESSION['UserAgent'] !== md5($_SERVER['HTTP_USER_AGENT'])) {
  session_destroy();
  header("HTTP/1.1 401 Unauthorized", true, 401);
  if (!IS_XHR) header("location: /login.php");
  die();
}

if (isset($_SESSION['Paused']) && $_SESSION['Paused'] === 1) {
  header("HTTP/1.1 423 Locked", true, 423);
  if (!IS_XHR) header("location: /login.php");
  die();
}

if ($_SESSION['MFA']['Enabled'] === 1 && $_SESSION['MFA']['Completed'] === 0) {
  header("HTTP/1.1 403 Forbidden", true, 403);
  if (!IS_XHR) header("location: /2fa.php");
  die();
}

if (defined('FLAG_CHECK_CSRF')) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['CSRF'] !== ($_POST['CSRF'] ?? '')) {
    header("HTTP/1.1 403 Forbidden", true, 403);
    die();
  } else if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SESSION['CSRF'] !== ($_GET['CSRF'] ?? '')) {
    header("HTTP/1.1 403 Forbidden", true, 403);
    die();
  }
}
