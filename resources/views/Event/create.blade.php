@include('header')
<title>E-Reporting | Tambah User</title>
<div class="padding">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    <div class="row" id="show">
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
                                            <input type="Date" class="form-control" name="s_date" id="s_date" autocomplete="off" @if($page!=='add') value="{{$sd}}" @endif required>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="e_date" class="col-md-3"><b>End Date</b></label>
                                        <div class="col-md-3">
                                            <input type="Date" class="form-control" name="e_date" id="e_date" autocomplete="off" @if($page!=='add') value="{{$se}}" @endif required>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Name</b></label>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventname_en" id="eventname_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_name_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventname_in" id="eventname_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_name_in}}" @endif>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventname_chn" id="eventname_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_name_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Type</b></label>
                                        <div class="col-md-3 paddignya">
                                            <select class="form-control" name="eventype_en" id="eventype_en" required onchange="EventType(this)">
                                                <option value="" style="display: none;">- Pilih Event Type -</option>
                                                <option value="Fair" @if($page!=='add') @if($e_detail->event_type_en == 'Fair') selected @endif @endif>Fair</option>
                                                <option value="Spesial" @if($page!=='add') @if($e_detail->event_type_en == 'Spesial') selected @endif @endif>Special</option>
                                                <option value="General" @if($page!=='add') @if($e_detail->event_type_en == 'General') selected @endif @endif>General</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventype_in" id="eventype_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_type_in}}" @endif>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventype_chn" id="eventype_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_type_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Organizer</b></label>
                                        <div class="col-md-3 paddignya">
                                            <table width="100%" border="0">
                                                <tr>
                                                    <td width="80%">
                                                        <select class="form-control" name="eventorgnzr_en" id="eventorgnzr_en" required onchange="EventOrg(this)">
                                                            <option value="" style="display: none;">- Pilih Event Organizer -</option>
                                                            @foreach($e_organizer as $eo)
                                                                <option value="{{$eo->id}}" @if($page!=='add') @if($e_detail->id_event_organizer == $eo->id) selected @endif @endif >{{$eo->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="padding-left: 5px;"><button type="button" class="btn btn-default" style="width: 100%; border-color: #bbc0c5;"  data-toggle="modal" data-target="#modal-eo"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventorgnzr_in" id="eventorgnzr_in" autocomplete="off" @if($page!=='add') value="{{EvenOrgZ($e_detail->id_event_organizer, 'in')}}" @endif readonly>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventorgnzr_chn" id="eventorgnzr_chn" autocomplete="off" @if($page!=='add') value="{{EvenOrgZ($e_detail->id_event_organizer, 'chn')}}" @endif readonly>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Organizer Text</b></label>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eot_en" id="eot_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_organizer_text_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eot_in" id="eot_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->even_organizer_text_in}}" @endif>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eot_chn" id="eot_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->even_organizer_text_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Place</b></label>
                                        <div class="col-md-3 paddignya">
                                            <table width="100%" border="0">
                                                <tr>
                                                    <td width="80%">
                                                        <select class="form-control" name="eventplace_en" id="eventplace_en" required onchange="EventPlace(this)">
                                                            <option value="" style="display: none;">- Pilih Event -</option>
                                                            @foreach($e_palce as $ep)
                                                                <option value="{{$ep->id}}" @if($page!=='add') @if($e_detail->id_event_place == $ep->id) selected @endif @endif>{{$ep->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="padding-left: 5px;"><button type="button" class="btn btn-default" style="width: 100%; border-color: #bbc0c5;" data-toggle="modal" data-target="#modal-place"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventplace_in" id="eventplace_in" autocomplete="off" @if($page!=='add') value="{{EventPlaceZ($e_detail->id_event_place, 'in')}}" @endif readonly>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="eventplace_chn" id="eventplace_chn" autocomplete="off" @if($page!=='add') value="{{EventPlaceZ($e_detail->id_event_place, 'chn')}}" @endif readonly>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Place Text</b></label>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="ept_en" id="ept_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_place_text_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="ept_in" id="ept_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_place_text_in}}" @endif>
                                        </div>
                                        <div class="col-md-3 paddignya">
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
                                                <input type="file" accept="image/*" id="image_1" name="image_1" style="display: none;"/>
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
                                                <input type="file" accept="image/*" id="image_2" name="image_2" style="display: none;" />
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
                                                <input type="file" accept="image/*" id="image_3" name="image_3" style="display: none;" />
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
                                                <input type="file" accept="image/*" id="image_4" name="image_4" style="display: none;" />
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
                                        <div class="col-md-3 paddignya">
                                            <select class="form-control" name="jenis_en" id="jenis_en" required onchange="Jenis(this)">
                                                <option value="" style="display: none;">- Pilih Jenis -</option>
                                                <option value="To Be Confirm" @if($page!=='add') @if($e_detail->jenis_en == 'To Be Confirm') selected @endif @endif>To Be Confirm</option>
                                                <option value="Aktif" @if($page!=='add') @if($e_detail->jenis_en == 'Aktif') selected @endif @endif>Active</option>
                                                <option value="Mandiri" @if($page!=='add') @if($e_detail->jenis_en == 'Mandiri') selected @endif @endif>Independent</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="jenis_in" id="jenis_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->jenis_in}}" @endif>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="jenis_chn" id="jenis_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->jenis_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Comodity</b></label>
                                        <div class="col-md-3">
                                            @if($page != 'show')
                                            <select class="form-control" id="com" required name="eventcomodity">
                                               <option></option>
                                            </select>
                                            @else 
                                                <input class="form-control" type="text" readonly value="{{getEventComodity($e_detail->event_comodity)}}">
                                            @endif
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Event Scope</b></label>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="es_en" id="es_en" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_scope_en}}" @endif required>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="es_in" id="es_in" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_scope_in}}" @endif>
                                        </div>
                                        <div class="col-md-3 paddignya">
                                            <input type="text" class="form-control" name="es_chn" id="es_chn" autocomplete="off" @if($page!=='add') value="{{$e_detail->event_scope_chn}}" @endif>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Category Product</b></label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="id_prod_cat[]" id="id_prod_cat" style="width:100%" multiple="multiple" required>
                                                <option></option>
                                                @if($page!='add') {{optionCategoryZ($e_detail->id)}} @else {{optionCategory()}} @endif
                                            </select>   
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                    <div class="row">
                                        <label for="code" class="col-md-3"><b>Country</b></label>
                                        <div class="col-md-3">
                                            @if($page != 'show')
                                            <select class="form-control" id="country" required name="country">
                                                <option></option>
                                                @foreach($country as $data)
                                                    <option value="{{$data->id}}" @isset($e_detail) @if($e_detail->country == $data->id) selected @endif @endisset>{{$data->country}}</option>
                                                @endforeach
                                            </select>
                                            @else 
                                                <input class="form-control" type="text" readonly value="{{rc_country($e_detail->country)}}">
                                            @endif
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
                                        <label for="code" class="col-md-3"><b>Registration Date</b></label>
                                        <div class="col-md-3">
                                            <input type="text" id="daterange" class="form-control">
                                            <input type="hidden" name="registration_date" @if($page!=='add') value="{{$e_detail->reg_date}}" @endif>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                    </div><br>
                                </div>
                            </div>
                        </div><br>
                        <input type="hidden" name="eo_en" id="real_eo_en">
                        <input type="hidden" name="eo_in" id="real_eo_in">
                        <input type="hidden" name="eo_chn" id="real_eo_chn">
                        <input type="hidden" name="plc_en" id="real_plc_en">
                        <input type="hidden" name="plc_in" id="real_plc_in">
                        <input type="hidden" name="plc_chn" id="real_plc_chn">
                        <h4>Contact Person</h4><hr>
                        <div class="container">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="row">
                                  <div class="col-md-6">
                                    <b>Full Name</b>
                                  </div>
                                  <div class="col-md-6">
                                    <input type="text" autocomplete="off" class="form-control" name="cp_name" @if($page != 'add') @if($cp) value="{{$cp->name}}" @endif @endif required>
                                  </div>
                                </div><br>
                                <div class="row">
                                  <div class="col-md-6">
                                    <b>Email</b>
                                  </div>
                                  <div class="col-md-6">
                                    <input type="email" autocomplete="off" class="form-control" name="cp_email" @if($page != 'add') @if($cp) value="{{$cp->email}}" @endif @endif required>
                                  </div>
                                </div><br>
                              </div>
                              <div class="col-md-6">
                                <div class="row">
                                  <div class="col-md-2"></div>
                                  <div class="col-md-4">
                                    <b>Phone</b>
                                  </div>
                                  <div class="col-md-6">
                                    <input type="text" onkeypress="this.value=removeSpaces(this.value);" autocomplete="off" class="form-control" name="cp_phone" maxlength="15" @if($page != 'add') @if($cp) value="{{$cp->phone}}" @endif @endif required>
                                  </div>
                                </div><br>
                              </div>
                            </div>
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
            </form>
        </div>
    </div>

    <!-- MODAL EO -->
    <div class="modal fade" id="modal-eo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Event Organizer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table width="100%" cellpadding="5">
                <tr>
                    <td style="width: 30%">Event Organizer ( Eng )</td>
                    <td><input type="text" class="form-control" id="eo_en"></td>
                </tr>
                <tr>
                    <td>Event Organizer ( Ind )</td>
                    <td><input type="text" class="form-control" id="eo_in"></td>
                </tr>
                <tr>
                    <td>Event Organizer ( Chn )</td>
                    <td><input type="text" class="form-control" id="eo_chn"></td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" onclick="add_eo()" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL place -->
    <div class="modal fade" id="modal-place" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Place</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <table width="100%" cellpadding="5">
                <tr>
                    <td style="width: 30%">Event Place ( Eng )</td>
                    <td><input type="text" class="form-control" id="plc_en"></td>
                </tr>
                <tr>
                    <td>Event Place ( Ind )</td>
                    <td><input type="text" class="form-control" id="plc_in"></td>
                </tr>
                <tr>
                    <td>Event Place ( Chn )</td>
                    <td><input type="text" class="form-control" id="plc_chn"></td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" onclick="add_place()" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>


    <script type="text/javascript">
        csrf_token = '{{ csrf_token() }}';
        var adding_place = [];
        var adding_eo = [];

        function EventType(obj){
            $('#eventype_in').val('');
            $('#eventype_chn').val('');
            val = $(obj).val();
            if (val=='Fair') {
                $('#eventype_in').val('Pameran');
                $('#eventype_chn').val('公平');
            }else if(val=='Spesial'){
                $('#eventype_in').val('Spesial');
                $('#eventype_chn').val('特别的');
            }else{
                $('#eventype_in').val('Umum');
                $('#eventype_chn').val('一般');
            }
        }

        function EventOrg(obj){
            val = $(obj).val();
            $('#eventorgnzr_in').val('');
            $('#eventorgnzr_chn').val('');
            if(val == '|adding_eo|'){
                $('#eventorgnzr_in').val(adding_eo[0]);
                $('#eventorgnzr_chn').val(adding_eo[1]);
            } else {
                $.post("{{ url('/') }}/event/getEventOrg", {'_token':csrf_token, 'id':val}, function(response){
                    res = JSON.parse(response);
                    $('#eventorgnzr_in').val(res.name_in);
                    $('#eventorgnzr_chn').val(res.name_chn);
                });
            }
        }

        function EventPlace(obj){
            val = $(obj).val();
            $('#eventplace_in').val();
            $('#eventplace_chn').val();
            if(val == '|adding_place|'){
                $('#eventplace_in').val(adding_place[0]);
                $('#eventplace_chn').val(adding_place[1]);
            } else {
                $.post("{{url('/')}}/event/getEventPlace", {'_token':csrf_token, 'id':val}, function(response){
                    res=JSON.parse(response);
                    $('#eventplace_in').val(res.name_in);
                    $('#eventplace_chn').val(res.name_chn);
                });
            }
        }

        function Jenis(obj){
            val = $(obj).val();
            $('#jenis_in').val('');
            $('#jenis_chn').val('');

            if (val=='To Be Confirm') {
                $('#jenis_in').val('Menjadi Konfirmasi');
                $('#jenis_chn').val('要确认');
            }else if(val=='Aktif'){
                $('#jenis_in').val('Aktif');
                $('#jenis_chn').val('活跃的');
            }else{
                $('#jenis_in').val('Mandiri');
                $('#jenis_chn').val('曼迪里');
            }
        }

        function add_eo(){
            var eo_en = $('#eo_en').val();
            var eo_in = $('#eo_in').val();
            var eo_chn = $('#eo_chn').val();

            if(eo_en != ''){
                $('#eventorgnzr_en option[value="|adding_eo|"]').remove();
                $('#eventorgnzr_en').append('<option value="|adding_eo|">'+eo_en+'</option>'); 
                $('#eventorgnzr_en option[value="|adding_eo|"]').attr("selected",true);
                adding_eo = [eo_in,eo_chn];
                $('#real_eo_en').val(eo_en);
                $('#real_eo_in,#eventorgnzr_in').val(eo_in);
                $('#real_eo_chn,#eventorgnzr_chn').val(eo_chn);
            }
            $('#modal-eo').modal('hide');
        }

        function add_place(){
            var place_en = $('#plc_en').val();
            var place_in = $('#plc_in').val();
            var place_chn = $('#plc_chn').val();

            if(place_en != ''){
                $('#eventplace_en option[value="|adding_place|"]').remove();
                $('#eventplace_en').append('<option value="|adding_place|">'+place_en+'</option>'); 
                $('#eventplace_en option[value="|adding_place|"]').attr("selected",true);
                adding_place = [place_in,place_chn];
                $('#real_plc_en').val(place_en);
                $('#real_plc_in,#eventplace_in').val(place_in);
                $('#real_plc_chn,#eventplace_chn').val(place_chn);
            }
            $('#modal-place').modal('hide');
        }

        $(document).ready(function () {
            var page = '{{$page}}';
            $('#daterange').daterangepicker();
            $('#daterange').on('hide.daterangepicker', function(ev, picker) {
              var format = picker.startDate.format('YYYY-MM-DD')+' ~ '+picker.endDate.format('YYYY-MM-DD');
              $('input[name="registration_date"]').val(format);
            });

            if(window.innerWidth <= 780){
                $(".paddignya").css("padding-top","10px");
            } 

            if(page == 'show'){
                $('#show :input').prop('disabled', true);
            }
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

            $('#country').select2({ placeholder: 'Select Country' });

            $('#com').select2({ 
              allowClear: true,
              placeholder: 'Select Comodity',
              ajax: {
                url: "{{route('event.comodity')}}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: $.map(data, function (item) {
                      return {
                        text: item.comodity_en,
                        id: item.id
                      }
                    })
                  };
                },
                cache: true
              }
            });
            @isset($e_detail)
            var reg_date = "{{$e_detail->reg_date}}";
            var comoditynya = "{{$e_detail->event_comodity}}";
            if (comoditynya != null) {
                $.ajax({
                    type: 'GET',
                    url: "{{route('event.comodity')}}",
                    data: { code: comoditynya }
                }).then(function (data) {
                    var option = new Option(data[0].comodity_en, data[0].id, true, true);

                    $('#com').append(option).trigger('change');
                });
            }
            if(reg_date != ''){
                reg_date = reg_date.split(' ~ ');
                var startDate = new Date(reg_date[0]);
                var endDate = new Date(reg_date[1]);

                $('#daterange').data('daterangepicker').setStartDate( (startDate.getMonth() + 1) + "/" + startDate.getDate() + "-" + startDate.getFullYear());
                $('#daterange').data('daterangepicker').setEndDate( (endDate.getMonth() + 1) + "/" + endDate.getDate() + "-" + endDate.getFullYear());
            }
            @endisset

            document.getElementById("image_1").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_2").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_3").addEventListener('change',handleFileSelect,false);
            document.getElementById("image_4").addEventListener('change',handleFileSelect,false);

            $('#id_prod_cat').select2({
                placeholder: 'Select Category',
                sorter: function(data) {
                    return data.sort(function(a, b) {
                        return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                    });
                }
            }).on("select2:select", function (e) { 
              $('#id_prod_cat-selection__rendered li#id_prod_cat-selection__choice').sort(function(a, b) {
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

        function removeSpaces(string) {
           return string.split(' ').join('');
          }
    </script>
@include('footer')