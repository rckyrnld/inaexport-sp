@include('frontend.layouts.header')
<?php
$loc = app()->getLocale();
$img1 = "front/assets/icon/icon account.png";
if($profile->foto_profil != NULL){
        $imge1 = 'uploads/Profile/Importir/'.$id_user.'/'.$profile->foto_profil;
        if(file_exists($imge1)) {
          $img1 = 'uploads/Profile/Importir/'.$id_user.'/'.$profile->foto_profil;
        }
    }
?>
<style type="text/css">
   .btn.navigasi.active{
        background-color: #1a70bb !important;
        border-color: #f5f5f5 !important;
        color: #f5f5f5 !important; 
    }
    .btn.navigasi{
        background-color: #f5f5f5 !important;
        border-color: #1a70bb !important;
        color: #1a70bb !important;
    }
    input.form-control, select.form-control{
        background-color: #f5f5f5;
    }
    .btn-file {
        position: relative;
        overflow: hidden;
        text-align: center; 
        width: 100%;
        background-color: #2492eb;
        font-weight: 600;
        color: #f5f5f5;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;   
        cursor: inherit;
        display: block;
    }
    span.logo{
        margin-left: 10px; font-size: 16px; font-weight: 700; color: #1a70bb
    }
    .form td{
        font-weight: 600;
    }
    th{
        text-align: center;
    }
    .form-control.contact{
        text-align: center;
        border-color: transparent;
    }
    td span{
        font-size: 24px;
    }
    .fa-minus-square-o{
        color: red;
    }
