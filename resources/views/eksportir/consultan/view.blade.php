@include('header')
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            {{ csrf_field() }}
            <div class="box">
                @foreach($data as $val)
                    {{-- <div class="box-header">
                    </div> --}}
                    <div class="box-divider m-0"></div>
                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Name</label>
                                <input disabled type="text"
                                       class="form-control" value="{{$val->nama_pegawai}}" name="name">
                                {{--                                <label>Year</label>--}}
                                {{--                                <select class="atc form-control select2" required id="year"--}}
                                {{--                                        name="year">--}}
                                {{--                                    <option value="">- Select Years -</option>--}}
                                {{--                                    @foreach($years as $sa)--}}
                                {{--                                        <option value="{{$sa}}">{{$sa}}</option>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </select>--}}
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Position</label>
                                <input disabled type="text" value="{{$val->jabatan}}"
                                       class="form-control" name="posotion">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Phone</label>
                                <input disabled type="text" value="{{$val->telepon}}"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       class="form-control" name="phone">
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Official</label>
                                <input disabled type="text" value="{{$val->pejabat}}"
                                       class="form-control" name="pejabat">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label style="font-weight:bold" for="problem">Problem</label>
                                <textarea disabled class="form-control" id="problem"
                                          name="problem">{{$val->masalah}}</textarea>
                            </div>

                            <div class="form-group col-sm-6">
                                <label style="font-weight:bold" for="solution">Solution</label>
                                <textarea disabled type="text" class="form-control" name="solution"
                                          id="solution">{{$val->solusi}}</textarea>
                            </div>
                        </div>
                        <br>

                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <input type="hidden" value="{{$val->id}}" class="form-control" name="id_sales"
                                       id="id_sales">
                            </div>
                            <div class="form-group col-sm-6">
                                <a style="color: white" href="{{ URL::previous() }}"
                                   class="btn btn-danger pull-right"><i style="color: white"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{--            </form>--}}
        </div>
    </div>
</div>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('problem');
    CKEDITOR.replace('solution');
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
        $('#STAT').on('change', function () {
            var val = $('#STAT').val().split("|");
            var nama = val[0];
            var instansi = val[1];
            // alert(gambar);
            $('#institusi').val(instansi);

        });
        $('#tanggal_registrasi').val(new Date().toDateInputValue());
        $("#email").keyup(function () {
            var uname = $("#email").val();
            // alert(uname);
            $.get('{{url("getem")}}/' + uname, function (data) {
                console.log(data);
                if (data == 0) {
                    $('#cekl').html("<font color='green'>Tersedia</font>");
                } else {
                    $('#cekl').html("<font color='red'>Telah digunakan</font>");
                }
                // $('#alot').html(data);
            });
        });
        $('#provinsiku').on('change', function () {
            var json = null;
            var id = this.value;

            $.get('{{URL::to("getkab")}}/' + id, function (data) {
                $('#kabupatenku').val(null).trigger('change');
                json = JSON.parse(data);
                var test = null;
                // console.log("##PANJANGNYA =" + json.length)
                test =
                    "<option class='' disabled='' selected='' value='0'>-PILIH KABUPATEN-</option>";
                for (i = 0; i < json.length; i++) {

                    test += "<option  class='' value='" + json[i].id +
                        "'>" + json[i].nama_kab + "</option>";

                }
                $('#kabupatenmu').show();
                $('#kabupatenku').html(test);
                $('#kabupatenku').trigger('change');
            });

        });
        $("#confirm_password").keyup(function () {
            var password = $("#password").val();
            var cpassword = $("#confirm_password").val();
            if (cpassword == password) {
                $('#cek2').html("<font color='green'>Sama</font>");
            } else {
                $('#cek2').html("<font color='red'>Tidak Sama</font>");
            }
            // $('#alot').html(data);

        });
    });
    Date.prototype.toDateInputValue = (function () {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#tgl_mulai_berlaku").change(function () {
        $("#label_tkeanggotaan").css("display", "none");
        $("#tipe_keanggotaan").css("display", "block");

        var val = $("#tipe_keanggotaan").val().split("|");
        var periode = val[1];
        // alert(periode);

        var date = new Date(this.value);
        var current = new Date();

        var month = (date.getMonth() < 10) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
        var hari = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();
        var result = hari + "-" + month + "-" + (Number(date.getFullYear()) + Number(periode));

        $("#tanggal_kadaluarsa").val(result);
    });

    $("#tipe_keanggotaan").change(function () {
        $("#label_tkadaluarsa").css("display", "none");
        $("#tanggal_kadaluarsa").css("display", "block");

        var val = this.value.split("|");
        var periode = val[1];

        var date = new Date($('#tgl_mulai_berlaku').val());
        var current = new Date();

        var month = (date.getMonth() < 10) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
        var hari = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();
        var result = hari + "-" + month + "-" + (Number(date.getFullYear()) + Number(periode));

        $("#tanggal_kadaluarsa").val(result);

    });

    $("#imgInp").change(function () {
        readURL(this);
    });
</script>

@include('footer')
