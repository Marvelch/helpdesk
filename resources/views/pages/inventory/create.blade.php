@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <form action="{{route('store_inventory')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-5 mb-3 justify-content-md-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nama Barang / Item</label>
                                    <select name="itemsName" data-maximum-selection-length="2" class="itemsName form-control itemsName form-control-sm text-capitalize">
                                        <option value="" selected></option>
                                        @foreach($inventorys as $inventory)
                                            <option value="{{$inventory->id}}">{{$inventory->item_name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" class="itemsId" name="itemsId">
                                    @error('itemsName')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Total Masuk</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-trend-up"></i></span>
                                        <input name="stock" type="number" class="form-control" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                    @error('stock')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Kode Barang</label>
                                    <input type="text" class="form-control form-control-sm">
                                    <input name="item_code" type="hidden" class="itemsId" name="itemsId">
                                    <small class="text-danger" style="font-size: 10px;"><i>* Penginputan kode bisa menggikuti ERP atau Accurate</i></small>
                                    @error('itemsName')
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
                                    <button type="submit" class="btn bg-gradient-info w-30 mt-4 mb-0">simpan</button>
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
