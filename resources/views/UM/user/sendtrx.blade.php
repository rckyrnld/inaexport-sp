<div align="center" style="width: 100%">
  <div align="center" style="width: 580px;">
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
    <p style="text-align: left">Dear {{($bur== '-')? '':$bur." "}}{{$receiver}}, </P>
    <p style="text-align: left">{{($bu== '-')? '':$bu." "}}{{$username}} Had Created Transaction</p>
    <hr>
    <!-- <ol>
        <ul>Name : {{$username}}</ul>
        <ul>Email : {{$email}}</ul>
    </ol>
    <hr>-->
    <p style="text-align: left">
      <!-- {{$main_messages}} -->
    </p>
    <p style="text-align: left">click <a href="{{url('detailtrx', $id)}}">Here</a>.</p>
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
  </div>
</div>