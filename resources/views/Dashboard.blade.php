@include('header')
        
         &nbsp;
<style type="text/css">
  .highcharts-drilldown-axis-label{
    text-decoration: none !important;
    color: #4c4d61 !important;
    fill: #4c4d61 !important;
  }
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        {{-- <div class="box-header">
        </div> --}}
        <div class="box-divider m-0"></div>
      
        <div class="box-body">
          <div class="tab-content p-3 mb-3">
            <div class="tab-pane animate fadeIn text-muted active show" id="tab4">
              <div id="user_year" style="min-width: 310px; height: 400px; margin: 0 auto;"></div><br><br>
              <div id="top_downloader" style="min-width: 310px; height: 300px; margin: 0 auto;"></div><br><br>
              <div id="top_rc" style="min-width: 310px; height: 300px; margin: 0 auto;"></div>
              <div class="row">
                <div class="table-responsive"> 
                </div>
              </div>

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
    $.ajax({
            url: "{{route('dashboard.scopeData')}}",
            method: 'get',
            dataType: 'json',
            success:function(response){
              new_user(response[0], response[1]);
              top_downloader();
            }
      });
  });

  function new_user(data, drilldown) {
    var defaultTitle = "The Number of Members Each Year";
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
        series: data,
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
            series: drilldown
        }
    });
  }

  function top_downloader() {
    var data_company = JSON.parse('<?php echo addcslashes(json_encode($Top_Company_Download),'\'\\'); ?>');
    var data_rc = JSON.parse('<?php echo addcslashes(json_encode($Top_Downloaded_RC),'\'\\'); ?>');
    
    var chart = Highcharts.chart('top_downloader', {
        chart: {
          type: 'column'
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
        series: data_company,
        credits: {
          enabled: false
        },
        title: {
            text: 'Top 5 Downloader (Reasearch Corner)'
        },
        legend: {
            enabled: false
        },
        tooltip: {
            useHTML: true,
            headerFormat: '',
            pointFormat: '<span style="font-size:11px;color:{point.color}">{point.name}</span><br><i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  {point.y} Downloads<br/>'
        }
    });

    var charts = Highcharts.chart('top_rc', {
        chart: {
          type: 'column'
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
        series: data_rc,
        credits: {
          enabled: false
        },
        title: {
            text: 'Top 5 Most Downloaded (Reasearch Corner)'
        },
        legend: {
            enabled: false
        },
        tooltip: {
            useHTML: true,
            headerFormat: '',
            pointFormat: '<span style="font-size:11px;color:{point.color}">{point.name}</span><br><i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  {point.y} Downloads<br/>'
        }
    });
  }
</script>