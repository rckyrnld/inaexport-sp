<p>Dear user, </P>
<p>please verify your account</p>
<p>The following username and password are registered at the Ministry of Trade's InaExport.id :</p>
<ol>
    <ul>Name : {{$nama}}</ul>
    <ul>Email : {{$email}}</ul>
    <ul>Username : {{$username}}</ul>
    <ul>Password : {{$password}}</ul>
</ol>



@if(isset($user))
    <p>Don't forget to upload some required documents</p>
    <ul>
        <li>NPWP(mandatory)</li>
        <li>TDP(optional)</li>
        <li>SIUP(optional)</li>
        <li>NIB(mandatory)</li>
    </ul>
@endif

click <a href="{{url('verifypembeli/'.$id2)}}">here</a> for activation account !.

