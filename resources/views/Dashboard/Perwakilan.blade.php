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
<?php
if(Auth::user()->id_admin_dn == 0){ $group = 'Country'; } else { $group = 'Province'; } 
  if($User != null){
    $user = 1;
  } else {
    $user = 0;
  }
  if($Inquiry != null){
    $inquiry = 1;
  } else {
    $inquiry = 0;
  }
  if($Buying != null){
    $buying = 1;
  } else {
    $buying = 0;
  }
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        {{-- <div class="box-header">
        </div> --}}
        <div class="box-divider m-0"></div>
        <div class="nav-active-border b-primary top box">
            <div class="nav nav-md">
                <a class="nav-link active" data-toggle="tab" data-target="#tab1">
                    <i class="fa fa-plus-circle"></i> Member
                </a>
                <a class="nav-link" data-toggle="tab" data-target="#tab2">
                    <i class="fa fa-plus-circle"></i> Inquiry
                </a>
                <a class="nav-link" data-toggle="tab" data-target="#tab3">
                    <i class="fa fa-plus-circle"></i> Buying Request
                </a>
            </div>
        </div>
        <div class="box-body">
          <div class="tab-content p-3 mb-3">
            <div class="tab-pane animate fadeIn text-muted active show" id="tab1">
              <div class="row justify-content-center">
                @if($user == 1)
                <div id="user_year" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
                @else
                <h3>No Member in This {{$group}}</h3>
                @endif
              </div>
            </div>
            <div class="tab-pane animate fadeIn text-muted" id="tab2">
              <div class="row justify-content-center">
                @if($inquiry == 1)
                <div id="inquiry" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
                @else
                <h3>No Inquiry in This Account</h3>
                @endif
              </div>
            </div>
            <div class="tab-pane animate fadeIn text-muted" id="tab3">
              <div class="row justify-content-center">
                @if($buying == 1)
                <div id="buying" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
                @else
                <h3>No Buying Request in This Account</h3>
                @endif
              </div>
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
    if("{{$user}}" == 1){
      user();
    }
    if("{{$inquiry}}" == 1){
      inquiry();
    }
    if("{{$buying}}" == 1){
      buying();
    }
  });

if("{{$user}}" == 1){
  function user() {
    var data = JSON.parse('<?php echo addcslashes(json_encode($User),'\'\\'); ?>');
    if("{{Auth::user()->id_admin_dn}}" == 0){
      var negara = " in {{getPerwakilanCountry3(Auth::user()->id)}}";
    } else {
      var negara = "";
    }
    var defaultTitle = "The Number of Members Each Year"+negara;
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
}
if("{{$inquiry}}" == 1){
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
}
if("{{$buying}}" == 1){
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
}
</script>