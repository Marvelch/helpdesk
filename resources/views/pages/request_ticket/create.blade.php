@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('store_request_ticket')}}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="row mt-5 mb-3 justify-content-md-center">
                            <div style="margin-left: 53%; margin-bottom: 2%;">
                                <h3 class="font-roboto">Permintaan Tiket</h3>
                                <p style="font-size: 12px;">Pembuatan tiket dengan melengkapi form penginputan berikut</p>
                            </div>
                            <div class="col-sm-6 small" style="margin-left: 30px;">
                                <div class="form-group">
                                    <input name="title" type="text" class="form-control form-select-sm" placeholder="Permintaan Troubleshoot">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name="company" id="selectCompany"
                                                class="selectCompany form-select form-select-sm text-capitalize">
                                                <option value="" selected>Pilih Perusahaan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name="division" id="selectDivision"
                                                class="selectDivision form-select form-select-sm text-capitalize">
                                                <option value="" selected>Pilih Devisi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fa-duotone fa-location-pin-lock"></i></span>
                                        <input type="text" name="location" class="form-control form-control-sm"
                                            aria-label="Username" aria-describedby="basic-addon1" placeholder="Lokasi">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="typeOfWork" id="" class="form-control form-control-sm">
                                        <option value="" selected>Pilih Jenis Pekerjaan</option>
                                        @foreach($typeOfWorks as $item)
                                        <option value="{{$item->id}}">{{$item->typeofwork}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="file" name="attachment"
                                        class="form-control form-control-sm select__image">
                                </div>
                                <div class="form-group">
                                    <textarea name="description" id="" class="form-control form-control-sm" cols="30"
                                        rows="5" placeholder="Keterangan"></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="text-center col-md-3">
                                        <button type="submit"
                                            class="btn bg-gradient-info w-100 mt-4 mb-0 btn-sm">KIRIM</button>
                                    </div>
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
            const id = $(this).val();

            $(".selectDivision").select2({
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
