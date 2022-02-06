<?php
    include "../../../lib/includes.php";
    $md5  = md5(date("YmdHis"));
?>

<div class="row">
    <div class="col-6">
        <h5>Nome do Gráfico 1</h5>
        <canvas id="myChart<?=$md5?>" width="400" height="400"></canvas>
    </div>
    <div class="col-6">
        <h5>Nome do Gráfico 2</h5>
    </div>
</div>




<script>
const ctx<?=$md5?> = document.getElementById('myChart<?=$md5?>');
const myChart<?=$md5?> = new Chart(ctx<?=$md5?>, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>