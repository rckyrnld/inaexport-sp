<div align="center" style="width: 100%">
  <div align="center" style="width: 580px;">
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail2.jpg" alt="." >
    <p style="text-align: left">Dear {{$receiver}}, </P>
    <p style="text-align: left">{{($bu== '-')? '':$bu}} {{$username}} Respond Chat On Buying Request</p>
    <hr>
    <!-- <ol>
        <ul>Name : {{$username}}</ul>
        <ul>Email : {{$email}}</ul>
    </ol>
    <hr>-->
    <p style="text-align: left">
      <!-- {{$main_messages}} -->
    </p>
    <p style="text-align: left">click <a href="{{url('br_chat', $id)}}">Here</a>.</p>
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail2.jpg" alt="." >
  </div>
</div>
