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
