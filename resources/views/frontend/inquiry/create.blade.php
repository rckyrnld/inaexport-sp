@include('frontend.layout.header')

<div class="d-flex flex-column flex" style="">
	<div class="light bg pos-rlt box-shadow" style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;    background-color: #2791a6 ; color: #ffffff">
    <div class="mx-auto">
    	<table border="0" width="100%">
      	<tr>
      	<td width="30%" style="font-size:13px;padding-left:10px"><img height="30px" src="{{url('assets')}}/assets/images/logo.jpg" alt="." ><b>&nbsp;&nbsp;&nbsp; Ministry Of Trade</b></td>
      	<td width="30%"></td>
      	<td width="40%" align="right" style="padding-right:10px;">
        	<a href="{{ url('locale/en') }}"><img width="20px" height="15px" src="{{asset('negara/en.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/in') }}"><img width="20px" height="15px" src="{{asset('negara/in.png')}}"></a>&nbsp;
        	<a href="{{ url('locale/ch') }}"><img width="20px" height="15px" src="{{asset('negara/ch.png')}}"></a>&nbsp;&nbsp;&nbsp;
        	<a href="{{url('login')}}"><font color="white"><i class="fa fa-sign-in"></i> @lang("frontend.lbl3")</font></a>
      	</td>
      	</tr>
    	</table>
    </div>
  </div>
  <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{url($url)}}" id="formnya">
  {{ csrf_field() }}
  <div id="content-body">
    <div class="py-5 w-100">
      <center><h4><b>@lang("frontend.title2")</b></h4><br></center>
      <div class="container">
        <div class="box" style="padding: 20px;">
        <?php
          $loc = app()->getLocale();
          $lct = "";
          if($loc == "ch"){
            $lct = "chn";
          }elseif($loc == "in"){
            $lct = "in";
          }else{
            $lct = "en";
          }
        ?>
          <br>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
              <h5><b>@lang('inquiry.form')</b></h5>
            </div>
          </div><br><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.prodname')</b></label>
            <div class="col-md-7">
              <input type="hidden" name="id_product" id="id_product" value="{{$data->id}}">
              <input type="hidden" name="type" id="type" value="importir">
              <b>{{getProductAttr($data->id, 'prodname', $lct)}}</b>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.category')</b></label>
            <div class="col-md-7">
              <b>
                <?php
                  $cat1 = getCategoryName($data->id_csc_product, $lct);
                  $cat2 = getCategoryName($data->id_csc_product_level1, $lct);
                  $cat3 = getCategoryName($data->id_csc_product_level2, $lct);

                  if($cat1 == "-"){
                    echo $cat1;
                  }else{
                    if($cat2 == "-"){
                      echo $cat1;
                    }else{
                      if($cat3 == "-"){
                        echo $cat1." > ".$cat2;
                      }else{
                        echo $cat1." > ".$cat2." > ".$cat3;
                      }
                    }
                  }
                ?>
              </b>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.kos')</b></label>
            <div class="col-md-4">
              <select class="form-control" name="kos" id="kos">
                <option value="" style="display: none;"> - @lang('inquiry.selectkos') - </option>
                <option value="offer to sell">@lang('inquiry.ots')</option>
                <option value="offer to buy">@lang('inquiry.otb')</option>
                <option value="consultation">@lang('inquiry.consul')</option>
              </select>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.company')</b></label>
            <div class="col-md-7">
              <b>{{getCompanyName($data->id_itdp_company_user)}}</b>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.subject')</b></label>
            <div class="col-md-4">
              <input type="text" name="subject" class="form-control" id="subject" autocomplete="off">
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.msg')</b></label>
            <div class="col-md-7">
              <textarea class="form-control" id="messages" name="messages"></textarea>
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.file')</b></label>
            <div class="col-md-4">
              <input type="file" name="filedo" class="form-control" id="filedo">
            </div>
            <div class="col-md-1"></div>
          </div><br>
          <div class="row">
            <div class="col-md-2"></div>
            <label class="col-md-2"><b>@lang('inquiry.duration')</b></label>
            <div class="col-md-4">
              <select class="form-control" name="duration" id="duration">
                <option value="" style="display: none;"> - @lang('inquiry.selectduration') - </option>
                <option value="1 week">@lang('inquiry.v1w')</option>
                <option value="2 weeks">@lang('inquiry.v2w')</option>
                <option value="3 weeks">@lang('inquiry.v3w')</option>
                <option value="1 month">@lang('inquiry.v1m')</option>
                <option value="2 months">@lang('inquiry.v2m')</option>
                <option value="3 months">@lang('inquiry.v3m')</option>
                <option value="4 months">@lang('inquiry.v4m')</option>
                <option value="5 months">@lang('inquiry.v5m')</option>
                <option value="6 months">@lang('inquiry.v6m')</option>
              </select>
            </div>
            <div class="col-md-1"></div>
          </div><br><br>
          <div class="row">
            <div class="col-md-11">
              <div style="float: right;">
                <a class="btn btn-danger" href="{{url('/front_end')}}">@lang('inquiry.cancel')</a>
                <button type="button" class="btn btn-primary" id="btnsubmit">@lang('inquiry.submit')</button>
              </div>
            </div>
          </div><br>
        </div>
      </div>
        <div class="px-3">
         {{--  <div>
            <a href="#" class="btn btn-block indigo text-white mb-2">
              <i class="fa fa-facebook float-left"></i>
              Sign in with Facebook
            </a>
            <a href="#" class="btn btn-block red text-white">
              <i class="fa fa-google-plus float-left"></i>
              Sign in with Google+
            </a>
          </div> --}}
          {{-- <div class="my-3 text-sm">
            OR
          </div> --}}
         
		  
          <div class="my-4">
           <!-- <a href="{{ route('password.request') }}" class="text-primary _600">Forgot password?</a> -->
          </div>
          <div>
           <!-- Do not have an account? 
            <a href="{{url('register')}}" class="text-primary _600">Sign up</a> -->
          </div>
        </div>
		
      </div>
    </div>
    </form>
  </div>
