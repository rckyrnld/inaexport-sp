@include('header')
<style>
    .mycustom {
        border: solid 1px grey;
        position: relative;
    }
    .mycustom input[type=text] {
        border: none;
        width: 100%;
        margin-top: 5px;
        margin-bottom: 5px;
        padding-right: 123px;
    }
    .mycustom .input-group-prepend {
        position: absolute;
        right: 4px;
        top: 4px;
        bottom: 4px;z-index:9;
    }

    .atag:hover{
        text-decoration: underline;
    }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-body bg-light">
                    <div class="row">
                        <div class="col-md-10">
                            <h5><b>Details Inquiry</b></h5>  
                        </div>
                        <div class="col-md-2">
                            @if($cekfile != 0)
                              @if($inquiry->type == "importir")
                                @if($inquiry->status != 3 && $inquiry->status != 4)
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalDeal" style="width: 100%; color: white; font-size: 14px;">Deal</button>
                                @endif
                              @elseif($inquiry->type == "perwakilan" || $inquiry->type == "admin")
                                @if($broadcast->status != 3 && $broadcast->status != 4)
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalDeal" style="width: 100%; color: white; font-size: 14px;">Deal</button>
                                @endif
                              @endif
                            @endif
                        </div>
                    </div><br><br>
                    <div class="row">
                        <label class="col-md-3"><b>Product Name</b></label>
                        <div class="col-md-7">
                            @if($product != NULL)
                            {{$product->prodname_en}}
                            @else
                            {{$inquiry->prodname}}
                            @endif
                        </div>
                    </div><br>
                    @if($product != NULL)
                    <div class="row">
                        <label class="col-md-3"><b>Category Product</b></label>
                        <div class="col-md-7">
                            <?php
                                $cat1 = getCategoryName($product->id_csc_product, "en");
                                $cat2 = getCategoryName($product->id_csc_product_level1, "en");
                                $cat3 = getCategoryName($product->id_csc_product_level2, "en");

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
                        </div>
                    </div><br>
                    @endif
                    <div class="row">
                        <label class="col-md-3"><b>Kind Of Subject</b></label>
                        <div class="col-md-7">
                            {{$inquiry->jenis_perihal_en}}
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Date</b></label>
                        <div class="col-md-7">
                            {{date('d F Y',strtotime($inquiry->date))}}
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Subject</b></label>
                        <div class="col-md-7">
                            {{$inquiry->subyek_en}}
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Messages</b></label>
                        <div class="col-md-7">
                            <?php echo $inquiry->messages_en; ?>
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>File</b></label>
                        <div class="col-md-7">
                            @if($inquiry->file == "")
                                <input type="text" class="btn btn-default" value="Dokumen Kosong" autocomplete="off" readonly style="color: orange; text-align: center;">
                            @else
                                <a href="{{ url('/').'/uploads/Inquiry/'.$inquiry->id }}/{{ $inquiry->file }}" target="_blank" class="btn btn-default" style="color: orange;">{{$inquiry->file}}</a>
                            @endif
                        </div>
                    </div><br>
                    <div class="row">
                        <label class="col-md-3"><b>Status</b></label>
                        <div class="col-md-7">
                            @if($inquiry->type == "importir")
                            <?php if($inquiry->status == 0){ $stat = 1; }else{$stat = $inquiry->status;}?>
                            @elseif($inquiry->type == "perwakilan" || $inquiry->type == "admin")
                            <?php if($broadcast->status == 0){ $stat = 1; }else{$stat = $broadcast->status;}?>
                            @endif
                            @lang('inquiry.stat'.$stat)
                        </div>
                    </div><br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><b>Detail Chat</b></h5>  
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="box" style="max-height: 400px; overflow-y: scroll;overflow-x: hidden; padding: 0px 5px 0px 5px;">
                            <br>
                            <div class="row">
                              <?php
                                $datenya = NULL;
                              ?>
                              @foreach($messages as $msg)
                              @if($msg->sender == $id_user)
                              <div class="col-md-1"></div>
                              <div class="col-md-10">
                                @if($datenya == NULL)
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->created_at));
                                    ?>
                                    <center>
                                        <i>
                                            {{$datenya}}
                                        </i>
                                    </center><br>
                                @else
                                    @if($datenya != date('d-m-Y', strtotime($msg->created_at)))
                                        <?php
                                            $datenya = date('d-m-Y', strtotime($msg->created_at));
                                        ?>
                                        <center>
                                            <i>
                                                {{$datenya}}
                                            </i>
                                        </center><br>
                                    @endif
                                @endif
                                <div class="row pull-right">
                                  <div class="col-md-10">
                                    <label class="label" style="background: #FFD54F; border-radius:10px; width:300px; padding: 10px;">
                                        <b>You</b> :<br>
                                        @if($msg->messages == NULL)
                                            <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: red;">{{$msg->file}}</a><br>
                                        @else
                                            {{$msg->messages}}<br>
                                        @endif
                                        <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                                    </label>
                                  </div>
                                </div>
                              </div><br>
                              <div class="col-md-1"></div>
                              @else
                              <div class="col-md-1"></div>
                              <div class="col-md-10">
                                @if($datenya == NULL)
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->created_at));
                                    ?>
                                    <center>
                                        <i>
                                            {{$datenya}}
                                        </i>
                                    </center><br>
                                @else
                                    @if($datenya != date('d-m-Y', strtotime($msg->created_at)))
                                        <?php
                                            $datenya = date('d-m-Y', strtotime($msg->created_at));
                                        ?>
                                        <center>
                                            <i>
                                                {{$datenya}}
                                            </i>
                                        </center><br>
                                    @endif
                                @endif
                                <div class="row">
                                  <div class="col-md-10">
                                    <label class="label" style="background: #eee; border-radius:10px; width:300px; padding: 10px;">
                                        <b>
                                            @if($inquiry->type == "importir")
                                            {{getCompanyNameImportir($msg->sender)}}
                                            @elseif($inquiry->type == "perwakilan")
                                            {{getPerwakilanName($msg->sender)}}
                                            @elseif($inquiry->type == "admin")
                                            {{getAdminName($msg->sender)}}
                                            @endif
                                        </b> :<br>
                                        @if($msg->messages == NULL)
                                            <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: red;">{{$msg->file}}</a><br>
                                        @else
                                            {{$msg->messages}}<br>
                                        @endif
                                        <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                                    </label>
                                  </div>
                                </div>
                              </div><br>
                              <div class="col-md-1"></div>
                              @endif
                              @endforeach
                            </div><br>
                          </div>
                        </div>
                    </div>
                    @if($inquiry->type == "importir")
                        @if($inquiry->status != 3 && $inquiry->status != 4 && $inquiry->status != 5)
                        <div class="row">
                          <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="messages" value="" id="messages" autocomplete="off">
                                <div class="input-group-append">
                                  <form action="{{route('eksportir.inquiry.fileChat')}}" method="post" enctype="multipart/form-data" id="uploadform">
                                  {{ csrf_field() }}
                                      <button type="button" class="btn btn-default" id="uploading" name="uploading" style="border-color: rgba(120, 130, 140, 0.5);">
                                          <img src="{{asset('image/paperclip.png')}}" width="20px">
                                      </button>
                                      <input type="file" id="upload_file" name="upload_file" style="display: none;" />
                                      <input type="hidden" name="type" id="type" value="{{$inquiry->type}}">
                                      <input type="hidden" name="id_inquiry" id="id_inquiry" value="{{$inquiry->id}}">
                                      <input type="hidden" name="sender" id="sender" value="{{$id_user}}">
                                      <input type="hidden" name="receiver" id="receiver" value="{{$inquiry->id_pembuat}}">
                                  </form>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-2 pull-right">
                          </div>
                        </div><br>
                        @endif
                    @elseif($inquiry->type == "perwakilan" || $inquiry->type == "admin")
                        @if($broadcast->status != 3 && $broadcast->status != 4 && $broadcast->status != 5)
                        <div class="row">
                          <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="messages" value="" id="messages" autocomplete="off">
                                <div class="input-group-append">
                                  <form action="{{route('eksportir.inquiry.fileChat')}}" method="post" enctype="multipart/form-data" id="uploadform">
                                  {{ csrf_field() }}
                                      <button type="button" class="btn btn-default" id="uploading" name="uploading" style="border-color: rgba(120, 130, 140, 0.5);">
                                          <img src="{{asset('image/paperclip.png')}}" width="20px">
                                      </button>
                                      <input type="file" id="upload_file" name="upload_file" style="display: none;" />
                                      <input type="hidden" name="type" id="type" value="{{$inquiry->type}}">
                                      <input type="hidden" name="id_inquiry" id="id_inquiry" value="{{$inquiry->id}}">
                                      <input type="hidden" name="sender" id="sender" value="{{$id_user}}">
                                      <input type="hidden" name="receiver" id="receiver" value="{{$inquiry->id_pembuat}}">
                                  </form>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-2 pull-right">
                          </div>
                        </div><br>
                        @endif
                    @endif
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{url('/inquiry')}}" class="btn btn-danger" style="float: right;"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
  <div class="modal fade" id="modalDeal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <center>
                <h6><b>Are you sure?</b></h6>
                <br>
                <a href="{{url('/inquiry/dealing/'.$inquiry->id.'/1')}}" class="btn btn-primary" style="width: 100px;">Deal</a>&nbsp;OR
                &nbsp;<a href="{{url('/inquiry/dealing/'.$inquiry->id.'/2')}}" class="btn btn-danger" style="width: 100px;">Cancel</a>
            </center>
            <br><br>
        </div>
        
        <!-- Modal footer -->
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> -->
        
      </div>
    </div>
  </div>


@include('footer')
<script>
    $(document).ready(function(){
        //Click Image
        $("#uploading").click(function() {
            $("input[id='upload_file']").click();
        });

        //Upload File
        $("#upload_file").on('change', function() {
            if(this.value != ""){
                $('#uploadform').submit();
            }else{
                alert('The file cannot be uploaded');
            }
        });

        //Send Message
        $('#messages').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                var sender = $('#sender').val();
                var receiver = $('#receiver').val();
                var id_inquiry = $('#id_inquiry').val();
                var type = $('#type').val();
                var msg = this.value;

                
                $.ajax({
                    url: "{{route('eksportir.inquiry.sendChat')}}",
                    type: 'get',
                    data: {from:sender, to:receiver, idinquiry:id_inquiry, messages: msg, file: "", typenya: type},
                    success:function(response){
                        // console.log(response);
                        if(response == 1){
                            location.reload();
                        }else{
                            alert("This message is not delivered!");
                            location.reload();
                        }
                    }
                });
            }
            event.stopPropagation();
        });
    })
</script>
