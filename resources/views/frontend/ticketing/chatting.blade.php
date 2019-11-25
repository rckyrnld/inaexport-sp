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
                          <span class="chat-user" style="text-transform: capitalize;"><b>Super Admin 
						  @if(Cache::has('user-is-online-' . 1))
    <span class="text-success">Online</span>
@else
    <span class="text-secondary">Offline</span>
@endif</b></span>
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
                                    $datenya = date('d-m-Y', strtotime($msg->messages_send));
                                ?>
                                <center>
                                    <i>
                                        {{$datenya}}
                                    </i>
                                </center><br>
                            @else
                                @if($datenya != date('d-m-Y', strtotime($msg->messages_send)))
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->messages_send));
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
                                    {{$msg->messages}}<br>
                                    <span style="float: right;">{{date('H:i',strtotime($msg->messages_send))}}</span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          @else
                          <!-- <div class="col-md-1"></div> -->
                          <div class="col-md-12">
                            @if($datenya == NULL)
                                <?php
                                    $datenya = date('d-m-Y', strtotime($msg->messages_send));
                                ?>
                                <center>
                                    <i>
                                        {{$datenya}}
                                    </i>
                                </center><br>
                            @else
                                @if($datenya != date('d-m-Y', strtotime($msg->messages_send)))
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->messages_send));
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
                                    {{$msg->messages}}<br>
                                    <span style="color: #555; float: right;">{{date('H:i',strtotime($msg->messages_send))}}</span>
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
                      <form action="{{url('/front_end/ticketing_support/sendchat')}}" method="post" enctype="multipart/form-data" id="formMessageTicket">
                        {{ csrf_field() }}
                        <div class="row">
                          <div class="col-md-11">
                            <textarea id="messages" name="messages" rows="2" class="chat-message"></textarea>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="sender" value="{{$ticket->id_pembuat}}">
                            <input type="hidden" name="statusticket" value="{{$ticket->status}}" id="statusticket">
                            <input type="hidden" name="id" value="{{$ticket->id}}">
                            <input type="hidden" name="reciver" value="0">
                          </div>
                          <div class="col-md-1" style="padding-left: 0px;">
                            <img src="{{asset('front/assets/icon/send-message.png')}}" alt="" width="70%" id="sendmessageticket" />
                          </div>
                        </div>
                      </form>
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
    $alertmsg = "抱歉，无法发送此消息。";
  }else if($loc == "in"){
    $alertmsg = "Maaf, Pesan ini tidak dapat dikirim.";
  }else{
    $alertmsg = "Sorry, this message cannot be sent.";
  }
?>

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function(){
        //Send Message
        $('#sendmessageticket').on('click', function(event){
          var status = $('#statusticket').val();

          if(status == 3){
            alert("{{$alertmsg}}");
            $('textarea#messages').val("");
          }else{
            $('#formMessageTicket').submit();
          }
        });
    });
</script>