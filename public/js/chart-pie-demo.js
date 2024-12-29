// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
//Chart.defaults.global.defaultFontColor = '#292b2c';

// Pie Chart Example
var adolescentes = document.getElementById('adolescentes');
var adultos = document.getElementById('adultos');
var discipulado = document.getElementById('discipulado');
var jInfancia = document.getElementById('jInfancia');
var juniores = document.getElementById('juniores');
var jovens = document.getElementById('jovens');
var primarios = document.getElementById('primarios');


var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Adolescentes", "Adultos", "Discipulado", "J. Infância", "Juniores","Jovens" ,"Primários"],
        datasets: [{
            label: 'Turmas',
            data: [adolescentes.value, adultos.value, discipulado.value, jInfancia.value, juniores.value, jovens.value, primarios.value],
        }],
    },
});
