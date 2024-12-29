// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var jan = document.getElementById('jan');
var fev = document.getElementById('fev');
var mar = document.getElementById('mar');
var abr = document.getElementById('abr');
var mai = document.getElementById('mai');
var jun = document.getElementById('jun');
var jul = document.getElementById('jul');
var ago = document.getElementById('ago');
var set = document.getElementById('set');
var out = document.getElementById('out');
var nov = document.getElementById('nov');
var dez = document.getElementById('dez');
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        datasets: [{
            label: "Revenue",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: [jan.value, fev.value, mar.value, abr.value, mai.value, jun.value, jul.value, ago.value, set.value, out.value, nov.value, dez.value],
        }],
    },
    options: {
        scales: {
            xAxes: [{
                time: {
                    unit: 'month'
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    maxTicksLimit: 12
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 650,
                    maxTicksLimit: 5
                },
                gridLines: {
                    display: true
                }
            }],
        },
        legend: {
            display: false
        }
    }
});
