@include('frontend.layouts.header')
<style type="text/css">
  .chat-container{
    width: 100%;
    background-color: white;
    border-radius: 30px;
  }

  .chat-header{
    width: 100%;
    height: 5%;
    background-color: #DDEFFD;
    border-radius: 30px 30px 0px 0px;
    padding: 2% 2% 2% 3%;
  }

  .chat-user{
    font-size: 15px;
    font-family: 'Verdana';
  }

  .chat-body{
    height: 500px;
    max-height: 500px;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 2%;
    font-size: 15px;
  }

  .chat-footer{
    width: 100%;
    height: 5%;
    border-top: 2px solid #87c4ee;
    border-radius: 0px 0px 30px 30px;
    padding: 1% 1% 1% 1%;
  }

  .chat-message{
    border: 1.5px solid #4088C6;
    height: 100%;
    width: 100%;
    border-radius: 10px;
    resize: none;
    padding: 1%;
    font-size: 15px;
  }

  .chat-me{
    background: #2492EB; 
    border-radius: 10px 0px 10px 10px;
    width: 400px;
    padding: 10px;
    color: white;
  }

  .chat-other{
    background: #DDEFFD;
    border-radius: 0px 10px 10px 10px;
    width: 400px;
    padding: 10px;
  }

  #uploading2{
    cursor: pointer;
    transition: 0.3s;
  }

  #uploading2:hover{
    opacity: 0.7;
  }

  #sendmessage{
    cursor: pointer;
    transition: 0.3s;
  }

  #sendmessage:hover{
    opacity: 0.7;
  }

  .chat-back:hover{
    opacity: 0.7;
  }
</style>
<?php
  $loc = app()->getLocale();
?>
    <!--product details start-->
      <div class="product_details mt-20" style="background-color: #1A70BB; margin-bottom: 0px !important; margin-top: 0px; font-size: 14px;">
          <div class="container">
            <br><br>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="chat-container">
                    <div class="chat-header">
                      <div class="row">
                        <div class="col-md-1">
                          <br>
                          <a href="{{url('/front_end/history')}}" style="width: 100%; height: 100%;" class="chat-back">
                            <i class="fa fa-arrow-left" aria-hidden="true" style="color: #1A70BB; font-size: 40px;"></i>
                          </a>
                        </div>
                        <div class="col-md-1" style="padding-left: 0px;">
                          <img src="{{asset('front/assets/icon/user.png')}}" alt="" width="100%" />
                        </div>
                        <div class="col-md-4" style="padding-left: 0px;">
                          <span class="chat-user" style=""><b>Chat</b></span>
                          <br>
                          <span class="chat-user" style="text-transform: capitalize;"><b>{{getCompanyName($data->id_itdp_company_user)}}</b>&nbsp;&nbsp;<img src="{{asset('front/assets/icon/icon-exportir.png')}}" alt="" /></span>
                        </div>
                      </div>
                    </div>
                    <div class="chat-body">
                      <div class="row">
                        <?php
                          $datenya = NULL;
                        ?>
                        @foreach($messages as $msg)
                          @if($msg->sender == $id_user)
                          <div class="col-md-12">
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
                                <label class="label chat-me">
                                    @if($msg->messages == NULL)
                                        <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: white;">{{$msg->file}}</a><br>
                                    @else
                                        {{$msg->messages}}<br>
                                    @endif
                                    <span style="float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          @else
                          <!-- <div class="col-md-1"></div> -->
                          <div class="col-md-12">
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
                                <label class="label chat-other">
                                    @if($msg->messages == NULL)
                                        <a href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}" target="_blank" class="atag" style="color: white;">{{$msg->file}}</a><br>
                                    @else
                                        {{$msg->messages}}<br>
                                    @endif
                                    <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->created_at))}}</span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          <!-- <div class="col-md-1"></div> -->
                          @endif
                        @endforeach
                      </div>
                    </div>
                    <div class="chat-footer">
                      <div class="row">
                        <div class="col-md-1">
                          <form action="{{route('front.inquiry.fileChat')}}" method="post" enctype="multipart/form-data" id="uploadform2">
                            {{ csrf_field() }}
                            <img src="{{asset('front/assets/icon/plus-circle.png')}}" alt="" width="100%" id="uploading2" />
                            <input type="file" id="upload_file2" name="upload_file2" style="display: none;" />
                            <input type="hidden" name="sender2" id="sender2" value="{{$id_user}}">
                            <input type="hidden" name="id_inquiry2" id="id_inquiry2" value="{{$inquiry->id}}">
                            <input type="hidden" name="type2" id="type2" value="{{$inquiry->type}}">
                            <input type="hidden" name="receiver2" id="receiver2" value="{{$data->id_itdp_company_user}}">
                            <input type="hidden" name="statusmsg2" id="statusmsg2" value="{{$inquiry->status}}">
                          </form>
                        </div>
                        <div class="col-md-10" style="padding-left: 0px;">
                          <textarea id="messages2" name="messages2" rows="2" class="chat-message"></textarea>
                        </div>
                        <div class="col-md-1" style="padding-left: 0px;">
                          <img src="{{asset('front/assets/icon/send-message.png')}}" alt="" width="70%" id="sendmessage" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <br><br>
          </div>
      </div>
  <!--product details end-->
<?php
  if($loc == "ch"){
    $alertimage = "抱歉，无法发送此文件。";
    $alertmsg = "抱歉，无法发送此消息。";
  }else if($loc == "in"){
    $alertimage = "Maaf, Dokumen ini tidak dapat dikirim.";
    $alertmsg = "Maaf, Pesan ini tidak dapat dikirim.";
  }else{
    $alertimage = "Sorry, this document cannot be sent.";
    $alertmsg = "Sorry, this message cannot be sent.";
  }
?>

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function(){
        //Click Image
        $("#uploading2").click(function() {
            $("input[id='upload_file2']").click();
        });

        //Upload File
        $("#upload_file2").on('change', function() {
            if(this.value != ""){
              var status = $('#statusmsg2').val();
              if(status == 3 || status == 4 || status == 5){
                alert("{{$alertimage}}");
              }else{
                $('#uploadform2').submit();
              }
            }else{
                alert('The file cannot be uploaded');
            }
        });

        //Send Message
        $('#sendmessage').on('click', function(event){
          var sender = $('#sender2').val();
          var receiver = $('#receiver2').val();
          var id_inquiry = $('#id_inquiry2').val();
          var type = $('#type2').val();
          var msg = $('textarea#messages2').val();
          var status = $('#statusmsg2').val();

          if(status == 3 || status == 4 || status == 5){
            alert("{{$alertmsg}}");
            $('textarea#messages2').val("");
          }else{
            $.ajax({
                url: "{{route('eksportir.inquiry.sendChat')}}",
                type: 'get',
                data: {from:sender, to:receiver, idinquiry:id_inquiry, messages: msg, file: "", typenya: type},
                success:function(response){
                    if(response == 1){
                        location.reload();
                    }else{
                        alert("This message is not delivered!");
                        location.reload();
                    }
                }
            });
          }
        });
    });
</script>