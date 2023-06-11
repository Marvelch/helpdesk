@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('store_request_ticket')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
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
                                        <input name="image" class="form-control form-control-sm select__image"
                                            type="file" style="width: 80%;">
                                    </div>
                                </div>
                                <!-- <img src="{{asset('./assets/img/3.png')}}" alt="" srcset="" style="max-width: 100%;"> -->
                            </div>
                            <div class="col-md-7 m-2">
                                <div class="form-group">
                                    <label for="">Permintaan Troubleshoot</label>
                                    <input name="title" type="text" class="form-control form-select-sm">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Perusahaan</label>
                                            <select name="company" id="selectCompany"
                                                class="selectCompany form-select form-select-sm text-capitalize">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Devisi</label>
                                            <select name="division" id="selectDivision"
                                                class="selectDivision form-select form-select-sm text-capitalize">
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
                                        <select name="typeOfWork" id="" class="form-control form-control-sm">
                                            @foreach($typeOfWorks as $item)
                                            <option value="{{$item->id}}">{{$item->typeofwork}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Lokasi</label>
                                    <input name="location" type="text" class="form-control form-select-sm">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="description" id="myeditorinstance"></textarea>
                                </div>
                                <div class="text-center col-md-3">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">KIRIM</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#preview_delete').hide();
    $("#selectDivision").prop("disabled", true);

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

        // Autocomplate
        // $('.js-example-basic-single').select2();

        // Company select autocomplate
        $('.selectCompany').select2({
            ajax: {
                url: '{{url("/request-tickets/search-company")}}',
                dataType: 'json',
                processResults: function ({
                    data
                }) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.company
                            }
                        })
                    }
                }
            }
        });

        $('#selectCompany').on('select2:select', function (e) {
            let id = $(this).val();

            if (id) {
                $("#selectDivision").prop("disabled", false);
            } else {
                $("#selectDivision").prop("disabled", true);
            }

            $("#selectDivision").select2({
                ajax: {
                    url: "{{url('request-tickets/search-division')}}/" + id,
                    dataType: 'json',
                    processResults: function ({
                        data
                    }) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.division
                                }
                            })
                        }
                    }
                }
            });
        });
    });

</script>
@endsection