</div>
<?php
  $alertkos = "";
  $alertsubject = "";
  $alertmsg = "";
  $alertfile = "";
  $alertdurasi = "";

  if($loc == "ch"){
    $alertkos = "主题种类为空，请填写！";
    $alertsubject = "主题为空，请填写！";
    $alertmsg = "留言为空，请填写！";
    $alertfile = "文件为空，请填写！";
    $alertdurasi = "期限为空，请填写！";    
  }else if($loc == "in"){
    $alertkos = "Jenis Subjek kosong, silahkan isi!";
    $alertsubject = "Subjek kosong, silahkan isi!";
    $alertmsg = "Pesan kosong, silahkan isi!";
    $alertfile = "File kosong, silahkan isi!";
    $alertdurasi = "Durasi kosong, silahkan isi!";
  }else{
    $alertkos = "Kind of Subject is empty, please fill in!";
    $alertsubject = "Subject is empty, please fill in!";
    $alertmsg = "Messages is empty, please fill in!";
    $alertfile = "File is empty, please fill in!";
    $alertdurasi = "Duration is empty, please fill in!";
  }
?>
<script type="text/javascript">
  $(function(){
    CKEDITOR.replace('messages');
  });

  $(document).ready(function () {
    // location.reload();
    $('#btnsubmit').on('click', function () {
      var data = CKEDITOR.instances.messages.getData();
      
      if ($('#kos').val() == "") {
          alert("<?php echo $alertkos; ?>");
      }else if ($('#subject').val() == "") {
          alert("<?php echo $alertsubject; ?>");
      }else if (data == "") {
          alert("<?php echo $alertmsg; ?>");
      }else if ($('#filedo').val() == "") {
          alert("<?php echo $alertfile; ?>");
      }else if ($('#duration').val() == "") {
          alert("<?php echo $alertdurasi; ?>");
      }else {
          $('#formnya').submit();
          // alert("Sukses");//tinggal buat action inquiry nya
      }
    });
    // $('#jmldurasi').inputmask({
    //     alias:"integer",
    //     repeat:3,
    //     digitsOptional:false,
    //     decimalProtect:false,
    //     radixFocus:true,
    //     autoUnmask:false,
    //     allowMinus:false,
    //     rightAlign:false,
    //     clearMaskOnLostFocus: false,
    //     onBeforeMask: function (value, opts) {
    //         return value;
    //     },
    //     removeMaskOnSubmit:true
    // });

  });
</script>

@include('frontend.layout.footer')