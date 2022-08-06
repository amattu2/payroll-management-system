<?php
/*
 * Produced: Mon Jun 20 2022
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

return [
  'welcome.to.app' => 'Welcome to :name!',
  'no.employees' => 'It looks like you haven\'t added any employees yet. Click the button below to begin.',
  '404' => 'Unfortunately, the page at /:slug could not be found.',
  '404.employee' => 'The employee you were looking for could not be found.',
  '404.timesheet' => 'The timesheet you were looking for could not be found.',
  '404.leave' => 'The leave request you were looking for could not be found.',
  'timesheet.bad_owner' => 'The requested timesheet does not belong to this employee',
  'employee.status' => 'The employee status has been updated to :status',
  'employment.terminate' => 'Is this employee no longer employed? Mark them as terminated below.',
  'employment.activate' => 'Reactivate this employee below.',
  'employee.deleted' => 'The employee :name has been deleted, and you\'re receiving this email because they are a direct report of yours.',
  'employee.created' => 'The new employee :name has been created, and you\'re receiving this email because they are a direct report of yours.',
  'employee.updated' => 'The profile for employee :name has been updated, and you\'re receiving this email because they are a direct report of yours.',
  'timesheet.unsaved' => "You're viewing a new timesheet because the timesheet for the :period pay period does not exist yet.",
  'timesheet.finalized' => "Your timesheet for pay period :period has been finalized and is now available as of :when.",
  'timesheet.email.default' => "Hello!\n\nYour timesheet for pay period :period is attached below.\n\nIf you have any questions, please contact your supervisor.",
  'leave.status' => "Your leave request for the dates :start &ndash; :end was marked as <b>:status</b> by :name at :when.",
  'timesheet.adjustment' => 'Manually adjust the total hours for this day by incrementing or decrementing the minutes.',
];
