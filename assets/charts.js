const $ = require("jquery");

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


const {Chart, LinearScale, BarController, CategoryScale, BarElement} = require("chart.js");
$(document).ready(function() {
    init_charts();
});
