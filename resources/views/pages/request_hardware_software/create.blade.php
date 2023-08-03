@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <form action="{{route('store_request_hardware_software')}}" method="post">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card-body shadow-sm p-4 mb-5 bg-white rounded">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-4">
                                    <h6 style="font-family: var(--bs-font-roboto);">Permintaan Hardware dan Software
                                    </h6>
                                    <p style="font-size: 12px;">Data permintaan dari pengguna akan tercatat sesuai
                                        username yang sedang login</p>
                                </div>
                                <div class="table table-responsive">
                                    <table class="table table-borderless">
                                        <thead style="font-size: 12px;">
                                            <tr>
                                                <td class="w-15 fw-bold">Nama Pengguna</td>
                                                <td class="text-capitalize">: {{Str::ucfirst(Auth::user()->name)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Perusahaan</td>
                                                <td>: {{@Str::ucfirst(Auth::user()->company->company)}} -
                                                    {{@Str::ucfirst(Auth::user()->division->division)}}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4 small">
                                <label for="" class="mt-4">Keterangan Permintaan</label>
                                <textarea name="requestDescription" id="" cols="10" rows="3" class="form-control w-90" style="font-size: 12px;"></textarea>
                            </div>
                        </div>
                        <!-- <div class="form-check">
                            <input class="form-check-input checkbox" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-capitalize" for="flexCheckDefault"
                                style="font-size: 12px; font-family: var(--bs-font-roboto);">
                                Permintaan dari pengguna login
                            </label>
                        </div>
                        <div class="row name_desc">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Lengkap</label>
                                    <input name="requestsFromUsers" type="text" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <input name="descriptionFromUsers" type="text" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <form action="{{route('store_request_hardware_software')}}" method="post">
                        @csrf
                        <div class="table-responsive mt-5">
                            <table class="table table-stiped" id="myTable">
                                <thead>
                                    <tr style="font-size: 12px;">
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 33.3%; text-transform:uppercase;">
                                            <select name="itemName[]" id=""
                                                    class="itemName form-control form-control-sm">
                                                    <!-- @foreach($inventorys as $inventory)
                                                    <option name="">{{$inventory->item_name}}</option>
                                                    @endforeach -->
                                                </select>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="qty[]" class="form-control form-control-sm" required>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="description[]"
                                                class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <i class="new-button fa-solid fa-circle-plus color-primary fa-lg"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group mt-4">
                            <div class="text-center d-flex justify-content-end">
                                <button type="submit" class="btn bg-gradient-info w-15 mt-4 mb-0">simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var i = 0;
    $('.new-button').on('click', function () {
        ++i;
        $('tbody').append(
            "<tr> <td style='width: 33.3%; text-transform:uppercase;'> <div class='form-group'> <select name='itemName[]' id='' class='itemName" +
            i +
            " form-control form-control-sm'> </select> </div> </td> <td style='width: 33%; padding: 10px;'> <div class='form-group'> <input required name='qty[]' type='text' class='form-control form-control-sm'> </div> </td> <td style='width: 33%; padding: 10px;'> <div class='form-group'> <input type='text' name='description[]' class='form-control form-control-sm'> </div> </td> <td> <div class='form-group'> <i class='remove-button fa-solid fa-circle-minus fa-lg' style='color: #ec2727;'></i> </div> </td> </tr>"
        ).delay(800).fadeIn(400);
        // $('.itemName' + i + '').select2({
        //     tags: true
        // });
        $('.itemName' + i + '').select2({
            ajax: {
                url: '{{url("/request-hardware-software/searching-inventory")}}',
                dataType: 'json',
                processResults: function ({
                    data
                }) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.item_name
                            }
                        })
                    }
                }
            }
        });
    });

    // $(".itemName").select2({
    //     tags: true
    // });

    $('.itemName').select2({
        ajax: {
            url: '{{url("/request-hardware-software/searching-inventory")}}',
            dataType: 'json',
            processResults: function ({
                data
            }) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.item_name
                        }
                    })
                }
            }
        }
    });

    $(document).on('click', '.remove-button', function () {
        $(this).closest('tr').remove();
    });

    $("input[type=checkbox]").on("change", function () {
        if ($(this).prop('checked')) {
            $('.name_desc').hide();
        } else {
            $('.name_desc').show();
        }
    });

</script>
@endsection
