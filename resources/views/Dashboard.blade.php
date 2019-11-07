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
                <div class="col-md-6" style="float: left;">
                  <table class="table table-bordered table-hover" style="width: 100%; height: 300px; float: left;">
                    <thead style="background-color: #789ec5; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Company</th>
                        <th width="30%">Number of Downloads</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      @foreach($table_download_company as $key => $value)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{getCompanyNameRC($value->id_itdp_profil_eks,$key)}}</td>
                        <td>{{$value->jumlah}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <div id="top_downloader" class="top_data" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                </div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-md-6" style="float: left;">
                  <table class="table table-bordered table-hover" style="width: 100%; float: left; height: 300px;">
                    <thead style="background-color: #855c9a; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Name</th>
                        <th width="30%">Number of Downloads</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      @foreach($table_download_rc as $key => $value)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{getRcName($value->id_research_corner,$key)}}</td>
                        <td>{{$value->jumlah}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <div id="top_rc" class="top_data" style="height: 300px; margin: 0 auto; width: 100%; float: left;"></div>
                </div>
              </div>
              <br><br>
              <div class="row">
                <div id="inquiry" style="width: 100%; height: 400px; margin: 0 auto;"></div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-md-6" style="float: left;">
                  <table class="table table-bordered table-hover" style="width: 100%; float: left; height: 300px;">
                    <thead style="background-color: #EC7063; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Name</th>
                        <th width="15%">Amount</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      @foreach($table_inquiry as $key => $value)
                      <?php 
                        if($value->type == 'admin'){
                          $name = getAdminName($value->id_pembuat).' ( Admin )';
                        } else if($value->type == 'perwakilan'){
                          $name = getPerwakilanName($value->id_pembuat).' ( Representative )';
                        } else {
                          $name = getCompanyNameImportir($value->id_pembuat).' ( Importer )';
                        }
                      ?>
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$name}}</td>
                        <td>{{$value->jumlah}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <div id="top_inquiry" class="top_data" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                </div>
              </div>
              <br><br>
              <div class="row">
                <div id="buying" style="width: 100%; height: 400px; margin: 0 auto; padding-top: 50px;"></div>
              </div>
              <br><br>
              <div class="row">
                <div id="event" style="width: 100%; height: 400px; margin: 0 auto; padding-top: 50px;"></div>
              </div>
              <br><br>
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
    Highcharts.setOptions({
        lang: {
            drillUpText: '◁ Back to Top'
        }
    });
    user();
    top_downloader();
    inquiry();
    buying();
    event();
  });

  function user() {
    var data = JSON.parse('<?php echo addcslashes(json_encode($User),'\'\\'); ?>');
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

  function inquiry() {
    var data_year = JSON.parse('<?php echo addcslashes(json_encode($Inquiry),'\'\\'); ?>');
    var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Inquiry),'\'\\'); ?>');
    var defaultTitle = "Amount of Inquiry Each Year";
    var drilldownTitle = "Amount of Inquiry Year ";
    
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
        series: data_year[0],
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
            series: data_year[1]
        }
    });

    Highcharts.chart('top_inquiry', {
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
        series: data_top,
        credits: {
          enabled: false
        },
        title: {
            text: 'Top 5 Most Making an Inquiry'
        },
        legend: {
            enabled: false
        },
        tooltip: {
            useHTML: true,
            headerFormat: '',
            pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">{point.name}</span><br/>'
        }
    });
  }

  function buying() {
    var data_year = JSON.parse('<?php echo addcslashes(json_encode($Buying),'\'\\'); ?>');
    var defaultTitle = "Amount of Buying Each Year";
    var drilldownTitle = "Amount of Buying Year ";
    
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
        series: data_year[0],
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
            series: data_year[1]
        }
    });
  }

  function event() {
    var data_year = JSON.parse('<?php echo addcslashes(json_encode($Event),'\'\\'); ?>');
    var defaultTitle = "Amount of Events Each Year";
    var drilldownTitle = "Amount of Events Year ";
    
    var chart = Highcharts.chart('event', {
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
        series: data_year[0],
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
            series: data_year[1]
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