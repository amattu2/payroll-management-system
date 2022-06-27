/*
 * Produced: Mon Jun 27 2022
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

import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

window.Chart = Chart;

window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * Update an employee's employment status
 *
 * @param {HTMLElement} element
 * @param {string} status
 */
window.updateStatus = async (element, status) => {
  // Update UI
  element.classList.add("disabled");
  element.innerHTML = `<span class="spinner-grow spinner-grow-sm" role="status"></span> Loading...`;

  // Make Request
  const endpoint = window.location.href.replace(window.location.hash, "").replace("#", "") + "/update/employment_status/" + status
  const data = await fetch(endpoint, {
    method: "POST",
    headers:  {
      "X-CSRF-Token": document.querySelector("[name='csrf-token']").content
    }
  });

  // Reload
  window.location.reload();
};

/**
 * Add the templated work description to the payroll day
 *
 * @param {HTMLElement} element
 */
window.addWorkDescription = (element) => {
  element.parentElement.parentElement.parentElement.querySelector("textarea").value = element.textContent;
};
