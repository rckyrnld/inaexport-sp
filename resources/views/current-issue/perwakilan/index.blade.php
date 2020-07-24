@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#button:link, #button:visited, #button:active{color: white;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
	input:read-only{background-color: white !important}
  /*CSS MODAL*/
  .modal-lg{ width: 700px; }
  .modal-header { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
  .modal-body{ height: 300px; }
  .modal-content { border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 20px; overflow: hidden;}
  .modal-footer { background-color: #84afd4; color: white; font-size: 20px; text-align: center;}
  #Tablemodal td {
    text-align: left !important;
  }
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Current Issue</h5>
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

                	<a id="tambah" href="{{route('perwakilan.curris.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>
                    <div class="col-md-12"><br>
                        <div class="table-responsive">
                          <table id="table-curris" class="table  table-bordered table-striped" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #1089ff;">
                                <tr>
                                    <th width="7%">No</th>
                                    <th>Title (EN)</th>
                                    <th>Country</th>
                                    <th>Publish Date</th>
                                    <th width="15%">Action</th>
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


@include('footer')
<script type="text/javascript">
	$(document).ready(function() {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#table-curris').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('perwakilan.curris.getData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title_en', name: 'title_en', orderable: false, searchable: false},
                {data: 'country', name: 'country', orderable: false, searchable: false},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

		$('#categori').select2({
      sorter: function(data) {
        return data.sort(function(a, b) {
            return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
        });
    }
    }).on("select2:select", function (e) { 
      $('.select2-selection__rendered li.select2-selection__choice').sort(function(a, b) {
          return $(a).text() < $(b).text() ? -1 : $(a).text() > $(b).text() ? 1 : 0;
        }).prependTo('.select2-selection__rendered');
    });
  });

	function broadcast(id) {
		$('#categori').val('');
		$('#categori').trigger('change');
	    var data = id.split("||");
	    $('#title_en').val(data[0]);
	    $('#research').val(data[1]);
	    $('#modal_broadcast').modal('show');
	  }
</script>