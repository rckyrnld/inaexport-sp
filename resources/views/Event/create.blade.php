@include('header')
<title>E-Reporting | Tambah User</title>
<div class="padding">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
   <style>
        .img_upl {
            border: 1px dashed #6fccdd;
            background: transparent;
        }

        .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
            background: #1a7688 !important;
            color: white;
        }

        .toggle.btn.btn-info{
            width: 15% !important;
        }
        .toggle.btn.btn-default.off{
            width: 15% !important;   
        }
    </style>
    @if($page=='show')
        <style type="text/css">
            div{
                pointer-events: none; 
            }
        </style>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" enctype="multipart/form-data" method="POST" @if($page=='add') action="{{url($url_store)}}" @elseif($page=='edit') action="{{url($url_update)}}" @endif id="formnya">
                {{ csrf_field() }}
                <div class="box">
                    <div class="box-divider m-0"></div>
                    <div class="box-body">
                        <div id="exTab2" class="container"> 
                             <div class="tab-content ">
                                <div class="tab-pane active" id="formprod">
                                    <br>
                                    <h3>Form Event</h3><hr>
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">
                                            <center><label for="lbl"><b>English</b></label></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><label for="lbl"><b>Indonesia</b></label></center>
                                        </div>
                                        <div class="col-md-3">
                                            <center><label for="lbl"><b>China</b></label></center>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="s_date" class="col-md-3"><b>Start Date</b></label>
                                        <div class="col-md-3">
                                            <input type="Date" class="form-control" name="s_date" id="s_date" autocomplete="off" @if($page!=='add') value="{{$sd}}" @endif>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="e_date" class="col-md-3"><b>End Date</b></label>
                                        <div class="col-md-3">
                                            <input type="Date" class="form-control" name="e_date" id="e_date" autocomplete="off" @if($page!=='add') value="{{$se}}" @endif>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Name</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventname_en" id="eventname_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_name_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventname_in" id="eventname_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_name_in}}" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventname_chn" id="eventname_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_name_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Type</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="eventype_en" id="eventype_en" required>
                                                <option value="" style="display: none;">- Pilih Event Type -</option>
                                                <option value="Fair" @if($page!=='add') @if($e_detail->event_type_en == 'Fair') selected @endif @endif>Fair</option>
                                                <option value="Spesial" @if($page!=='add') @if($e_detail->event_type_en == 'Spesial') selected @endif @endif>Spesial</option>
                                                <option value="General" @if($page!=='add') @if($e_detail->event_type_en == 'General') selected @endif @endif>General</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventype_in" id="eventype_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_type_in}}" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventype_chn" id="eventype_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_type_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Organizer</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="eventorgnzr_en" id="eventorgnzr_en" required>
                                                <option value="" style="display: none;">- Pilih Event Organizer -</option>
                                                @foreach($e_organizer as $eo)
                                                    <option value="{{$eo->id}}" @if($page!=='add') @if($e_detail->id_event_organizer == $eo->id) selected @endif @endif >{{$eo->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventorgnzr_in" id="eventorgnzr_in" autocomplete="off" @if($page!=='add') value="gatau" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventorgnzr_chn" id="eventorgnzr_chn" autocomplete="off" @if($page!=='add') value="gatau" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Organizer Text</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eot_en" id="eot_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_organizer_text_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eot_in" id="eot_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->even_organizer_text_in}}" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eot_chn" id="eot_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->even_organizer_text_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Place</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="eventplace_en" id="eventplace_en" required>
                                                <option value="" style="display: none;">- Pilih Event -</option>
                                                @foreach($e_palce as $ep)
                                                    <option value="{{$ep->id}}" @if($page!=='add') @if($e_detail->id_event_place == $ep->id) selected @endif @endif>{{$ep->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventplace_in" id="eventplace_in" autocomplete="off" @if($page!=='add') value="gatau2" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="eventplace_chn" id="eventplace_chn" autocomplete="off" @if($page!=='add') value="gatau2" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Place Text</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="ept_en" id="ept_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_place_text_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="ept_in" id="ept_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_place_text_in}}" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="ept_chn" id="ept_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_place_text_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Image</b></label>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_1" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_1" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($page=='add')
                                                        <img src="{{url('/')}}/image/plus/plusin.png" id="image_1_ambil" style="height: 40px; width: 40px;"/>
                                                    @elseif($page!=='add')
                                                        @if($e_detail->image_1 == NULL)
                                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_1_ambil" style="height: 40px; width: 40px;"/>
                                                        @else
                                                            <img src="{{url('/')}}/uploads/Event/Image/{{$e_detail->id}}/{{$e_detail->image_1}}" id="image_1_ambil" style="height: 100%; width: 100%;"/>
                                                        @endif
                                                    @endif
                                                </button>
                                                <input type="file" id="image_1" name="image_1" style="display: none;"/>
                                                <br>
                                                <center>+ Photo Utama</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_2" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_2" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($page=='add')
                                                        <img src="{{url('/')}}/image/plus/plusin.png" id="image_2_ambil" style="height: 40px; width: 40px;"/>
                                                    @elseif($page!=='add')
                                                        @if($e_detail->image_1 == NULL)
                                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_2_ambil" style="height: 40px; width: 40px;"/>
                                                        @else
                                                            <img src="{{url('/')}}/uploads/Event/Image/{{$e_detail->id}}/{{$e_detail->image_2}}" id="image_2_ambil" style="height: 100%; width: 100%;"/>
                                                        @endif
                                                    @endif
                                                </button>
                                                <input type="file" id="image_2" name="image_2" style="display: none;" />
                                                <br>
                                                <center>+ Photo 2</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_3" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_3" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($page=='add')
                                                        <img src="{{url('/')}}/image/plus/plusin.png" id="image_3_ambil" style="height: 40px; width: 40px;"/>
                                                    @elseif($page!=='add')
                                                        @if($e_detail->image_1 == NULL)
                                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_3_ambil" style="height: 40px; width: 40px;"/>
                                                        @else
                                                            <img src="{{url('/')}}/uploads/Event/Image/{{$e_detail->id}}/{{$e_detail->image_3}}" id="image_3_ambil" style="height: 100%; width: 100%;"/>
                                                        @endif
                                                    @endif
                                                </button>
                                                <input type="file" id="image_3" name="image_3" style="display: none;" />
                                                <br>
                                                <center>+ Photo 3</center>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div id="ambil_ttd_4" style="width: 100%;height: auto; border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                                                <button type="button" id="img_4" style="width: 100%; height: 120px;" class="img_upl">
                                                    @if($page=='add')
                                                        <img src="{{url('/')}}/image/plus/plusin.png" id="image_4_ambil" style="height: 40px; width: 40px;"/>
                                                    @elseif($page!=='add')
                                                        @if($e_detail->image_1 == NULL)
                                                            <img src="{{url('/')}}/image/plus/plusin.png" id="image_4_ambil" style="height: 40px; width: 40px;"/>
                                                        @else
                                                            <img src="{{url('/')}}/uploads/Event/Image/{{$e_detail->id}}/{{$e_detail->image_4}}" id="image_4_ambil" style="height: 100%; width: 100%;"/>
                                                        @endif
                                                    @endif
                                                </button>
                                                <input type="file" id="image_4" name="image_4" style="display: none;" />
                                                <br>
                                                <center>+ Photo 4</center>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="website" class="col-md-3"><b>Website</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="website" id="website" autocomplete="off" @if($page!=='add') value="{{$e_detail->website}}" @endif required>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Jenis</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="jenis_en" id="jenis_en" required>
                                                <option value="" style="display: none;">- Pilih Jenis -</option>
                                                <option value="To Be Confirm" @if($page!=='add') @if($e_detail->jenis_en == 'To Be Confirm') selected @endif @endif>To Be Confirm</option>
                                                <option value="Aktif" @if($page!=='add') @if($e_detail->jenis_en == 'Aktif') selected @endif @endif>Aktif</option>
                                                <option value="Mandiri" @if($page!=='add') @if($e_detail->jenis_en == 'Mandiri') selected @endif @endif>Mandiri</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="jenis_in" id="jenis_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->jenis_in}}" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="jenis_chn" id="jenis_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->jenis_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Comodity</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="eventcomodity" id="eventcomodity" required>
                                                <option value="" style="display: none;">- Pilih Event Comodity -</option>
                                                @foreach($e_comodity as $ec)
                                                    <option value="{{$ec->id}}" @if($page!=='add') @if($e_detail->event_comodity == $ec->id) selected @endif @endif>{{$ec->comodity_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Scope</b></label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="es_en" id="es_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_scope_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="es_in" id="es_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_scope_in}}" @endif>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="es_chn" id="es_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_scope_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Category Product</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="id_prod_cat[]" id="id_prod_cat" style="width:100%" multiple="multiple" required>
                                                {{optionCategory()}}
                                            </select>   
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Status</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" style="display: none;">- Pilih-</option>
                                                <option value="Verified" @if($page!=='add') @if($e_detail->status_en == 'Verified') selected @endif @endif>Verified</option>
                                                <option value="Tentatif" @if($page!=='add') @if($e_detail->status_en == 'Tentatif') selected @endif @endif>Tentatif</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="float: right;">
                                                @if($page=='show')
                                                    <a href="{{url('/event')}}" class="btn btn-danger" style="pointer-events: stroke;">Kembali</a>
                                                @else
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <a href="{{url('/event')}}" class="btn btn-danger">Cancel</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#img_1").click(function() {
                $("input[id='image_1']").click();
            });

            $("#img_2").click(function() {
                $("input[id='image_2']").click();
            });

            $("#img_3").click(function() {
                $("input[id='image_3']").click();
            });

            $("#img_4").click(function() {
                $("input[id='image_4']").click();
            });

            document.getElementById("image_1").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_2").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_3").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_4").addEventListener('change',handleFileSelect,false);

            $('#id_prod_cat').select2({
              sorter: function(data) {
                return data.sort(function(a, b) {
                    return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                });
            }
            }).on("select2:select", function (e) { 
              $('.select2-selection__rendered li.select2-selection__choice').sort(function(a, b) {
                  return $(a).text() < $(b).text() ? -1 : $(a).text() > $(b).text() ? 1 : 0;
                }).prependTo('.select2-selection__rendered');
            });
        });

    function handleFileSelect(evt){
        var files = evt.target.files; // FileList object
        var idfile = evt.target.id; // FileList object

        // FileReader support
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById(idfile+"_ambil").src = fr.result;
                document.getElementById(idfile+"_ambil").style.width = "100%";
                document.getElementById(idfile+"_ambil").style.height = "100%";
            }
            fr.readAsDataURL(files[0]);
        }
    }
    </script>
@include('footer')