@include('header')
        
         &nbsp;
<style type="text/css">
  .highcharts-drilldown-axis-label{
    text-decoration: none !important;
    color: #4c4d61 !important;
    fill: #4c4d61 !important;
  }
  .top_data{
    display: inline-block;
    min-width: 50%;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        {{-- <div class="box-header">
        </div> --}}
        <div class="box-divider m-0"></div>
      
        <div class="box-body">
          <div class="tab-content p-3 mb-3">
            <div class="tab-pane animate fadeIn text-muted active show" id="tab4">
              <div class="row">
                <div id="user_year" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
              </div><br><br><br>
              <div class="row">
                <div id="inquiry" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
              </div><br><br><br>
              <div class="row">
                <div id="buying" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
              </div><br><br><br>
            </div>
            <div class="tab-pane animate fadeIn text-muted" id="tab5">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
&nbsp;
@include('footer')
<script type="text/javascript">
  $(document).ready(function() {
    Highcharts.setOptions({
        lang: {
            drillUpText: '◁ Back to Top'
        }
    });
    user();
    inquiry();
    buying();
  });

  function user() {
    var data = JSON.parse('<?php echo addcslashes(json_encode($User),'\'\\'); ?>');
    var negara = "{{getPerwakilanCountry2(Auth::user()->id)}}";
    var defaultTitle = "The Number of Members Each Year in "+negara;
    var drilldownTitle = "The Number of Members Year ";
    
    var chart = Highcharts.chart('user_year', {
        chart: {
          type: 'column',
          events: {
              drilldown: function(e) {
                  chart.setTitle({ text: drilldownTitle + e.point.name });
              },
              drillup: function(e) {
                  chart.setTitle({ text: defaultTitle });
              }
          }
        },
        xAxis: {
                type : 'category'
            },
        yAxis: {
            allowDecimals: false,
            title: {
                text: ''
            }
        },
        series: data[0],
        credits: {
          enabled: false
        },
        title: {
            text: defaultTitle
        },
        legend: {
            enabled: false
        },
        drilldown: {
            series: data[1]
        }
    });
  }

  function inquiry() {
    var data = JSON.parse('<?php echo addcslashes(json_encode($Inquiry),'\'\\'); ?>');
    var defaultTitle = "The Number of Inquiry Each Year";
    var drilldownTitle = "Inquiry in ";
    
    var chart = Highcharts.chart('inquiry', {
        chart: {
          type: 'column',
          events: {
              drilldown: function(e) {
                  chart.setTitle({ text: drilldownTitle + e.point.name });
              },
              drillup: function(e) {
                  chart.setTitle({ text: defaultTitle });
              }
          }
        },
        xAxis: {
                type : 'category'
            },
        yAxis: {
            allowDecimals: false,
            title: {
                text: ''
            }
        },
        plotOptions: {
            column: {
                grouping: true            
            }
        },   
        series: data[0],
        credits: {
          enabled: false
        },
        title: {
            text: defaultTitle
        },
        legend: {
            enabled: true
        },
        drilldown: {
            series: data[1]
        }
    });
  }

  function buying() {
    var data = JSON.parse('<?php echo addcslashes(json_encode($Buying),'\'\\'); ?>');
    var defaultTitle = "The Number of Buying Each Year";
    var drilldownTitle = "Buying Request in ";
    
    var chart = Highcharts.chart('buying', {
        chart: {
          type: 'column',
          events: {
              drilldown: function(e) {
                  chart.setTitle({ text: drilldownTitle + e.point.name });
              },
              drillup: function(e) {
                  chart.setTitle({ text: defaultTitle });
              }
          }
        },
        xAxis: {
                type : 'category'
            },
        yAxis: {
            allowDecimals: false,
            title: {
                text: ''
            }
        },
        series: data[0],
        credits: {
          enabled: false
        },
        title: {
            text: defaultTitle
        },
        legend: {
            enabled: true
        },
        drilldown: {
            series: data[1]
        }
    });
  }
</script>