</style>
<!-- Profile Start -->
<div class="product_d_info" style="background-color: #ddeffd; margin: 5% 10% 5% 10%; border-radius: 15px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12" style="padding-left: 5%; padding-right: 5%;">
                <ul class="nav" role="tablist">
                    <li style="margin-right: 8px;">
                        <button class="btn navigasi active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false" style="min-width: 100%; width:200px; margin-right: 5px; font-weight: 600;">Account Information</button>
                    </li>
                    <li>
                        <button class="btn navigasi" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" style="min-width: 100%; width: 200px; font-weight: 600;">Contact</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <form id="profile" action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <br>
                        @if ($message = Session::get('warning'))
                            <div class="alert alert-warning alert-block" style="text-align: center; color: white;">
                                <button type="button" class="close" data-dismiss="alert">??</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <div class="row" style="padding-top: 15px">
                            <div class="col-lg-3 col-md-3">
                                <span class="logo">Logo</span>
                                <br>
                                <img id="thumbnail" src="{{asset($img1)}}" style="width: 220px; height: 225px; ">
                                <p style="padding: 6px; padding-top: 10px;">
                                    <span class="btn btn-primary btn-file" style="border-radius: 0px;">
                                        Upload <input type="file" name="avatar" accept="image/*" id="avatar"
{{--                                                      class="upload1"--}}
                                        />
                                    </span>
                                </p>
                            </div>
                            <div class="col-lg-1 col-md-1"></div>
                            <div class="col-lg-8 col-md-8 align-self-center">
                                <table width="100%" class="form" style="border-spacing: 10px; border-collapse: separate;">
                                    <tr>
                                        <td width="30%">Username</td>
                                        <td>
                                            <input type="text" class="form-control" name="username" value="{{$profile->username}}" id="username" data-toggle="tooltip" data-trigger="manual" title="Please Fill Username !">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Password</td>
                                        <td><input type="password" id="password" class="form-control" name="password" placeholder="############"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Re-Password</td>
                                        <td><input type="password" class="form-control" name="re_password" placeholder="############" id="re_password" data-toggle="tooltip" data-trigger="manual" title="Password is Not Matching !"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="padding-top: 20px">
                            <div class="col-lg-10 col-md-10"><hr style="border: 1px solid #99cdf5;"></div>
                        </div>
                        <div class="row" style="padding-top: 20px">
                            <div class="col-lg-12 col-md-12">
                                <span class="logo">Information Company</span>
                                <table width="100%" class="form" style="border-spacing: 10px; border-collapse: separate;">
                                    <tr>
                                        <td width="30%">Country</td>
                                        <td>
                                            <select class="form-control" name="country" id="country" required>
                                                @foreach($country as $data)
                                                <option value="{{$data->id}}" @if($data->id == $profile->id_mst_country) selected @endif>{{$data->country}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Business Entity</td>
                                        <td>
										<select name="badanusaha" class="form-control">
		<option>-</option>
		<?php 
		$bns = DB::select("select * from eks_business_entity");
		foreach($bns as $val){
		?>
		<option <?php if($profile->badanusaha == $val->nmbadanusaha){ echo "selected"; } ?> value="<?php echo $val->nmbadanusaha; ?>"><?php echo $val->nmbadanusaha; ?></option>
  <?php } ?>
		</select></td>
                                    </tr>
									<tr>
                                        <td width="30%">Name of Company</td>
                                        <td>
										<input type="text" class="form-control" name="name_company" value="{{$profile->company}}" id="name_company" data-toggle="tooltip" data-trigger="manual" title="Please Fill Name of Company !">
										</td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Address</td>
                                        <td><input type="text" class="form-control" name="address" value="{{$profile->addres}}" required></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">City</td>
                                        <td>
                                            <!--<select class="form-control" name="city" id="city" data-toggle="tooltip" data-trigger="manual" title="Please Select City !">
                                            </select> -->
											<input type="text" class="form-control" name="city" value="{{$profile->city}}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Zip Code</td>
                                        <td><input type="text" class="form-control integer" name="zip_code" value="{{$profile->postcode}}"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">E-mail</td>
                                        <td><input type="email" class="form-control" name="email" value="{{$profile->email}}" id="email" data-toggle="tooltip" data-trigger="manual" title="Please Fill E-mail !"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Fax</td>
                                        <td><input type="text" class="form-control" name="fax" value="{{$profile->fax}}"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Website</td>
                                        <td><input type="text" class="form-control" onkeyup="cekwebsite()" id="website" name="website" value="{{$profile->website}}"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Phone</td>
                                        <td><input type="text" class="form-control" name="phone" value="{{$profile->phone}}"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="right">
                                            <button type="button" class="btn navigasi active" style="width: 20%;font-weight: 600;" onclick="send('#profile')">Update</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <form id="form-contact" action="{{route('profile.contact_update')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row justify-content-center" style="padding-top: 30px">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive">
                                    
                                    <table class="table table-bordered" style="text-align: center;">
                                        <thead style="background-color: #1a70bb; color: #f5f5f5;">
                                            <tr>
                                                <th>Name</th>
                                                <th>E-mail</th>
                                                <th>Phone</th>
                                                <th width="6%" valign="middle"><a onclick="tambah()"><span class="fa fa-plus-circle" aria-hidden="true" style="font-size: 20px"></span></a></th>
                                            </tr>
                                        </thead>
                                        <tbody style="background-color: #f5f5f5" id="tbody_contact">
                                            <input type="hidden" id="number" value="{{count($contact)}}">
                                            @foreach ($contact as $key => $value)
                                                <tr id="contact_{{$key+1}}">
                                                    <td><input type="text" name="name_contact[]" class="form-control contact" value="{{$value->name}}" autocomplete="off"></td>
                                                    <td><input type="text" name="email_contact[]" class="form-control contact" value="{{$value->email}}" autocomplete="off"></td>
                                                    <td><input type="text" name="phone_contact[]" class="form-control contact" value="{{$value->phone}}" autocomplete="off"></td>
                                                    <td><a onclick="hapus('{{$key+1}}')"><i class="fa fa-minus-square-o" aria-hidden="true" style="font-size: 24px;"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div align="right"><button class="btn navigasi active" type="submit" style="width: 20%;font-weight: 600;">Update</button></div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Profile End -->

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
        var country = $('#country').val();
        $.ajax({
          url: "{{route('ajax-city', $id_user)}}",
          type: 'get',
          data: {
            id:country
          },
          dataType: 'json',
          success:function(response){
            $('#city').append(response);
          }
        });

        $('input').attr('autocomplete', 'off');
        $('#country').on('change', function(){
            var data = this.value;
            $(".option_city").each(function() {
                $(this).remove();
            });
            $.ajax({
              url: "{{route('ajax-city', 'null')}}",
              type: 'get',
              data: {
                id:data
              },
              dataType: 'json',
              success:function(response){
                $('#city').append(response);
              }
            });
        });

        $('.integer').inputmask({
            alias:"integer",
            digitsOptional:false,
            decimalProtect:false,
            radixFocus:true,
            autoUnmask:false,
            allowMinus:false,
            rightAlign:false,
            clearMaskOnLostFocus: false,
            onBeforeMask: function (value, opts) {
                return value;
            },        removeMaskOnSubmit:true
        });

        $("#avatar").change(function() {
          thumbnail(this);
        });
    });

    function hapus(id) {
        $('#contact_'+id).remove();
    }

    function tambah(){
        var table = '';
        var nomor = parseInt($('#number').val());
        table += '<tr id="contact_'+nomor+'">';
        table += '<td><input type="text" name="name_contact[]" class="form-control contact" autocomplete="off"></td>';
        table += '<td><input type="text" name="email_contact[]" class="form-control contact" autocomplete="off"></td>';
        table += '<td><input type="text" name="phone_contact[]" class="form-control contact" autocomplete="off"></td>';
        table += '<td><a onclick="hapus('+nomor+')"><i class="fa fa-minus-square-o" aria-hidden="true" style="font-size: 24px;"></i></a></td>';
        table += '</tr>';
        $('#tbody_contact').append(table);
        $('#number').val(parseInt(nomor)+1);
    }

    function send(form){
        if ($('#username').val() == '') {
            $('#username').tooltip('toggle');
            $('#username').focus();
            setTimeout(function () {
                $('#username').tooltip('toggle');
            }, 1000);
        } else if ($('#password').val() != $('#re_password').val()){
            $('#re_password').tooltip('toggle');
            $('#re_password').focus();
            setTimeout(function () {
                $('#re_password').tooltip('toggle');
            }, 1000);
        } else if ($('#name_company').val() == ''){
            $('#name_company').tooltip('toggle');
            $('#name_company').focus();
            setTimeout(function () {
                $('#name_company').tooltip('toggle');
            }, 1000);
        } else if ($('#city').val() == ''){
            $('#city').tooltip('toggle');
            $('#city').focus();
            setTimeout(function () {
                $('#city').tooltip('toggle');
            }, 1000);
        } else if ($('#email').val() == '' || !isEmail($('#email').val())){
            $('#email').tooltip('toggle');
            $('#email').focus();
            setTimeout(function () {
                $('#email').tooltip('toggle');
            }, 1000);
        } else {
            $(form).submit();
        }
    }

    function thumbnail(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#thumbnail').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
      }
    }

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    $('.upload1').on('change', function(evt){
        var size = this.files[0].size;
        if(size > 5000000){
        //     if(size > 20000){
            $(this).val("");
            alert('image size must less than 5MB');
        }
        else{

        }
    })

    function cekwebsite(){
        var m = $('#website').val();
        var carikoma = m.search(",");
        if(carikoma != "-1"){
            $('#website').val("");
        }
        var carispa = m.search(" ");
        if(carispa != "-1"){
            $('#email').val("");
        }
    }
</script>