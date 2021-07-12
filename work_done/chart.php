<script>
      var options = {
          series: [{
                  name: 'งานทั้งหมด',
                  data: <?php echo getCountWorkMonth(true);?>,
                  color:'#FC766AFF'
                },{
                  name: 'งานที่ทำเสร็จ',
                  data:  <?php echo getCountWorkMonth(false);?>,
                  color:'#5cb85c'
                },
             ],
          chart: {
          type: 'area',
          height: 250
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '70%',
            endingShape: 'flat'
          },
        },
        dataLabels: {
          enabled:  true
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: <?php echo backDateByCurrentDate(3); ?>,
        },
        yaxis: {
          title: {
            text: 'จำนวนงาน (ชิ้น)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + "ชิ้น"
            }
          }
        }
        };

        let chartTopRender=(next)=>{
          var chart = new ApexCharts(document.querySelector("#chart"), options);
          chart.render();
          next(options);
        }
        
        let chartBottomRender=(options)=>{
          options.chart.type = 'bar';
          options.series[0].color = '#FC766AFF';
          options.series[1].color = '#4681af';
          var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
          chart2.render();
        }
        chartTopRender(chartBottomRender);
       
</script>