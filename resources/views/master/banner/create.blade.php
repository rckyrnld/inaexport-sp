@include('header')
<style type="text/css">
  .button_form{width: 80px}
  input[type="text"], input[type="text"]:focus{
    border-color: #d6d9daad;
  }
</style>
<?php 
  if($page == 'view'){
    $view = 'disabled';
  } else {
    $view = '';
  }
?>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Form </h4>
      	 </div>
      	 <div class="box-body">
          <div class="col-md-12">
          <form class="form-horizontal" method="POST" action="{{ route('master.banner.store', $page) }}" enctype="multipart/form-data">
           {{ csrf_field() }}<br>
            <div class="alert alert-info">File image harus beresolusi 1583x231.
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
              </button>
            </div>
            <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Nama Banner</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" id="nama" name="nama" required>
                 </div>
            </div>
            <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">File Image</label>
                 <div class="col-md-7">
                     <input type="file" class="form-control" id="file_img" name="file_img" required>
                 </div>
            </div>
            <div class="row" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 10px;">
              <div class="col-md-12"><label><b>Product Category</b></label></div><br>
              <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px; max-height: 450px;">
                  <input type="text" id="search1" name="search1" class="form-control" onInput="searchsub(1)">
                  <div id="prod1" class="list-group" style="height: 430px; overflow-y: auto;">
                      @foreach($catprod as $cp)
                          <a href="#" class="list-group-item list-group-item-action listbag1" onclick="getSub(1,'{{$cp->id}}', '', '{{$cp->nama_kategori_en}}', event)" id="kat1_{{$cp->id}}" data-value="{{$cp->id}}">{{$cp->nama_kategori_en}}</a>
                      @endforeach
                  </div>
              </div>
              <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                  <div id="tmpsearch2">

                  </div>
                  <div id="prod2" class="list-group" style="height: 430px; overflow-y: auto;">
                      
                  </div>
              </div>
              <div class="col-md-4" style="border: 1px solid rgba(120, 130, 140, 0.13); padding: 5px;">
                  <div id="tmpsearch3">

                  </div>
                  <div id="prod3" class="list-group" style="height: 430px; overflow-y: auto;">
                      
                  </div>
              </div>
              <div class="col-md-2" style="margin-top: 20px;"><label><b>Select</b></label></div>
              <div class="col-md-8" style="margin-top: 20px;">
                  <span id="select_1"></span>
                  <input type="hidden" name="id_csc_product" id="id_csc_product">
                  <span id="select_2"></span>
                  <input type="hidden" name="id_csc_product_level1" id="id_csc_product_level1">
                  <span id="select_3"></span>
                  <input type="hidden" name="id_csc_product_level2" id="id_csc_product_level2">
              </div>
            </div>
            
             
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    @if($page != 'view')
                    <button class="btn btn-primary button_form" type="submit">Save</button>
                    @endif
                    <a href="{{url('master-banner')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
                  </div>
                </div>
             </div>
          </form>
          </div>
      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')
<script type="text/javascript">
  $(document).ready(function () {
    
  });
  function searchsub(suba){
        if(suba == 1){
            var tes = document.getElementById("search1");
            var s = tes.value;
            var value = "kosong";
            var value2 = "kosong";
            $('#tmpsearch2').html('');
            $('#tmpsearch3').html('');
            $('#prod2').html('');
            $('#prod3').html('');
        }else if(suba==2){
            var items = document.getElementsByClassName("list-group-item listbag1 active");
            var value = $(items).attr('data-value');
            var tes = document.getElementById("search2");
            var s = tes.value;
            var value2 = "kosong";
            $('#tmpsearch3').html('');
            $('#prod3').html('');
        }else{
            var items = document.getElementsByClassName("list-group-item listbag1 active");
            var value = $(items).attr('data-value');
            var items2 = document.getElementsByClassName("list-group-item listbag2 active");
            var value2 = $(items2).attr('data-value');
            var tes = document.getElementById("search3");
            var s = tes.value;
        }

        $.ajax({
            url: "{{route('eksproduct.searchsub')}}",
            type: 'get',
            data: {level:suba, text:s,parent:value,parent2:value2},
            success:function(response){
                // console.log(response);
                if(suba == 1){
                    $('#prod1').html(response);
                }
                else if(suba == 2){
                    $('#prod2').html(response);
                }else{
                    $('#prod3').html(response);
                }
            }
        });

    }
  function getSub(sub, idp, ids, name, evt) {
        evt.preventDefault();
        if(sub == 3){
            $('#select_3').text('> '+name);
            $('#id_csc_product_level2').val(ids);
            $('.listbag3').removeClass('active');
            $('#kat3_'+ids).addClass('active');
        }else{
            if(sub == 1){
                $('#select_1').text(name);
                $('#cadprod_en').text(name);
                $('#id_csc_product').val(idp);
                $('#select_2').text('');
                $('#id_csc_product_level1').val('');
                $('#select_3').text('');
                $('#id_csc_product_level2').val('');
                $('#prod2').html('');
                $('#prod3').html('');
                $('.listbag1').removeClass('active');
                $('#kat1_'+idp).addClass('active');
                $('#tmpsearch2').html('');
                $('#tmpsearch3').html('');
            }else{
                $('#select_2').text(' >'+name);
                $('#id_csc_product_level1').val(ids);
                $('#select_3').text('');
                $('#id_csc_product_level2').val('');
                $('#prod3').html('');
                $('.listbag2').removeClass('active');
                $('#kat2_'+ids).addClass('active');
                $('#tmpsearch3').html('');
            }
            $.ajax({
                url: "{{route('eksproduct.getSub')}}",
                type: 'get',
                data: {level:sub, idparent:idp, idsub:ids},
                success:function(response){
                    // console.log(response);
                    if(sub == 1){
                        $('#prod2').html(response);
                        $('#tmpsearch2').html("<input type=\"text\" id=\"search2\" name=\"search2\" class=\"form-control\" onInput=\"searchsub(2)\">");
                    }else{
                        $('#prod3').html(response);
                        $('#tmpsearch3').html("<input type=\"text\" id=\"search3\" name=\"search3\" class=\"form-control\" onInput=\"searchsub(3)\">");
                    }
                }
            });
        }
    }
</script>