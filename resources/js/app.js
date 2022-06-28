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
import moment from 'moment';
import lodash from 'lodash';
import bootstrap from 'bootstrap';

Chart.register(...registerables);

window.Chart = Chart;
window.moment = moment;
window._ = lodash;

/**
 * Add the templated work description to the payroll day
 *
 * @param {HTMLElement} element
 */
window.addWorkDescription = (element) => {
  element.parentElement.parentElement.parentElement.querySelector("textarea").value = element.textContent;
};

/**
 * Recalculate the payroll day's total units (hours/days)
 *
 * @param {HTMLElement} element
 */
window.calculateDayUnits = (element) => {
  const parent = element.parentElement.parentElement;
  const units = parent.dataset.units;

  const start = parent.querySelector("[name='start_time']");
  const startTime = moment(start.value, "HH:mm", true);
  const end = parent.querySelector("[name='end_time']");
  const endTime = moment(end.value, "HH:mm", true);
  if (!startTime.isValid() || !endTime.isValid()) {
    return;
  }

  if (startTime.isAfter(endTime)) {
    return;
  }

  const adjustment = parent.querySelector("[name='adjustment']");
  if (!adjustment.value || parseInt(adjustment.value) % 15 !== 0) {
    adjustment.value = 0;
  } else {
    endTime.add(parseInt(adjustment.value), "minutes");
  }

  const duration = moment.duration(endTime.diff(startTime));
  switch (units) {
    case "hours":
      parent.querySelector("[data-day-sum]").textContent = `${duration.asHours()} ${units}`;
      break;
    default:
      break;
  }
};
