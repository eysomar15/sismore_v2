

<script>
    Highcharts.chart('{{$nombreGraficoLineal}}', {
       chart: {
           type: 'spline'
       },
       credits:false,
       title: {
           text: '{{$titulo}}'
       },
       subtitle: {
           text: '{{$subTitulo}}'
       },
       xAxis: {
           categories: <?=$categoria_nombres?>           
        //    ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
        //                 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
       },
       yAxis: {
           title: {
               text: '{{$titulo_y}}'
           },
           labels: {
               formatter: function () {
                   return this.value + '°';
               }
           }
       },
       tooltip: {
           crosshairs: true,
           shared: true
       },
       plotOptions: {
           spline: {
               marker: {
                   radius: 4,
                   lineColor: '#666666',
                   lineWidth: 1
               }
           }
       },

       series: <?=$dataLineal?>

    //    series: [
    //        {
    //            name: 'Tokyo',
    //            marker: {
    //                symbol: 'square'
    //            },
    //            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
    //        }, 
       
    //        {
    //            name: 'London',
    //            marker: {
    //                symbol: 'diamond'
    //            },
    //            data: [1.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    //        },
    //        {
    //            name: 'pucallpa',
    //            marker: {
    //                symbol: 'diamond'
    //            },
    //            data: [2.9, 5.2, 6.7, 9.5, 12.9, 15.2, 17.0, 18.6, 17.2, 11.3, 7.6, 5.8]
    //        }
    //    ]
   });
   
   
   </script>