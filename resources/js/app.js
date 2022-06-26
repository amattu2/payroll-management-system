import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

window.Chart = Chart;

window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}
