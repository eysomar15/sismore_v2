<script>

        
    Highcharts.chart('{{$nombreGraficoBarra}}', {
    
                colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                                return {
                                    radialGradient: {
                                        cx: 0.5,
                                        cy: 0.3,
                                        r: 0.7
                                    },
                                    stops: [
                                        [0, color],
                                        [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                                    ]
                                };
                            }),
    
    
                chart: {
                    type: 'column'
                },
                credits:false,
                title: {
                    text: '{{$titulo}}'
                },
                subtitle: {
                    text: '{{$subTitulo}}'
                },
                xAxis: {
                    categories: 
                         <?=$categoria_nombres?>
                    ,
                    // crosshair: true
                },
                yAxis: {
                    // min: 0,
                    title: {
                        text: '{{$titulo_y}}'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                        '<td style="padding:0"><b>{point.y} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
    
                plotOptions: {
                    column: {
                        // pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                                    enabled: true,
                                 
                                    format: '{y}'
                                }
    
                        // dataLabels: {
                        //         enabled: true,
                        //         rotation: -90,
                        //         color: '#FFFFFF',
                        //         align: 'right',
                        //         format: '{point.y}', // one decimal
                        //         y: 10, // 10 pixels down from the top
                        //         style: {
                        //             fontSize: '14px',
                        //             fontFamily: 'Verdana, sans-serif'
                        //         }
                        //     }
                    }
                },
                series: <?=$data?>
            });
    
    </script>
    
    