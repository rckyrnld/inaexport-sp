@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
    .modal-md{ width: 600px; }
    .style-font{ font-size: 18px; font-weight: 700; color: black; }
    #broadcast{ background-color: #29bbd8; } #broadcast:hover{ background-color: #1cabc7; }
    #close{ background-color: #f92222; } #close:hover{ background-color: #f10000; }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Newsletter</h5>
                </div>

                <div class="box-body bg-light">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            {{--                            <button type="button" class="close" data-dismiss="alert">×</button>--}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{--                                <button type="button" class="close" data-dismiss="alert">×</button>--}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                	<a id="tambah" href="{{route('newsletter.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>&nbsp;&nbsp;

                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="table" class="table table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th width="10%">No</th>
					              <th>About</th>
                                  <th>Messages</th>
                                  <th width="12%">Status</th>
					              <th width="20%">Action</th>
					          </tr>
					      </thead>
					    </table>
					  </div>
      	  			</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Broadcast -->
    <div class="modal fade" id="modal_broadcast" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="background-color: transparent;">
                <div class="modal-body" style="height: 220px; background-color: #ffc000; border-radius: 15px;">
                    {!! Form::open(['url' => route('newsletter.broadcast'), 'class' => 'form-horizontal', 'files' => true]) !!}
                        <input type="hidden" name="newsletter" id="newsletter">
                        <div class="row" style="margin-bottom: 30px;">
                            <div class="col-md-12 style-font" align="center">Validation</div>
                        </div>
                        <div class="row justify-content-center" style="margin-bottom: 30px;">
                            <div class="col-md-10 style-font" align="center">Are you sure to share this information to Newsletter ?</div>
                        </div>
                        <table width="100%">
                            <tr>
                                <td width="50%"><button type="submit" class="btn text-white" id="broadcast" style="width: 70%">Broadcast</button></td>
                                <td width="50%"><button class="btn text-white" id="close" data-dismiss="modal" aria-label="Close" style="width: 70%">Cancel</button></td>
                            </tr>
                        </table>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@include('footer')
<script type="text/javascript">
	$(document).ready(function () {
        $(".alert").slideDown(300).delay(2000).slideUp(500);
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('newsletter.getData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'about', name: 'about'},
                {data: 'messages', name: 'messages'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
    function broadcast(id) {
        $('#newsletter').val(id);
        $('#modal_broadcast').modal('show');
    }
</script>