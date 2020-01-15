<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail2.jpg" alt="." >
        <p style="text-align: left">Dear User, </P>
        <p style="text-align: left">Super Admin Respond Chat On Your Ticketing Request</p>
        <hr>
        <!-- <ol>
            <ul>Name : {{$username}}</ul>
            <ul>Email : {{$email}}</ul>
        </ol>
        <hr>-->
        <p style="text-align: left">
          {{$main_messages}}
        </p>
        <hr>
        <p style="text-align: left;">click <a href="{{url('front_end/ticketing_support/chatview', $id)}}">Here</a>.</p>
        <img height="50%" width="100%" src="{{url('assets')}}/assets/images/footeremail.jpg" alt="." >
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail2.jpg" alt="." >
    </div>
</div>