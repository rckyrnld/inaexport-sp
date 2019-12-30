@include('header')

<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
&nbsp;
<style type="text/css">
    .highcharts-drilldown-axis-label {
        text-decoration: none !important;
        color: #4c4d61 !important;
        fill: #4c4d61 !important;
    }

    .top_data {
        display: inline-block;
        min-width: 50%;
    }
</style>
<style>
    #set_admin.nav-link.active, #set_perwakilan.nav-link.active, #set_importir.nav-link.active {
        background-color: #40bad2 !important;
        color: white !important;
    }
</style>
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
                            <i class="fa fa-plus-circle"></i> Product List
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab2">
                            <i class="fa fa-plus-circle"></i> Top Product
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab3">
                            <i class="fa fa-plus-circle"></i> Incomes
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab4">
                            <i class="fa fa-plus-circle"></i> Event & Training
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content p-3 mb-3">
                        <div class="tab-pane animate fadeIn text-muted active show" id="tab1">
                            <div class="row">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead class="text-white" style="background-color: #1089ff; font-size: 12px; font-weight: 600;">
                                      <tr>
                                        <td>No</td>
                                        <td>Code</td>
                                        <td>Product Name</td>
                                        <td>Price ( USD )</td>
                                        <td>Action</td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product as $key => $data)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$data->code_en}}</td>
                                            <td>{{$data->prodname_en}}</td>
                                            <td>{{$data->price_usd}}</td>
                                            <td><a href="{{url('/eksportir/product_view', $data->id)}}" class="btn btn-info"><i class="fa fa-search"></i>&nbsp;View</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab2">
                            <div class="row">
                                <div></div>
                            </div>
                            <a id="export_pdf_1" class="btn btn-success"><font color="white"><i class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab3">
                            <div class="row">
                                <div id="incomes" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <a id="export_pdf_2" class="btn btn-success"><font color="white"><i class="fa fa-download"></i> Export PDF</font></a>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab4">
                            <div class="row">
                                <div id="interest" style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <a id="export_pdf_3" class="btn btn-success"><font color="white"><i class="fa fa-download"></i> Export PDF</font></a>
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

    $(document).ready(function () {
        $('#table').dataTable({
            columnDefs: [
              { orderable: false, targets: [4] }
            ]
        });
        Highcharts.setOptions({
            lang: {
                drillUpText: '◁ Back to Top'
            }
        });

        incomes();
        interest();
    });

    function incomes() {
        var data = JSON.parse('<?php echo addcslashes(json_encode($incomes), '\'\\'); ?>');
        var defaultTitle = "Total Incomes";
        var drilldownTitle = "Total Incomes";

        var chart_user = Highcharts.chart('incomes', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        // chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
                        // chart.setTitle({text: defaultTitle});
                    }
                }
            },
            xAxis: {
                type: 'category'
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
        $('#export_pdf_2').click(function() {
          Highcharts.exportCharts([chart_user], {
            type: 'application/pdf'
          });
        });
    }

    function interest() {
        var data = JSON.parse('<?php echo addcslashes(json_encode($interest), '\'\\'); ?>');
        var defaultTitle = "Total Interest";
        var drilldownTitle = "Total Interest";

        var chart_user = Highcharts.chart('interest', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        // chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
                        // chart.setTitle({text: defaultTitle});
                    }
                }
            },
            xAxis: {
                type: 'category'
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
        $('#export_pdf_3').click(function() {
          Highcharts.exportCharts([chart_user], {
            type: 'application/pdf'
          });
        });
    }
</script>
<script>
  /**
   * Create a global getSVG method that takes an array of charts as an
   * argument
   */
  Highcharts.getSVG = function(charts) {
    var svgArr = [],
      top = 0,
      width = 0;

    Highcharts.each(charts, function(chart) {
      var svg = chart.getSVG(),
        // Get width/height of SVG for export
        svgWidth = +svg.match(
          /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
        )[1],
        svgHeight = +svg.match(
          /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
        )[1];

      svg = svg.replace(
        '<svg',
        '<g transform="translate('+width+', 0 )" '
      );
      svg = svg.replace('</svg>', '</g>');

      width += svgWidth;
  		top = Math.max(top, svgHeight);

      svgArr.push(svg);
    });

    return '<svg height="' + top + '" width="' + width +
      '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
      svgArr.join('') + '</svg>';
  };

  /**
   * Create a global exportCharts method that takes an array of charts as an
   * argument, and exporting options as the second argument
   */
  Highcharts.exportCharts = function(charts, options) {

    // Merge the options
    options = Highcharts.merge(Highcharts.getOptions().exporting, options);

    // Post to export server
    Highcharts.post(options.url, {
      filename: options.filename || 'chart',
      type: options.type,
      width: options.width,
      svg: Highcharts.getSVG(charts)
    });
  };

</script>
