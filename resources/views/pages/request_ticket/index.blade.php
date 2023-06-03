@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row font-raleway">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="d-flex justify-content-center">
                                    <div class="card shadow mt-5">
                                        <div class="card-body">
                                            <!-- <div class="preview_image font-raleway text-center" id="preview__images"></div> -->
                                            <img class="preview_image">
                                            <i class="fa-solid fa-square-minus fa-beat fa-trash-can-position"
                                                id="preview_delete" title="Delete"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-3 d-flex justify-content-center">
                                    <input name="image" class="form-control form-control-sm select__image" type="file"
                                        style="width: 80%;">
                                </div>
                            </div>
                            <!-- <img src="{{asset('./assets/img/3.png')}}" alt="" srcset="" style="max-width: 100%;"> -->
                        </div>
                        <div class="col-md-7 m-2">
                            <div class="form-group">
                                <label for="">Permintaan Troubleshoot</label>
                                <input type="text" class="form-control form-select-sm">
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Perusahaan</label>
                                            <select name="user_id" class="form-select form-select-sm text-capitalize"
                                                aria-label=".form-select-sm example">
                                                @foreach($companys as $items)
                                                <option value="{{$items->id}}">{{$items->company}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Devisi</label>
                                            <select name="user_id" class="form-select form-select-sm text-capitalize"
                                                aria-label=".form-select-sm example">
                                                @foreach($divisions as $items)
                                                <option value="{{$items->id}}">{{$items->division}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tenggat waktu</label>
                                            <div class="mb-3">
                                                <input type="date" name="deadline" class="form-control form-select-sm"
                                                    aria-label="deadline" aria-describedby="deadline"
                                                    value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="">Jenis Pekerjaan</label>
                                        <select name="" id="" class="form-control form-control-sm">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Lokasi</label>
                                    <input type="text" class="form-control form-select-sm">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea id="myeditorinstance"></textarea>
                                </div>
                                <div class="text-center col-md-3">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">KIRIM</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#preview_delete').hide();

    $(document).ready(function () {
        $(".select__image").on("change", function () {

            /* Current this object refer to input element */
            var $input = $(this);
            var reader = new FileReader();

            reader.onload = function () {
                $(".preview_image").attr("src", reader.result);
            }
            reader.readAsDataURL($input[0].files[0]);

            if ($(".select__image").val()) {
                $('#preview_delete').show();
            } else {
                $('#preview_delete').hide();
            }
        });

        $('#preview_delete').on('click', function () {
            $("input[name=image]").val('');
            $('.preview_image').removeAttr('src');
        });
    });

</script>
@endsection
