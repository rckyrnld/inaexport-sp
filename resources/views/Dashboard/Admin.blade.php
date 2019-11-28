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
<style>
    #set_admin.nav-link.active, #set_perwakilan.nav-link.active, #set_importir.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }
    /*CSS MODAL*/
    .modal-lg{ width: 700px; }
    .modal-header { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
    .modal-body{ height: 300px; }
    .modal-content { border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; overflow: hidden;}
    .modal-footer { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
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
		   <div id="exTab2" class="container"> 
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#admin" id="set_admin" data-toggle="tab"><h6><b>Member</b></h6></a></li>
                                <li class="nav-item"><a class="nav-link" href="#perwakilan" id="set_perwakilan" data-toggle="tab"><h6><b>Research Corner</b></h6></a></li>
                                <li class="nav-item"><a class="nav-link" href="#importir" id="set_importir" data-toggle="tab"><h6><b>Inquiry</b></h6></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="admin">
								
								abs
								</div>
							</div>
			</div>
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
                        <td>{{getCompanyNameRC($value->id_itdp_profil_eks, $key, 'null')}}</td>
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
                    <thead style="background-color: #e45344; color: white;">
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
                <div class="col-md-6" style="float: left;">
                  <table class="table table-bordered table-hover" style="width: 100%; float: left; height: 300px;">
                    <thead style="background-color: #4cd25c; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Top Buyers</th>
                        <th width="15%">Amount</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      @foreach($table_top_buying as $key => $value)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{getCompanyNameRC($value->id_eks, $key, 'buying')}}</td>
                        <td>{{$value->jumlah}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <div id="buying" class="top_data" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                </div>
              </div>
              <br><br>
              <div class="row">
                <div id="event" style="height: 300px; width: 100%; margin: 0 auto;"></div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-md-6" style="float: left;">
                  <table class="table table-bordered table-hover" style="width: 100%; float: left; height: 300px;">
                    <thead style="background-color: #A93226; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Top Event</th>
                        <th width="30%">Number of Members</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      <?php $i=1; ?>
                      @foreach($table_top_event as $key => $value)
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{getNameEvent($key, $i)}}</td>
                        <td>{{$value}}</td>
                      </tr>
                      <?php $i++;?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-bordered table-hover" style="width: 100%; float: left; height: 300px;">
                    <thead style="background-color: #D68910; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Top Member</th>
                        <th width="30%">Number of Events</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      <?php $i=1;?>
                      @foreach($table_top_join_event as $key => $value)
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{getCompanyNameRC($key, $i, 'event')}}</td>
                        <td>{{$value}}</td>
                      </tr>
                      <?php $i++;?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <br><br>
              <div class="row">
                <div id="training" style="width: 100%; height: 400px; margin: 0 auto;"></div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-md-6" style="float: left;">
                  <table class="table table-bordered table-hover" style="width: 100%; float: left; height: 300px;">
                    <thead style="background-color: #2ECC71; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Top Training</th>
                        <th width="30%">Number of Members</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      @foreach($table_top_training as $key => $value)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{getNameTraining($value->id_training_admin, $key)}}</td>
                        <td>{{$value->jumlah}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-bordered table-hover" style="width: 100%; float: left; height: 300px;">
                    <thead style="background-color: #AF7AC5; color: white;">
                      <tr>
                        <th width="15%">No</th>
                        <th>Top Member</th>
                        <th width="30%">Number of Training</th>
                      </tr>
                    </thead>
                    <tbody style="color: black;">
                      @foreach($table_top_join_training as $key => $value)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{getCompanyNameRC($value->id_profil_eks, $key, 'null')}}</td>
                        <td>{{$value->jumlah}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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
    training();
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

  function training() {
    var data_year = JSON.parse('<?php echo addcslashes(json_encode($Training),'\'\\'); ?>');
    var defaultTitle = "Amount of Training Each Year";
    var drilldownTitle = "Amount of Training Year ";
    
    var chart = Highcharts.chart('training', {
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
            pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">{point.name}</span><br/>'
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
            pointFormat: '<i class="fa fa-circle" aria-hidden="true" style="color:{point.color}"></i>  <span style="color:{point.color}">{point.name}</span><br/>'
        }
    });
  }
</script>