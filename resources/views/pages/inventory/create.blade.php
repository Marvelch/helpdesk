@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <form action="{{route('store_inventory')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-3 mb-3 title__row justify-content-md-center">
                            <div class="col-md-7 title p-4">
                                <div class="card" style="background-image: url('{{asset('./assets/img/background/1.jpg')}}');">
                                    <div class="card-body">
                                        <div class="form-group p-4">
                                            <h5><i class="fa-solid fa-box-circle-check fa-xl"></i> <span>Penginputan
                                                    Inventory</span></h5>
                                            <p class="sub__title">Pengelolaan penyimpanan untuk inventori dikelolah
                                                Teknologi
                                                Informasi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-2 shadow-lg p-3 mb-5 bg-white rounded">
                                    <div class="card-body m-2">
                                        <div class="form-group">
                                            <label for="">Nama Barang / Item</label>
                                            <select name="itemsName" value="{{old('itemsName')}}"
                                                class="itemsName form-control form-control-sm text-capitalize">
                                                <option selected></option>
                                                @foreach($inventorys as $inventory)
                                                <option value="{{$inventory->item_name}}"
                                                    {{old('itemsName') == $inventory->item_name ? "selected" : ""}}>
                                                    {{$inventory->item_name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" class="itemsId" name="itemsId">
                                            @error('itemsName')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Total Masuk</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fa-solid fa-arrow-trend-up"></i></span>
                                                <input name="stock" value="{{old('stock')}}" type="number"
                                                    class="form-control form-control-sm" aria-label="Username"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                            @error('stock')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kode Barang</label>
                                            <input name="itemCode" type="text" class="form-control form-control-sm">
                                            <small class="text-danger" value="{{old('itemCode')}}"
                                                style="font-size: 10px;"><i>*
                                                    Penginputan kode bisa menggikuti ERP atau
                                                    Accurate</i></small>
                                            @error('itemCode')
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
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(".itemsName").select2({
        tags: true,
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
