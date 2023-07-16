@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="ticket__tables dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                                    aria-labelledby="dropdownTable">
                                    <li><a class="dropdown-item border-radius-md small" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"><i class="fa-regular fa-barcode-read"
                                                style="margin-right: 10px;"></i>
                                            Scan Barang</a></li>
                                </ul>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Inventori Scan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <label for="">Scan Barcode Disini :</label>
                                                <form action="{{route('store_barcode_transaction_inventory')}}"
                                                    method="post">
                                                    @csrf
                                                    <input type="text" name="barcode"
                                                        class="form-control form-control-sm barcode__scanner">
                                                    <div class="form-group mt-2">
                                                        <div class="table-responsive">
                                                            <table class="table mt-2 table-striped table-sm">
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" class="btn btn-secondary m-1"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary m-1">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{route('store_transaction_inventory')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row mt-3 title__row justify-content-md-center">
                            <div class="col-md-7 title ">
                                <div class="form-group"
                                    style="margin-left: 40px; margin-bottom: -15px; margin-top: 15px;">
                                    <h5><i class="fa-solid fa-scanner-gun fa-xl"></i> <span>Pengelolaan
                                            Inventory</span></h5>
                                    <p class="sub__title">Transaksi barang masuk untuk inventory Teknologi
                                        Informasi</p>
                                </div>
                                <div class="card bg-white rounded">
                                    <div class="card-body m-2">
                                        <div class="form-group">
                                            <label for="">Nama Barang</label>
                                            <select name="item_name" value="{{old('item_name')}}"
                                                class="itemsName form-control form-control-sm text-capitalize">
                                                @foreach($inventorys as $inventory)
                                                <option value="{{$inventory->item_name}}"
                                                    {{old('item_name') == $inventory->item_name ? "selected" : ""}}>
                                                    {{$inventory->item_name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" class="itemsId" name="itemsId">
                                            @error('item_name')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Total Masuk</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fa-sharp fa-regular fa-scanner-touchscreen"
                                                        style="color: #e03939;"></i></span>
                                                <input name="stock" value="{{old('stock')}}" type="number"
                                                    class="form-control form-control-sm" aria-label="Username"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                            @error('stock')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan</label>
                                            <textarea name="description" id="" cols="10" rows="5"
                                                class="form-control form-control-sm">{{old('description')}}</textarea>
                                            @error('description')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn bg-gradient-info w-30 mt-4 mb-0">simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(".itemsName").select2({
        tags: true,
    });

    $(".barcode__scanner").keypress(function (event) {
        if (event.which == '10' || event.which == '13') {
            event.preventDefault();
            const result = $(this).val();
            console.log(result);
            $.ajax({
                url: "{{route('scan_inventory')}}",
                type: 'post',
                data: {
                    _token: CSRF_TOKEN,
                    barcode: result
                },
                dataType: 'json',
                success: function (reponse) {
                    console.log(reponse);
                    if (reponse) {

                    }
                    $('tbody').empty();
                    $('tbody').append('<tr><td>Kode Inventori</td><td>' + reponse.inventory_unique +
                        '</td></tr><tr style="font-size: 12px; vertical-align: middle;"><td>Nama Barang</td><td>' +
                        reponse.item_name +
                        '</td></tr><tr><td style="font-size: 12px; vertical-align: middle;">Jumlah Masuk</td><td><input type="text" name="qty" class="form-control form-control-sm"></td></tr>'
                    );
                }
            });
        }
        // if (event.which == '10' || event.which == '13') {
        //     const result = this.val();
        //     if (event.which == '10' || event.which == '13') {
        //         event.preventDefault();
        //         $.ajax({
        //             url: "{{route('scan_inventory')}}",
        //             type: 'post',
        //             data: {
        //                 _token: CSRF_TOKEN,
        //                 barcode: result
        //             },
        //             dataType: 'json',
        //             success: function (response) {
        //                 console.log(response);
        //             }
        //         });
        //     }

        // }
    });
    // $('.itemsName').on('change keyup', function() {
    //     let itemsId = $('input[name=itemsName]').val()
    //     alert(itemsId);
    //     // $('input[type=text].itemsId').val();
    // });

    // $('.itemsName').select2({
    //         ajax: {
    //             url: '{{url("/inventory/search/items")}}',
    //             dataType: 'json',
    //             processResults: function ({
    //                 data
    //             }) {
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             id: item.id,
    //                             text: item.item_name
    //                         }
    //                     })
    //                 }
    //             }
    //         }
    //     });

</script>
@endsection
