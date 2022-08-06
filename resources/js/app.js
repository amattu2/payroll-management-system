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
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min';

Chart.register(...registerables);

window.bootstrap = bootstrap;
window.Chart = Chart;
window.moment = moment;
window._ = lodash;

/**
 * Run events on page load
 */
 window.addEventListener("DOMContentLoaded", () => {
  /**
   * Activate Tooltips
   */
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(e => {
    new bootstrap.Tooltip(e)
  });

  /**
   * Activate custom element clone role
   */
  document.querySelectorAll("[data-cs-role='clone']").forEach((e) => {
    const target = document.querySelector(e.dataset.csTarget);

    e.onclick = (evt) => {
      const clone = target.cloneNode(true);

      if (clone.value) {
        clone.value = "";
      }
      if (clone.checked) {
        clone.checked = false;
      }

      target.parentElement.appendChild(clone);
    };
  });
});

window.addDecimalPlaces = (element) => {
  if (element.value > element.max) {
    element.value = element.max;
  } else if (element.value < element.min) {
    element.value = element.min;
  }

  element.value = parseFloat(element.value).toFixed(2);
};

/**
 * Add the templated work description to the payroll day
 *
 * @param {HTMLElement} element
 */
window.addWorkDescription = (element) => {
  const textarea = element.parentElement.parentElement.parentElement.querySelector("textarea");

  if (textarea.getAttribute('disabled') === null) {
    textarea.value = element.textContent.replace(/\s\s+/g, ' ');
  }
};

/**
 * Recalculate the payroll week's total hourly units
 *
 * @param {string} id Week element ID
 */
window.recalculateWeekHours = (id) => {
  const week = document.getElementById(id);
  let total = 0;

  const rows = week.querySelectorAll(".row[id*='day']");
  rows.forEach(row => {
    const start = row.querySelector("[name*='start_time']");
    const startTime = moment(start.value, "HH:mm", true);
    const end = row.querySelector("[name*='end_time']");
    const endTime = moment(end.value, "HH:mm", true);

    if (!startTime.isValid() || !endTime.isValid()) {
      return;
    }

    if (startTime.isAfter(endTime)) {
      start.classList.add('is-invalid');
      end.classList.add('is-invalid');
      return;
    } else {
      start.classList.remove('is-invalid');
      end.classList.remove('is-invalid');
    }

    const adjustment = row.querySelector("[name*='adjustment']");
    if (!adjustment.value || parseInt(adjustment.value) % 15 !== 0) {
      adjustment.value = 0;
    } else {
      endTime.add(parseInt(adjustment.value), "minutes");
    }

    const duration = moment.duration(endTime.diff(startTime));
    total += duration.asHours() || 0;
    row.querySelector("[data-day-sum]").textContent = duration.asHours().toFixed(2) + " hours";
    row.querySelector("[name*='total_units']").value = duration.asHours().toFixed(2);
  });

  week.querySelector("[data-week-sum]").textContent = total.toFixed(2) + " hours";
};

/**
 * Recalculate a week's total day (salary) units
 *
 * @param {string} id Week element ID
 */
window.recalculateWeekDays = (id) => {
  const week = document.getElementById(id);
  let total = 0;

  const rows = week.querySelectorAll(".row[id*='day']");
  rows.forEach(row => {
    const units = row.querySelector("[name*='total_units']");

    total += parseFloat(units.value).toFixed(2) || 0;
    row.querySelector("[data-day-sum]").textContent = parseFloat(units.value || 0).toFixed(2) + " days";
  });

  week.querySelector("[data-week-sum]").textContent = parseFloat(total).toFixed(2) + " days";
};
