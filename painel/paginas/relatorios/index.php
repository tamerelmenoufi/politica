<?php
    include "../../../lib/includes.php";
    $md5  = md5(date("YmdHis"));

    $Legenda = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

    $Bg = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ];

    $Bd = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];


    $query = "select b.tipo, count(*) as qt from servicos a left join servico_tipo b on a.tipo = b.codigo group by a.tipo";
    $result = mysql_query($query);
    $i=0;
    while($d = mysql_fetch_object($result)){
        $rotulo[] = $d->tipo;
        $qt[] =  $d->qt;
        $lg[] = $Legenda[$i];
        $bg[] = $Bg[$i];
        $bd[] = $Bd[$i];
    $i++;
    }

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

const Legendas<?=$md5?> = [];

<?php
    for($i = 0; $i < count($Lg); $i++){
?>
    Legendas['<?=$lg[$i]?>'] = '<?=$Lg[$i]?>';
<?php
    }

    $Lg =  "'".implode("', '",$rotulo)."'";
    $lg = "'".implode("', '",$lg)."'";
    $qt = implode(", ",$qt);

?>

const ctx<?=$md5?> = document.getElementById('myChart<?=$md5?>');
const myChart<?=$md5?> = new Chart(ctx<?=$md5?>,
{
  type: 'bar',
  data: {
        labels: [<?=$lg?>],
        datasets: [{
            label: false,
            data: [<?=$qt?>],
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
    indexAxis: 'y',
    // Elements options apply to all of the options unless overridden in a dataset
    // In this case, we are setting the border of each horizontal bar to be 2px wide
    elements: {
      bar: {
        borderWidth: 2,
      }
    },
    responsive: true,
    plugins: {
      legend: false/*{
        position: 'right',
      }*/,
      title: {
        display: true,
        text: 'Chart.js Horizontal Bar Chart'
      },



      tooltip: {
                callbacks: {
                    title: function(context){
                        console.log(context);
                        return Legendas<?=$md5?>['B'];
                    },
                    label: function(context) {
                        var label = context.dataset.label || '';

                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                        }
                        return label;
                    }
                }
            }



    }
  },
}


);
</script>