@include('frontend.layouts.header')

<?php
  $loc = app()->getLocale();
  if(Auth::user()){
    $for = 'admin';
    $message = '';
  } else if(Auth::guard('eksmp')->user()){
    if(Auth::guard('eksmp')->user()->id_role == 2){
      $for = 'eksportir';
      $message = '';
    } else {
      $for = 'importir';
        if($loc == "ch"){
          $message = "您无权下载";
        }elseif($loc == "in"){
          $message = "Anda Tidak Memiliki Akses untuk Mengunduh!";
        }else{
          $message = "You do not Have Access to Download!";
        }
    }
  } else {
    $for = 'non user';
      if($loc == "ch"){
        $message = "请先登录";
      }elseif($loc == "in"){
        $message = "Silahkan Login Terlebih Dahulu!";
      }else{
        $message = "Please Login to Continue!";
      }
  }
?>
<style type="text/css">
  img.rc{
    max-width: 100%;
    max-height: 100%;
    border-radius: 10px;
  }
  .detail_rc{
    color: #1a70bb;
    font-family: 'Arial' !important; 
  }

  .kontennya:hover{
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }

  
  .search{
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .search-event{
        width: 100%;
    }

    .sel-event{
        height: 100%;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        padding-left: 5px;
        background-color: #f7f7f7;
        border-left: 2px solid #1a70bb;
        border-top: 2px solid #1a70bb;
        border-bottom: 2px solid #1a70bb;
    }

    .select2-selection__rendered {
        line-height: 32px !important;
        float: left !important;
    }
    .select2-container .select2-selection--single {
        height: 37px !important;
        border-top : 2px solid #1a70bb;
        border-bottom : 2px solid #1a70bb;
    }
    .select2-container {
        float: left !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }

</style>
<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">@lang("frontend.proddetail.home")</a></li>
                            <li>Research Corner</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--breadcrumbs area end-->

<div class="shop_area shop_reverse" style="background-color: white; padding-bottom: 3%;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-6">
        <span style="color: #1a70bb; text-align: left;"><h2>Research Corner</h2></span>
      </div>
      <div class="col-md-6 col-lg-6" align="right"><br>
                    <form class="form-horizontal" enctype="multipart/form-data" method="GET" action="{{url('/front_end/research-corner')}}">
                        {{ csrf_field() }}
                        <div class="input-group search-event">
                            <div class="input-group-prepend">
                                <select id="search" name="search" class="sel-event">
                                    <option value="1" @if($searchEvent == 1) selected @endif>Product</option>
                                    <option value="2" @if($searchEvent == 2) selected @endif>Country</option>
                                </select>
                            </div>
                            <select class="form-control select2 search " name="country" id="search_country" style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;" >
                                <option value=""></option>
                            </select>
                            <!-- <select class="form-control select2 search " name="nama" id="search_name" style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;" >
                                <option value=""></option>
                            </select> -->
                            <input type="text" id="search_name" name="nama" class="form-control search" placeholder="Search" autocomplete="off" @if($searchEvent == 1) value="{{$param}}" @endif>
<!--                             
                            <select class="form-control select2 search " name="product" id="search_product" style="height:40px;width:70%; border-top: 2px solid #1a70bb; border-bottom: 2px solid #1a70bb;" >
                                <option value=""></option>
                            </select> -->
                            @if(isset($param))
                            @if($param != null)
                                <a href="{{ url('/front_end/research-corner') }}"  class="btn btn-sm btn-default" style=" border-top: 2px solid #1a70bb; border-right: 2px solid #1a70bb;border-bottom: 2px solid #1a70bb;border-left: 2px solid #1a70bb;" title="Reset All Filter"><span class="fa fa-close"></span></a>
                                @endif
                            @endif                        
                            <!-- </div> -->
                            <div class="input-group-prepend">
                                <button type="submit"  class="input-group-text submit" style="border-top-right-radius: 5px;border-bottom-right-radius: 5px; background-color: #1a70bb; border-color: transparent; color: white;" title="Search">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
                            </div>
                        </div>
                    </form>
                </div>
    </div><br>
      <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-12">
          <div class="row shop_wrapper">
          @foreach($research as $key => $data)
            <div class="col-lg-3 col-md-3 col-12 a-modif small" style="height: 100%; padding-top: 20px;" >
            <?php $size = 162; $num_char = 23;?>
            
            <div class="kontennya" style="width: 100%;padding: 12px; background-color: #f8f8f8; border-radius: 10px">
        <?php
          if($loc == "ch"){
            $title = $data->title_en;
            $date = date('d F Y', strtotime($data->publish_date)).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          }elseif($loc == "in"){
            $title = $data->title_in;
            $date = getTanggalIndo(date('Y-m-d', strtotime($data->publish_date))).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          }else{
            $title = $data->title_en;
            $date = date('d F Y', strtotime($data->publish_date)).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          }

          if($for == "admin" || $for == "eksportir"){
            $url = url('/').'/uploads/Research Corner/File/'.$data->exum;
          } else {
            $url = "#";
          }

          $image = 'uploads/Research Corner/Cover/'.$data->cover;
          if($data->cover != null || $data->cover != ''){
            if(file_exists($image)) {
              $image = 'uploads/Research Corner/Cover/'.$data->cover;
            } else {
              $image = '/image/nocover.jpg';
            }
          } else {
            $image = '/image/cover_rc.png';
          }

          if(strlen($title) > $num_char){
              $cut_text = substr($title, 0, $num_char);
              if ($title{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                  $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                  $cut_text = substr($title, 0, $new_pos);
              }
              $titleName = $cut_text . '...';
          }else{
              $titleName = $title;
          }
        ?>
          <div style="width: 100%; height: 75%; margin: auto; text-align: center;">
              <img class="rc" src="{{url('/')}}/{{$image}}" style="height: {{$size}}px;">
          </div>
          <div style="height: 25%; padding-top: 5px;">
              <span style="font-family: arial; font-weight: 500; font-size: 18px;" title="{{$title}}">
                  <strong style="padding-right: 10px;">{{$titleName}}</strong>
{{--                  <span class="badge badge-primary" style="font-size: 11px !important; vertical-align: middle; background-color: #387bbf;">{{getDataDownload($data->id)}}&nbsp;&nbsp;<i class="fa fa-download"></i></span>--}}
              </span>
              <br>
              <span class="detail_rc" style="font-size: 14px;">
              <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$date}}
              <br>
              <a href="{{$url}}" class="detail_rc" onclick="__download('{{$data->id}}', event, this)" style="text-decoration: none;"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;@lang("button-name.donlod")</a>
              </span>
          </div>
            </div>
      </div>
        
      @endforeach

        </div></div></div>
  </div>
  <br><br>
    <div class="row">
      <div class="container">
        <div class="row justify-content-center" align="center">
          {{ $research->render("pagination::bootstrap-4") }}
        </div>
      </div>
    </div>
    <br>
