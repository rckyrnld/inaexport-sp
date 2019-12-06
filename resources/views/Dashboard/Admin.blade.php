@include('header')
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

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

    /*CSS MODAL*/
    .modal-lg {
        width: 700px;
    }

    .modal-header {
        background-color: #84afd4;
        color: white;
        font-size: 20px;
        text-align: center;
    }

    .modal-body {
        height: 300px;
    }

    .modal-content {
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        overflow: hidden;
    }

    .modal-footer {
        background-color: #84afd4;
        color: white;
        font-size: 20px;
        text-align: center;
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
                            <i class="fa fa-plus-circle"></i> Member
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab2" onclick="cdata2()">
                            <i class="fa fa-plus-circle"></i> Research Corner
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab3">
                            <i class="fa fa-plus-circle"></i> Inquiry
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab4">
                            <i class="fa fa-plus-circle"></i> Buying Request
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab5">
                            <i class="fa fa-plus-circle"></i> Event
                        </a>
                        <a class="nav-link" data-toggle="tab" data-target="#tab6">
                            <i class="fa fa-plus-circle"></i> Training
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="tab-content p-3 mb-3">
                        <div class="tab-pane animate fadeIn text-muted active show" id="tab1">
                            <div class="row">
                                <div id="user_year" style="min-width: 100%; height: 400px; margin: 0 auto;"></div>
                                <a id="br1" onclick="exp1()" class="btn btn-success"><font color="white"><i
                                                class="fa fa-download"></i> Export PDF</font></a>
                            </div>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab2">
                            <div class="row">
                                <div id="top_downloader"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                            <br><br><br>
                            <div class="row">
                                <div id="top_rc"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>
                            </div>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab3">
                            <div class="row">
                                <div id="inquiry"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                            <div class="row">
                                <div id="top_inquiry"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab4">
                            <div class="row">
                                <div id="buying"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab5">
                            <div class="row">
                                <div id="event"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

                            </div>
                        </div>
                        <div class="tab-pane animate fadeIn text-muted" id="tab6">
                            <div class="row">
                                <div id="training"
                                     style="height: 300px; width: 100%; margin: 0 auto; float: left;"></div>

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

    $(document).ready(function () {
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
        var data = JSON.parse('<?php echo addcslashes(json_encode($User), '\'\\'); ?>');
        var defaultTitle = "Number of Memberships";
        var drilldownTitle = "Number of Memberships";

        var chart = Highcharts.chart('user_year', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
                        chart.setTitle({text: defaultTitle});
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
    }

    function inquiry() {
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Inquiry), '\'\\'); ?>');
        var data_top = JSON.parse('<?php echo addcslashes(json_encode($Top_Inquiry), '\'\\'); ?>');
        var defaultTitle = "Number of Inquiry This Year";
        var drilldownTitle = "Amount of Inquiry Year ";

        var chart = Highcharts.chart('inquiry', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
                        chart.setTitle({text: defaultTitle});
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
                type: 'category'
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
                text: 'Top Users'
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
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Buying), '\'\\'); ?>');
        var defaultTitle = "Number of Buying Request";
        var drilldownTitle = "Amount of Buying Year ";

        var chart = Highcharts.chart('buying', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
                        chart.setTitle({text: defaultTitle});
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
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Event), '\'\\'); ?>');
        var defaultTitle = "Number of Event This Year";
        var drilldownTitle = "Amount of Events Year ";

        var chart = Highcharts.chart('event', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
                        chart.setTitle({text: defaultTitle});
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
        var data_year = JSON.parse('<?php echo addcslashes(json_encode($Training), '\'\\'); ?>');
        var defaultTitle = "Number of Training This Year";
        var drilldownTitle = "Amount of Training Year ";

        var chart = Highcharts.chart('training', {
            chart: {
                type: 'column',
                events: {
                    drilldown: function (e) {
                        chart.setTitle({text: drilldownTitle + e.point.name});
                    },
                    drillup: function (e) {
                        chart.setTitle({text: defaultTitle});
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
        var data_company = JSON.parse('<?php echo addcslashes(json_encode($Top_Company_Download), '\'\\'); ?>');
        var data_rc = JSON.parse('<?php echo addcslashes(json_encode($Top_Downloaded_RC), '\'\\'); ?>');

        var chart = Highcharts.chart('top_downloader', {
            chart: {
                type: 'column'
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
            series: data_company,
            credits: {
                enabled: false
            },
            title: {
                text: 'Top 5 Company (Reasearch Corner)'
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
                type: 'category'
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
                text: 'Top Reasearch Corner'
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

    function exp1() {

        //send the div to PDF

        html2canvas($("#user_year"), { // DIV ID HERE
            onrendered: function (canvas) {
                var imgData = canvas.toDataURL('image/png');
                var doc = new jsPDF('landscape');
                doc.addImage(imgData, 'PDF', 10, 10);
                doc.save('sample-file.pdf'); //SAVE PDF FILE
            }
        });

    }
</script>