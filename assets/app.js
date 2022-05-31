/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// const $ = require('jquery');
// global.$ = global.jQuery = $;
// window.$ = window.jQuery = require('jquery/dist/jquery.min');
// window.$ = require('jquery');

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
require('nprogress')
// require('bootstrap-progressbar')
require('icheck')
import dt from 'datatables.net';
import moment from "moment";
// import 'datatables.net-dt/css/jquery.datatables.css';

require('datejs')
require('moment')
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('./lib/bootstrap-daterangepicker/js/bootstrap-datetimepicker.min')
require('select2')
const axios = require('axios').default;
// require('./lib/jquery-sparkline/jquery.sparkline.min')
import {BarController, BarElement, CategoryScale, Chart, LinearScale} from "chart.js";

function init_charts()
{
    Chart.register(LinearScale, BarController, CategoryScale, BarElement);
    const jData = JSON.parse($('#txtMonthly').val());
    console.log(jData);

    const labels = [];
    const values = [];
    jData.forEach(item => {
        labels.push(item.hilero)
        values.push(item.count)
    });

    console.log(labels);
    console.log(values);

    const data = {
        labels: labels,
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: values,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    const myChart = new Chart(
        document.getElementById('myChart').getContext('2d'),
        config
    );
}
$(document).ready(function() {

    init_charts();

    const _locale = $('#txtLocale').val() ? $('#txtLocale').val() : 'Eu';
    const datatablesLocaleURL = "/build/datatables/" + _locale + ".json";

    console.log("datatables locale url => " +datatablesLocaleURL)

    $('.formSubmitLink').on('click', function () {
        $(this).closest('form').submit();
    });

    $('.datatable').DataTable({
        language: {
            url: datatablesLocaleURL
        },
    });

    $('.select2').select2({
        theme: "bootstrap"
    });

    $('.datetimepicker').datetimepicker({
        locale: _locale ? _locale:'Eu',
        format: 'YYYY-MM-DD HH:mm:ss',
    });

    $('.datetimepicker-date-only').datetimepicker({
        locale: _locale ? _locale:'Eu',
        format: 'YYYY-MM-DD HH:mm:ss',
    }).on('dp.change', function (e) {
        const d = new Date(e.date);
        d.setHours(0,0,0,0)
        $(this).data("DateTimePicker").date(d);
    });

    $('.datetimepicker-inline').datetimepicker({
        locale: _locale ? _locale:'Eu',
        format: 'YYYY-MM-DD HH:mm:ss',
        inline: true,
        sideBySide: true
    });

    $('[data-toggle="popover"]').popover();

    $('#btnSaveButton').on('click', function () {
        $('#crudSubmitButton').trigger('click');
    });

    $('#mailegua01_hasi_bizikleta').on('select2:select', function (e) {
        const bizikletaID = e.params.data.id;
        const url = "/api/bizikletas/" + bizikletaID;

        axios.get(url).then(function(data){
            if ( data.notes !== null) {
                $('#btnOharrakModal').show();
                $('#modalh4').html("Bastidorea: " + data.data.bastidorea);
                $('#modaloharrak').html(data.data.notes)
            } else {
                $('#btnOharrakModal').hide();
            }
        })
    });
});
