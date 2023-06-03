@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{asset('./assets/img/1.png')}}" alt="" srcset=""
                                style="max-width: 100%;">
                        </div>
                        <div class="col-md-8">
                                <form action="{{url('/bank-accounts/store')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Pilih Pengguna</label>
                                        <select name="user_id" class="form-select form-control-sm text-capitalize" aria-label=".form-select-sm example">
                                            @foreach($items as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Anydesk</label>
                                        <div class="mb-3">
                                            <input type="anydesk" name="anydesk" class="form-control form-control-sm" aria-label="anydesk"
                                                aria-describedby="anydesk">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>IP Address</label>
                                        <div class="mb-3">
                                            <input type="text" name='ipaddress' class="form-control form-control-sm" aria-label="ipaddress"
                                                aria-describedby="ipaddress">
                                        </div>
                                    </div>
                                    <div class="text-center col-md-3">
                                        <button type="submit"
                                            class="btn bg-gradient-info w-100 mt-4 mb-0">simpan</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
