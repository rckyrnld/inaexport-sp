@include('header')
<style type="text/css">
	th {text-align: center;}
	td {color: black;}
	#tambah { background-color: #1a9cf9; color: white; white-space: pre;}
	#tambah:hover {background-color: #148de4}
	#export { background-color: #28bd4a; color: white; white-space: pre;}
	#export:hover {background-color: #08b32e}
</style>
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Category Product</h5>
                </div>

                <div class="box-body bg-light">
                	<a id="tambah" href="{{route('management.category-product.create')}}" class="btn">   <i class="fa fa-plus-circle"></i>  Add   </a>
                    <button class="btn" type="button" data-toggle="modal" data-target="#modal-show">   <i class="fa fa-hashtag"></i>  Setting Show   </button>
                    <div class="col-md-14"><br>
		          	 <div class="table-responsive">
					    <table id="table" class="table  table-bordered table-striped" data-plugin="dataTable">
					      <thead class="text-white" style="background-color: #1089ff;">
					          <tr>
					              <th>No</th>
					              <th>Product (EN)</th>
					              <th>Product (INA)</th>
					              <th>Product (CHN)</th>
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

<!-- MODAL EO -->
    <div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Show on Home</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
        <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('management.category-product.home') }}">
            {{ csrf_field() }}
            <?php 
                for ($i=1; $i <= 6; $i++) { 
                    ${"cat_$i"} = cat_prod_home($i);
                }
            ?>
            <table width="100%" cellpadding="5">
                <tr>
                    <td>Category 1</td>
                    <td>
                        <select class="form-control" id="cat1" required name="cat1" style="width:100%;">
                            <option></option>
                            @foreach($product as $data)
                                <option value="{{$data->id}}" @if($data->id == $cat_1) selected @endif>{{$data->nama_kategori_en}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>Category 2</td>
                    <td>
                        <select class="form-control" id="cat2" required name="cat2" style="width:100%;">
                           <option></option>
                            @foreach($product as $data)
                                <option value="{{$data->id}}" @if($data->id == $cat_2) selected @endif>{{$data->nama_kategori_en}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Category 3</td>
                    <td>
                        <select class="form-control" id="cat3" required name="cat3" style="width:100%;">
                           <option></option>
                            @foreach($product as $data)
                                <option value="{{$data->id}}" @if($data->id == $cat_3) selected @endif>{{$data->nama_kategori_en}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>Category 4</td>
                    <td>
                        <select class="form-control" id="cat4" required name="cat4" style="width:100%;">
                           <option></option>
                            @foreach($product as $data)
                                <option value="{{$data->id}}" @if($data->id == $cat_4) selected @endif>{{$data->nama_kategori_en}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Category 5</td>
                    <td>
                        <select class="form-control" id="cat5" required name="cat5" style="width:100%;">
                           <option></option>
                            @foreach($product as $data)
                                <option value="{{$data->id}}" @if($data->id == $cat_5) selected @endif>{{$data->nama_kategori_en}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>Category 6</td>
                    <td>
                        <select class="form-control" id="cat6" required name="cat6" style="width:100%;">
                           <option></option>
                            @foreach($product as $data)
                                <option value="{{$data->id}}" @if($data->id == $cat_6) selected @endif>{{$data->nama_kategori_en}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>
@include('footer')
<script type="text/javascript">
	$(document).ready(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('management.category-product.getData') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nama_kategori_en', name: 'nama_kategori_en'},
                {data: 'nama_kategori_in', name: 'nama_kategori_in'},
                {data: 'nama_kategori_chn', name: 'nama_kategori_chn'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#cat1').select2({
          placeholder: 'Select Category'
        });
        $('#cat2').select2({
          placeholder: 'Select Category'
        });
        $('#cat3').select2({
          placeholder: 'Select Category'
        });
        $('#cat4').select2({
          placeholder: 'Select Category'
        });
        $('#cat5').select2({
          placeholder: 'Select Category'
        });
        $('#cat6').select2({
          placeholder: 'Select Category'
        });
    });
</script>