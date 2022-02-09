<?php
    include "../../../../lib/includes.php";
    $md5  = md5(date("YmdHis").$_SERVER["PHP_SELF"]);

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


<h5>Relatório Por Assessores</h5>
<canvas id="myChart<?=$md5?>" width="400" height="400"></canvas>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Legenda</th>
      <th scope="col">Descrição</th>
      <th scope="col">Quantidade</th>
    </tr>
  </thead>
  <tbody>
    <?php
      for($i = 0; $i < count($lg); $i++){
    ?>
    <tr>
      <td><?=$lg[$i]?></td>
      <td><?=$rotulo[$i]?></td>
      <td><?=$qt[$i]?></td>
    </tr>
    <?php
      }
    ?>
  </tbody>
</table>
<?php
    if($rotulo) $Lg =  "'".implode("', '",$rotulo)."'";
    if($lg) $lg = "'".implode("', '",$lg)."'";
    if($qt) $qt = implode(", ",$qt);
?>
<script>

const ctx<?=$md5?> = document.getElementById('myChart<?=$md5?>');
const myChart<?=$md5?> = new Chart(ctx<?=$md5?>,
{
  type: 'bar',
  data: {
        labels: [<?=$lg?>],
        datasets: [{
            label:  [<?=$lg?>],
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
            borderWidth: 1,
            rotulos:[<?=$Lg?>]
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
                        indx = context[0].parsed.y;
                        return context[0].dataset.rotulos[indx];
                    },
                    label: function(context) {
                        indx = context.parsed.y;
                        var label = ' ' + context.dataset.label[indx] || '';

                        if (label) {
                            label += ' : ';
                        }
                        if (context.parsed.y !== null) {
                            label += context.parsed.x + ' Registro(s)';
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