</div>
@include('frontend.layouts.footer')
<script type="text/javascript">
  var login = "{{$for}}";

  function __download(id, e, obj){
    e.preventDefault();

    if(login == 'admin'){
      window.open(obj.href, '_blank');
    } else if(login == 'eksportir'){
      $.ajax({
          url: "{{route('research-corner.download')}}",
          type: 'get',
          data: {id:id},
          dataType: 'json',
          success:function(response){
            if(response){
              window.open(obj.href, '_blank');
            }
          }
      });
    } else {
      alert("{{$message}}");
      if(login == 'non user'){
        window.location.href = "{{url('/login')}}";
      }
    }
  }
</script>
<script>
  $(document).ready(function() { 

      $('#search_country').select2({
          allowClear: true,
          placeholder: 'Search Country',                
          ajax: {
              url: "{{route('countryrc.getcountry')}}",
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                  return {
                      results: $.map(data, function (item) {
                          console.log(item.id);
                          return {
                                text: item.country,
                                id: item.id
                          }
                      })
                  };
              },
              cache: true
          }
      });

      // $('#search_name').select2({
      //     allowClear: true,
      //     placeholder: 'Search Product',
      //     ajax: {
      //         url: "{{route('productrc.getproductrc')}}",
      //         dataType: 'json',
      //         delay: 250,
      //         processResults: function (data) {
      //             return {
      //                 results: $.map(data, function (item) {
      //                 console.log(item.id);
      //                     return {
      //                         text: item.title,
      //                         id: item.id
      //                     }
      //                 })
      //             };
      //         },
      //         cache: true
      //     }
      // });

      $('#search_product').select2({
          allowClear: true,
          placeholder: 'Search Category Product',
          ajax: {
              url: "{{route('categoryrc.getcategory')}}",
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                  return {
                      results: $.map(data, function (item) {
                      console.log(item.id);
                          return {
                              text: item.nama_kategori_en,
                              id: item.id
                          }
                      })
                  };
              },
              cache: true
          }
      });

        
  var search = "{{$searchEvent}}";
  if(search == 2){
      $('#search_country').next('.select2-container').show();
      $('#search_name').hide();
      // $('#search_name').next('.select2-container').hide();
      // $('#search_product').next('.select2-container').show();
  }else{
    
      $('#search_country').next('.select2-container').hide();
      $('#search_name').show();
      // $('#search_name').next('.select2-container').show();
      // $('#search_product').next('.select2-container').hide();
  }
  });


  var searchEvent = "{{isset($searchEvent) ? $searchEvent : ''}}";
  // if(searchEvent == 1){
      // console.log(searchEvent);
      // var param = "{{isset($param) ? $param : '' }}";
      // if (param != "") {
      //     $.ajax({
      //         type: 'GET',
      //         url: "{{route('productrc.getproductrc')}}",
      //         data: { code: param }
      //     }).then(function (data) {
      //     var option = new Option(data[0].title, data[0].id, true, true);

      //     $('#search_name').append(option).trigger('change');
      //     });
      // }
  // }else
   if(searchEvent == 2){
    console.log(searchEvent);
      var param = "{{isset($param) ? $param : '' }}";
      if (param != "") {
          $.ajax({
              type: 'GET',
              url: "{{route('countryrc.getcountry')}}",
              data: { code: param }
          }).then(function (data) {
          var option = new Option(data[0].country, data[0].id, true, true);

          $('#search_country').append(option).trigger('change');
          });
      }

  }
  // else if(searchEvent == 2){
  //     console.log(searchEvent);
  //     var param = "{{isset($param) ? $param : '' }}";
  //     if (param != "") {
  //         $.ajax({
  //             type: 'GET',
  //             url: "{{route('categoryrc.getcategory')}}",
  //             data: { code: param }
  //         }).then(function (data) {
  //             var option = new Option(data[0].nama_kategori_en, data[0].id, true, true);

  //             $('#search_product').append(option).trigger('change');
  //         });
  //     }
  // }



  $('#search').on('change', function(){
      var pilihan = this.value;
      if(pilihan == 1){
          $('#search_country').hide();
          $('#search_name').show();
          // $('#search_product').hide();

          $('#search_country').next('.select2-container').hide();
          // $('#search_name').next('.select2-container').show();
          // $('#search_product').next('.select2-container').hide();
      } else if(pilihan == 2){
          $('#search_country').show();
          $('#search_name').hide();
          
          // $('#search_product').show();

          $('#search_country').next('.select2-container').show();
          // $('#search_name').next('.select2-container').hide();
          // $('#search_product').next('.select2-container').show();
      }
  });

</script>