<div align="center" style="width: 100%">
  <div align="center" style="width: 580px;">
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail2.jpg" alt="." >
    <p style="text-align: left">Dear Admin, </P>
    <p style="text-align: left">{{($bu== '-')? '':$bu}} {{$username}} Had Created Transaction</p>
    <hr>
    <!-- <ol>
        <ul>Name : {{$username}}</ul>
        <ul>Email : {{$email}}</ul>
    </ol>
    <hr>-->
{{--    <p style="text-align: left">--}}
{{--       {{$main_messages}}--}}
{{--    </p>--}}
    click <a href="{{url($url, $id)}}">Here</a>.
    <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail2.jpg" alt="." >
  </div>
</div>
